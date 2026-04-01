<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! session()->has('admin_id')) {
            return redirect()->route('admin.login')->with('error', 'Veuillez vous connecter.');
        }
        $admin = \App\Models\Admin::find(session('admin_id'));
        if (! $admin || ! $admin->actif) {
            session()->flush();
            return redirect()->route('admin.login')->with('error', 'Compte désactivé.');
        }
        view()->share('authAdmin', $admin);
        return $next($request);
    }
}
