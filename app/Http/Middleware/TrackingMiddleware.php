<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TrackingMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $tracking = session('recent_tracking', []);

        if ($request->tracking_number) {
            $tracking[$request->tracking_number] = [
                'timestamp' => now()->toDateTimeString(),
                'ip' => $request->ip()
            ];

            session(['recent_tracking' => array_slice($tracking, -5, 5, true)]);
        }

        return $next($request);
    }
}

