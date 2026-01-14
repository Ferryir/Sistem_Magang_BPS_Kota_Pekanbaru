<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated with 'pegawai' guard
        if (Auth::guard('pegawai')->check()) {
            // Get the authenticated Pegawai
            $pegawai = Auth::guard('pegawai')->user();

            // Check if Pegawai has the role "admin" or "regular"
            if (in_array($pegawai->role_temp, ['admin', 'regular'])) {
                return $next($request);
            }
        }

        // If not authenticated or not an admin, logout and redirect
        Auth::guard('pegawai')->logout();
        return redirect('');
    }
}
