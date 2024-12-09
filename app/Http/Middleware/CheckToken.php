<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckToken
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Periksa apakah token ada dalam session
        if (!$request->session()->has('token')) {
            // Jika token tidak ada, redirect atau return response error
            return redirect()->route('login')->withErrors(['error' => 'Token not found. Please log in.']);
        }

        // Jika token ada, lanjutkan ke request berikutnya
        return $next($request);
    }
}
