<?php

namespace App\Http\Middleware;

use Closure;

class CheckHasHome
{
    public function handle($request, Closure $next)
    {
        if (auth()->check() && !auth()->user()->has_home) {
            return redirect('/'); // Redirect to the home page or any other page you prefer
        }

        return $next($request);
    }
}
