<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfNotAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            return redirect('/dashboard'); // redirect user biasa
        }

        return $next($request);
    }
}
