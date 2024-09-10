<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Ensure the authenticated user is an admin
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // Return an unauthorized response if the user is not an admin
        return response()->json(['error' => 'Unauthorized'], 403);
    }
}
