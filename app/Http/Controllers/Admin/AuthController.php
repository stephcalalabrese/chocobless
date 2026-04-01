<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session()->has('admin_id')) return redirect()->route('admin.dashboard');
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'        => 'required|email',
            'mot_de_passe' => 'required|string',
        ]);
        $admin = Admin::where('email', $request->email)->first();
        if (! $admin || ! $admin->verifyPassword($request->mot_de_passe)) {
            return back()->withInput(['email' => $request->email])
                         ->with('error', 'Email ou mot de passe incorrect.');
        }
        if (! $admin->actif) {
            return back()->with('error', 'Compte désactivé.');
        }
        $admin->update(['derniere_connexion' => now()]);
        session(['admin_id' => $admin->id, 'admin_role' => $admin->role, 'admin_nom' => $admin->nom]);
        return redirect()->route('admin.dashboard')->with('success', "Bienvenue, {$admin->nom} !");
    }

    public function logout(Request $request)
    {
        session()->flush();
        return redirect()->route('admin.login')->with('success', 'Déconnecté.');
    }
}
