<?php
// app/Http/Controllers/Shop/CartController.php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'variante_id' => 'required|exists:product_variants,id',
            'cantidad'    => 'required|integer|min:1|max:20',
        ]);

        $variante = ProductVariant::with('product')->findOrFail($request->variante_id);
        $cart     = session()->get('cart', []);
        $key      = 'v_' . $variante->id;

        if (isset($cart[$key])) {
            $cart[$key]['cantidad'] += $request->cantidad;
        } else {
            $cart[$key] = [
                'variante_id'   => $variante->id,
                'produit_id'    => $variante->produit_id,
                'nom_produit'   => $variante->product->nom,
                'label_variante'=> $variante->label,
                'prix' 		=> (float) ($variante->prix_promo ?: $variante->prix),
		'imagen'        => $variante->product->image_principale,
                'cantidad'      => $request->cantidad,
            ];
        }

        session()->put('cart', $cart);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success'   => true,
                'message'   => '¡Producto agregado al carrito!',
                'cart_count'=> array_sum(array_column($cart, 'cantidad')),
            ]);
        }

        return redirect()->route('cart.show')->with('success', '¡Producto agregado al carrito!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'variante_id' => 'required',
            'cantidad'    => 'required|integer|min:0|max:20',
        ]);

        $cart = session()->get('cart', []);
        $key  = 'v_' . $request->variante_id;

        if ($request->cantidad == 0) {
            unset($cart[$key]);
        } elseif (isset($cart[$key])) {
            $cart[$key]['cantidad'] = $request->cantidad;
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.show');
    }

    public function remove(int $varianteId)
    {
        $cart = session()->get('cart', []);
        unset($cart['v_' . $varianteId]);
        session()->put('cart', $cart);
        return redirect()->route('cart.show')->with('success', 'Producto eliminado.');
    }

    public function show()
    {
        $cart  = session()->get('cart', []);
        $total = array_sum(array_map(fn($i) => $i['prix'] * $i['cantidad'], $cart));
        return view('shop.cart', compact('cart', 'total'));
    }

    // Helper global accessible depuis les vues
    public static function count(): int
    {
        $cart = session()->get('cart', []);
        return array_sum(array_column($cart, 'cantidad'));
    }

    public static function total(): float
    {
        $cart = session()->get('cart', []);
        return array_sum(array_map(fn($i) => $i['prix'] * $i['cantidad'], $cart));
    }
}
