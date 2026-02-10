<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\URL;

class ForceHttps
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->secure()) {
            return redirect()->secure($request->getRequestUri());
        }

        URL::forceScheme('https');

        return $next($request);
    }
}
