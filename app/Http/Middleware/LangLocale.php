<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class LangLocale
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->hasHeader('Accept-Language')) {
            $locale = $request->header('Accept-Language');
            if (in_array($locale, config('app.locales'))) {
                App::setLocale($locale);
            }
        }
        else{
            app()->setLocale('fa');
        }
        return $next($request);
    }
}
