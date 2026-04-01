<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function edit(){ $admin=Admin::findOrFail(session('admin_id')); return view('admin.account',compact('admin')); }
    public function update(Request $request){
        $admin=Admin::findOrFail(session('admin_id'));
        $data=$request->validate(['nom'=>'required|string|max:100','email'=>'required|email|unique:admins,email,'.$admin->id]);
        $admin->update($data); session(['admin_nom'=>$admin->nom]);
        return back()->with('success','Profil mis à jour.');
    }
    public function updatePassword(Request $request){
        $admin=Admin::findOrFail(session('admin_id'));
        $request->validate(['mot_de_passe_actuel'=>'required','nouveau_mot_de_passe'=>'required|min:10|confirmed']);
        if(!$admin->verifyPassword($request->mot_de_passe_actuel)) return back()->with('error','Mot de passe actuel incorrect.');
        $admin->update(['mot_de_passe'=>password_hash($request->nouveau_mot_de_passe,PASSWORD_BCRYPT,['cost'=>12])]);
        return back()->with('success','Mot de passe mis à jour.');
    }
}
