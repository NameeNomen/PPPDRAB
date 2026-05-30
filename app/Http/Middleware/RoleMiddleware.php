<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // 1. CEK LOGIN DULU: Kalau belum login, ya tendang ke login page
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. CEK ROLE: Kalau login tapi rolenya gak sesuai, jangan di-redirect ke login!
        // Kasih 403 (Forbidden) biar dia sadar diri gak punya akses.
        if (Auth::user()->role !== $role) {
            abort(403, 'Akses ditolak! Lu bukan divisi yang berhak masuk sini.');
        }

        // 3. Kalau lolos dua-duanya, baru boleh lanjut
        return $next($request);
    }
}