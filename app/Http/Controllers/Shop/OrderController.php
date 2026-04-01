<?php
// app/Http/Controllers/Shop/OrderController.php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\Address;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    const WHATSAPP = '573117899152'; // Format international sans +

    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) return redirect()->route('cart.show');

        $total = array_sum(array_map(fn($i) => $i['prix'] * $i['cantidad'], $cart));
        return view('shop.checkout', compact('cart', 'total'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) return redirect()->route('cart.show');

        $data = $request->validate([
            'nombre'         => 'required|string|max:100',
            'apellido'       => 'required|string|max:100',
            'email'          => 'required|email|max:150',
            'telefono'       => 'required|string|max:30',
            'direccion'      => 'required|string|max:250',
            'ciudad'         => 'required|string|max:100',
            'barrio'         => 'nullable|string|max:120',
            'notas'          => 'nullable|string|max:500',
            'metodo_pago'    => 'required|in:Nequi,Daviplata,Efectivo,Transferencia',
            'coupon_code'    => 'nullable|string|max:50',
        ]);

        DB::beginTransaction();
        try {
            // Client
            $customer = Customer::firstOrCreate(
                ['email' => $data['email']],
                ['prenom' => $data['nombre'], 'nom' => $data['apellido'], 'telephone' => $data['telefono'], 'actif' => 1]
            );

            // Adresse
            $address = Address::create([
                'client_id'   => $customer->id,
                'prenom'      => $data['nombre'],
                'nom'         => $data['apellido'],
                'rue'         => $data['direccion'],
                'barrio'      => $data['barrio'] ?? null,
                'ciudad'      => $data['ciudad'],
                'pais'        => 'Colombia',
                'telefono'    => $data['telefono'],
                'por_defecto' => 1,
            ]);

            // Calcul totaux
            $sous_total = array_sum(array_map(fn($i) => $i['prix'] * $i['cantidad'], $cart));
            $remise     = 0;
            $coupon     = null;

            if (! empty($data['coupon_code'])) {
                $coupon = Coupon::where('code', strtoupper($data['coupon_code']))->first();
                if ($coupon && $coupon->isValid()) {
                    $remise = $coupon->type_remise === 'pourcent'
                        ? round($sous_total * $coupon->valeur / 100)
                        : $coupon->valeur;
                    $coupon->increment('utilisations_actuelles');
                }
            }

            $total = max(0, $sous_total - $remise);

            // Numéro de commande unique
            $numero = 'CB-' . date('Y') . str_pad(Order::count() + 1, 4, '0', STR_PAD_LEFT);

            // Commande
            $order = Order::create([
                'client_id'       => $customer->id,
                'adresse_id'      => $address->id,
                'numero_commande' => $numero,
                'statut'          => 'en_attente',
                'sous_total'      => $sous_total,
                'remise'          => $remise,
                'frais_livraison' => 0,
                'total'           => $total,
                'coupon_code'     => $coupon ? $coupon->code : null,
                'methode_paiement'=> $data['metodo_pago'],
                'notes'           => $data['notas'] ?? null,
                'snap_adresse'    => json_encode($address->toArray()),
            ]);

            // Lignes
            foreach ($cart as $item) {
                OrderItem::create([
                    'commande_id'   => $order->id,
                    'variante_id'   => $item['variante_id'],
                    'nom_produit'   => $item['nom_produit'],
                    'label_variante'=> $item['label_variante'],
                    'quantite'      => $item['cantidad'],
                    'prix_unitaire' => $item['prix'],
                    'sous_total'    => $item['prix'] * $item['cantidad'],
                ]);
            }

            DB::commit();
            
	    // Envoyer notification email
try {
    \Mail::to('diana@choco-bless.com')
        ->send(new \App\Mail\NouvelleCommande($order));
} catch (\Exception $e) {
    \Log::error('Email notification failed: ' . $e->getMessage());
}

	    session()->forget('cart');

            return redirect()->route('order.confirmation', $numero);

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Hubo un error al procesar tu pedido. Intenta de nuevo.');
        }
    }

    public function confirmation(string $numero)
    {
        $order = Order::with(['items','customer','address'])
            ->where('numero_commande', $numero)->firstOrFail();
        $whatsapp_url = $this->buildWhatsAppUrl($order);
        return view('shop.confirmation', compact('order', 'whatsapp_url'));
    }

    public function whatsapp()
    {
        $cart  = session()->get('cart', []);
        $total = array_sum(array_map(fn($i) => $i['prix'] * $i['cantidad'], $cart));

        $msg = "🍫 *Hola ChocoBless!* Quiero hacer un pedido:\n\n";
        foreach ($cart as $item) {
            $msg .= "• {$item['nom_produit']} ({$item['label_variante']}) x{$item['cantidad']} = " . number_format($item['prix'] * $item['cantidad'], 0, ',', '.') . " COP\n";
        }
        $msg .= "\n*Total: " . number_format($total, 0, ',', '.') . " COP*\n";
        $msg .= "\nPor favor indíqueme los detalles de entrega 🙏";

        $url = 'https://wa.me/' . self::WHATSAPP . '?text=' . rawurlencode($msg);
        return redirect($url);
    }

    private function buildWhatsAppUrl(Order $order): string
    {
        $msg = "🍫 *Pedido #{$order->numero_commande} confirmado!*\n\n";
        foreach ($order->items as $item) {
            $msg .= "• {$item->nom_produit} ({$item->label_variante}) x{$item->quantite}\n";
        }
        $msg .= "\n*Total: " . number_format($order->total, 0, ',', '.') . " COP*";
        $msg .= "\nMétodo de pago: {$order->methode_paiement}";
        return 'https://wa.me/' . self::WHATSAPP . '?text=' . rawurlencode($msg);
    }
}
