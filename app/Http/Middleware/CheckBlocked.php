<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckBlocked
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Periksa apakah user sudah login dan apakah akunnya diblokir
        if (Auth::check() && Auth::user()->is_blocked) {
            
            // Hancurkan session dan log out user secara paksa
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Pindahkan ke halaman login dengan pesan error
            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda telah ditangguhkan/diblokir. Silakan hubungi admin.'
            ]);
        }

        return $next($request);
    }
}
