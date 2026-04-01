<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index(){ $coupons=Coupon::orderByDesc('id')->paginate(20); return view('admin.coupons.index',compact('coupons')); }
    public function create(){ return view('admin.coupons.form'); }
    public function store(Request $request){
        $data=$request->validate(['code'=>'required|string|max:50|unique:coupons,code','type_remise'=>'required|in:pourcent,fixe','valeur'=>'required|numeric|min:0','montant_minimum'=>'nullable|numeric|min:0','utilisations_max'=>'nullable|integer|min:1','date_expiration'=>'nullable|date','actif'=>'boolean']);
        $data['code']=strtoupper($data['code']); $data['actif']=$request->boolean('actif',true);
        Coupon::create($data); return redirect()->route('admin.coupons.index')->with('success','Coupon créé.');
    }
    public function edit(Coupon $coupon){ return view('admin.coupons.form',compact('coupon')); }
    public function update(Request $request, Coupon $coupon){
        $data=$request->validate(['code'=>'required|string|max:50|unique:coupons,code,'.$coupon->id,'type_remise'=>'required|in:pourcent,fixe','valeur'=>'required|numeric|min:0','montant_minimum'=>'nullable|numeric|min:0','utilisations_max'=>'nullable|integer|min:1','date_expiration'=>'nullable|date','actif'=>'boolean']);
        $data['code']=strtoupper($data['code']); $data['actif']=$request->boolean('actif');
        $coupon->update($data); return redirect()->route('admin.coupons.index')->with('success','Coupon mis à jour.');
    }
    public function destroy(Coupon $coupon){ $coupon->delete(); return back()->with('success','Coupon supprimé.'); }
    public function toggle(Coupon $coupon){ $coupon->update(['actif'=>!$coupon->actif]); return back()->with('success','Statut mis à jour.'); }
}
