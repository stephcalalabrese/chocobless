<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('customer')->orderByDesc('cree_le');
        if ($request->filled('q')) {
            $query->where('numero_commande','like','%'.$request->q.'%')
                  ->orWhereHas('customer',fn($q)=>$q->whereRaw("CONCAT(prenom,' ',nom) LIKE ?",['%'.$request->q.'%']));
        }
        if ($request->filled('statut')) $query->where('statut',$request->statut);
        $orders  = $query->paginate(20)->withQueryString();
        $statuts = Order::STATUTS;
        return view('admin.orders.index', compact('orders','statuts'));
    }
    public function show(Order $order)
    {
        $order->load(['customer','items','address']);
        $statuts = Order::STATUTS;
        return view('admin.orders.show', compact('order','statuts'));
    }
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['statut'=>'required|in:'.implode(',',array_keys(Order::STATUTS))]);
        $order->update(['statut'=>$request->statut]);
        return back()->with('success','Statut mis à jour.');
    }
}
