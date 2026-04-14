<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class OwnerMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'owner') {
            return $next($request);
        }

        return redirect('/login')->with('error', 'Anda tidak memiliki akses.');
    }
}
