<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Cek apakah user sudah login
        if (!auth()->check()) {
            abort(403, 'Kamu belum login.');
        }

        // 2. Ambil data role user dari database
        $userRole = auth()->user()->role;

        // 3. Amankan jika role berbentuk Enum (ambil string value-nya)
        $roleValue = method_exists($userRole, 'value') ? $userRole->value : $userRole;

        // 4. Cocokkan dengan role yang diminta di Route
        if ($roleValue !== $role) {
            abort(403, 'Maaf, akun kamu tidak punya akses ke halaman ini!');
        }

        return $next($request);
    }
}