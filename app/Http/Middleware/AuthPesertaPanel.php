<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $statusPeserta = auth()->user()?->pesertaMagang?->status;

        if (! in_array($statusPeserta, ['diterima', 'aktif', 'selesai'], true)) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/peserta/login')
                ->withErrors([
                    'email' => 'Akun Anda belum disetujui admin dan belum dapat digunakan untuk login.',
                ]);
        }

        return $next($request);
    }
}
