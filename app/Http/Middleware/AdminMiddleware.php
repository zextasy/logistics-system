<?php

namespace App\Http\Middleware;

use App\Enums\UserRoleEnum;
use Closure;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->role !== UserRoleEnum::ADMIN) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            Notification::make()
                ->title('You do not have permission to access this area.')
                ->warning()
                ->send();
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
