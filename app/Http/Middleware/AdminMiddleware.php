<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if admin is logged in
        if (!Session::get('admin_logged_in')) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // Clear any remaining session data
            Session::forget([
                'admin_logged_in',
                'admin_id',
                'admin_username',
                'admin_name',
                'admin_email',
                'admin_role'
            ]);

            return redirect()->route('admin.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Add no-cache headers to prevent caching
        $response = $next($request);

        if (method_exists($response, 'header')) {
            $response->header('Cache-Control', 'no-cache, no-store, must-revalidate');
            $response->header('Pragma', 'no-cache');
            $response->header('Expires', '0');
        }

        return $response;
    }
}
