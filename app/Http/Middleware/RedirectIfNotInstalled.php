<?php

namespace App\Http\Middleware;

use App\Support\Installation;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotInstalled
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Installation::isInstalled() && ! $request->is('install*') && ! $request->is('up')) {
            return redirect()->route('install.welcome');
        }

        return $next($request);
    }
}
