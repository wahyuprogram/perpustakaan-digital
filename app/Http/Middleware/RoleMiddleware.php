<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Cek apakah role user yang login ada di dalam daftar role yang diizinkan ($roles)
        if (in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }

        // 3. Jika rolenya tidak cocok, tampilkan halaman error 403 (Terlarang)
        abort(403, 'Maaf, Anda tidak memiliki akses ke halaman ini.');
    }
}