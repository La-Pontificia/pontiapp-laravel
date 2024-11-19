<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MiddlewareAuth
{
    public function handle(Request $req, Closure $next)
    {
        if (Auth::check()) {
            return $next($req);
        }
        return redirect('/login');
    }
}
