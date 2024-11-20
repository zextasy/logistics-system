<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\DocumentAccessMiddleware;
use App\Http\Middleware\QuoteRateLimitMiddleware;
use App\Http\Middleware\TrackingMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            // Custom Middleware
            'admin' => AdminMiddleware::class,
            'tracking' => TrackingMiddleware::class,
            'quote.limit' => QuoteRateLimitMiddleware::class,
            'document.access' => DocumentAccessMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
