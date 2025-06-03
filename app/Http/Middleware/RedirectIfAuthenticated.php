<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        // Check if admin is already logged in
        if (Session::get('admin_logged_in')) {
            // If accessing admin login page while already logged in, redirect to dashboard
            if ($request->routeIs('admin.login')) {
                return redirect()->route('admin.dashboard');
            }
        }

        return $next($request);
    }
}
