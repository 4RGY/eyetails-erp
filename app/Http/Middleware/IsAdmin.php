<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah pengguna sudah login DAN apakah dia seorang admin.
        if (Auth::check() && Auth::user()->is_admin) {
            // 2. Jika ya, izinkan dia melanjutkan ke halaman berikutnya.
            return $next($request);
        }

        // 3. Jika tidak, tolak aksesnya dengan menampilkan halaman error 403 (Forbidden).
        abort(403, 'ANDA TIDAK MEMILIKI AKSES KE HALAMAN INI.');
    }
}
