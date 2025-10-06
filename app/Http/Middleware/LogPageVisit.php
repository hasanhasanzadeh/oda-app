<?php

namespace App\Http\Middleware;

use App\Models\Visit;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogPageVisit
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $role = $user?->role_type ?? 'guest';
        $url = $request->url();
        $ip = $request->ip();

        $existingVisit = Visit::where('url', $url)
            ->where('ip_address', $ip)
            ->where('user_id', $user?->id)
            ->first();

        if ($existingVisit) {
            $existingVisit->increment('score');
        } else {
            Visit::create([
                'url' => $url,
                'ip_address' => $ip,
                'user_id' => $user?->id,
                'role' => $role,
                'score' => 1,
            ]);
        }

        return $next($request);
    }
}
