<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today     = now()->toDateString();
        $thisMonth = now()->format('Y-m');
        $stats = [
            'commandes_aujourd_hui'    => Order::whereDate('cree_le', $today)->count(),
            'commandes_ce_mois'        => Order::where('cree_le', 'like', "{$thisMonth}%")->count(),
            'ca_ce_mois'               => Order::where('cree_le', 'like', "{$thisMonth}%")->whereNotIn('statut',['annulee','remboursee'])->sum('total'),
            'clients_total'            => Customer::count(),
            'commandes_en_attente'     => Order::where('statut','en_attente')->count(),
            'commandes_en_preparation' => Order::whereIn('statut',['confirmee','en_preparation','prete'])->count(),
            'produits_actifs'          => Product::where('actif',1)->count(),
        ];
        $dernieres_commandes = Order::with('customer')->orderByDesc('cree_le')->limit(8)->get();
        $revenus_semaine = Order::select(DB::raw('DATE(cree_le) as jour'), DB::raw('SUM(total) as total'))
            ->where('cree_le', '>=', now()->subDays(6)->startOfDay())
            ->whereNotIn('statut',['annulee','remboursee'])
            ->groupBy('jour')->orderBy('jour')->get();
        return view('admin.dashboard', compact('stats','dernieres_commandes','revenus_semaine'));
    }
}
