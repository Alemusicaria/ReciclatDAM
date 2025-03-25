<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckSocialLogin
{
    public function handle($request, Closure $next)
    {
        if (session('social_login') && Auth::check()) {
            view()->share('showSetPasswordModal', true);
        }

        return $next($request);
    }
}