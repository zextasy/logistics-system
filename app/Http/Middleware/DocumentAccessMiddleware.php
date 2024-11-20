<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DocumentAccessMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $document = $request->route('document');

        if ($document->status !== 'active' || $document->hasExpired()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'This document is no longer available.'
                ], 403);
            }

            return redirect()->back()
                ->with('error', 'This document is no longer available.');
        }

        if (!$document->shipment->user_id === auth()->id() && !auth()->user()->is_admin) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            return redirect()->back()
                ->with('error', 'You do not have permission to access this document.');
        }

        return $next($request);
    }
}

