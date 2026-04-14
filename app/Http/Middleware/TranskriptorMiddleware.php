<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class TranskriptorMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'transkriptor') {
            return $next($request);
        }

        return redirect('/login')->with('error', 'Anda tidak memiliki akses.');
    }
}
