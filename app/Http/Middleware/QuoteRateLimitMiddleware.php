<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiter;

class QuoteRateLimitMiddleware
{
    protected $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public function handle(Request $request, Closure $next)
    {
        $key = 'quotes:' . ($request->ip() ?? 'unknown');

        if ($this->limiter->tooManyAttempts($key, 5)) { // 5 attempts per hour
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Too many quote requests. Please try again later.'
                ], 429);
            }

            return redirect()->back()
                ->with('error', 'Too many quote requests. Please try again later.');
        }

        $this->limiter->hit($key, 60 * 60); // 1 hour

        return $next($request);
    }
}
