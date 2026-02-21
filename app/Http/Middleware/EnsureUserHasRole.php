<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     * Mendukung multiple roles dengan OR logic.
     * Contoh: middleware('role:super_admin,admin_registrasi')
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // 1. Cek apakah user sudah login
        if (!$request->user()) {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES.');
        }

        $userRole = $request->user()->role;

        // Semua role yang dianggap "admin" (untuk alias 'admin')
        $allAdminRoles = ['super_admin', 'admin_humas', 'admin_registrasi', 'admin_umum', 'admin'];

        // 2. Cek apakah userRole cocok dengan salah satu role yang diminta (OR logic)
        foreach ($roles as $role) {
            if ($role === 'admin') {
                // Alias 'admin' = izinkan semua role admin
                if (in_array($userRole, $allAdminRoles)) {
                    return $next($request);
                }
            } else {
                // Role spesifik: exact match
                if ($userRole === $role) {
                    return $next($request);
                }
            }
        }

        // Tidak ada role yang cocok
        abort(403, 'ANDA TIDAK MEMILIKI AKSES. Role Anda: ' . $userRole . '. Diperlukan: ' . implode(' atau ', $roles));
    }
}
