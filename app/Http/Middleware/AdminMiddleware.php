<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->rol_id == 1) {
            return $next($request);
        }
        
        return redirect()->route('dashboard')->with('error', 'No tens permís per accedir al panell d\'administració');
    }
}