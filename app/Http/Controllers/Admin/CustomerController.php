<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::withCount('orders')->orderByDesc('cree_le');
        if ($request->filled('q')) {
            $query->where(fn($q)=>$q->where('email','like','%'.$request->q.'%')->orWhereRaw("CONCAT(prenom,' ',nom) LIKE ?",['%'.$request->q.'%']));
        }
        if ($request->filled('statut')) $query->where('actif',$request->statut==='actif'?1:0);
        $customers = $query->paginate(20)->withQueryString();
        return view('admin.customers.index', compact('customers'));
    }
    public function show(Customer $customer)
    {
        $customer->load(['orders'=>fn($q)=>$q->orderByDesc('cree_le')->limit(10)]);
        return view('admin.customers.show', compact('customer'));
    }
    public function toggle(Customer $customer)
    {
        $customer->update(['actif'=>!$customer->actif]);
        return back()->with('success',$customer->actif?'Client activé.':'Client désactivé.');
    }
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return back()->with('success','Client supprimé.');
    }
}
