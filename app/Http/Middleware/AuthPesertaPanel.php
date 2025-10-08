<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthPesertaPanel
{
    public function handle(Request $request, Closure $next): Response
    {
        // Izinkan halaman publik
        if ($request->is('peserta/register') || $request->is('peserta/login')) {
            return $next($request);
        }

        // Kalau belum login
        if (!auth()->check()) {
            return redirect('/peserta/login');
        }

        // Hanya untuk role peserta
        if (auth()->user()?->role !== 'peserta') {
            abort(403, 'Hanya peserta yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}
