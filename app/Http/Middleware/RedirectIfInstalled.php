<?php

namespace App\Http\Middleware;

use App\Support\Installation;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfInstalled
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Installation::isInstalled()) {
            return redirect('/')->with('error', "Le logiciel est déjà installé.");
        }

        return $next($request);
    }
}
