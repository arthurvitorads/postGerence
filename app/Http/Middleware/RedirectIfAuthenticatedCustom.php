<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticatedCustom
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            return redirect('/home');
        }

        return $next($request);
    }
}
