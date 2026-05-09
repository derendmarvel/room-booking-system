<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * This middleware ensures that only authenticated users
     * with the 'admin' role can access the protected routes.
     *
     * If the user is not authenticated or does not have the
     * admin role, the request is aborted with a 403 response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and has admin role
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // Block access if user is not an admin
        abort(403, 'Unauthorized');
    }
}