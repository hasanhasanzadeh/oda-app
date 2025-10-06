<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::user();
        if ($user && !in_array($user->role_type, $roles)) {
            abort(403, 'شما به این بخش دسترسی ندارید.');
        }
        return $next($request);
    }
}
