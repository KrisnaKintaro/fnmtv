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
        // 1. Kalau belum login
        if (!Auth::check()) {
            // Cek apakah request dari fetch/ajax/api
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Anda harus login terlebih dahulu!'
                ], 401); // 401 Unauthorized
            }

            // Kalau dari browser biasa, lempar ke halaman login
            return redirect()->route('login');
        }

        // 2. Kalau rolenya nggak sesuai dengan yang diminta
        if (!in_array(Auth::user()->role, $roles)) {
            // Cek apakah request dari fetch/ajax/api
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Akses ditolak! Role anda tidak cocok buat aksi ini.'
                ], 403); // 403 Forbidden
            }

            // Kalau dari browser biasa, tampilin halaman error 403
            abort(403, 'Hey, anda tidak punya akses ke sini!');
        }

        return $next($request);
    }
}
