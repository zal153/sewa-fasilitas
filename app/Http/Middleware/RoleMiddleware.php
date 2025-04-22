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
        if (Auth::check()) {
            if (is_array($roles)) {
                foreach ($roles as $role) {
                    if (Auth::user()->role === $role) {
                        return $next($request);
                    }
                }
            }
            // Jika hanya satu role (misal: role:admin)
            else if (Auth::user()->role === $roles[0]) {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized');
    }
}
