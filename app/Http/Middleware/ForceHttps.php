<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceHttps
{
    public function handle(Request $request, Closure $next)
    {
        if (env('APP_ENV') === 'production') {

            if ($request->header('X-Forwarded-Proto') === 'https' || $request->secure()) {
                return $next($request);
            }
            return redirect()->secure($request->getRequestUri(), 301);
        }

        return $next($request);
    }
}
