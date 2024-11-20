<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\ActivityLogService;

class LogActivityMiddleware
{
    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (auth()->check()) {
            $this->activityLogService->log(
                auth()->user(),
                $request->method(),
                $request->path(),
                $request->ip()
            );
        }

        return $response;
    }
}
