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
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Kalau belum login, lempar ke halaman login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Kalau rolenya nggak sesuai dengan yang diminta, tendang balik
        if (!in_array(Auth::user()->role, $roles)) {
            abort(403, 'HEy, lu nggak punya akses ke sini!');
        }

        return $next($request);
    }
}
