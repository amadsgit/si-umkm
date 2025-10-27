<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticatedToDashboard
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            switch ($user->role) {
                case 'admin':
                    return redirect()->route('dashboard.admin');
                case 'umkm':
                    return redirect()->route('dashboard.umkm.index');
                case 'konsultan':
                    return redirect()->route('dashboard.konsultan.index');
                case 'kepala_uptd':
                    return redirect()->route('dashboard.kepalauptd.index');
                default:
                    Auth::logout();
                    return redirect()->route('login')->with('error', 'Role tidak dikenali.');
            }
        }

        return $next($request);
    }
}
