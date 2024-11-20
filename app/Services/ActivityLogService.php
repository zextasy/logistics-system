<?php

namespace App\Services;

use App\Models\{User, ActivityLog};

class ActivityLogService
{
    public function log(User $user, string $action, string $resource, string $ip)
    {
        return ActivityLog::create([
            'user_id' => $user->id,
            'action' => $action,
            'resource' => $resource,
            'ip_address' => $ip,
            'user_agent' => request()->userAgent()
        ]);
    }

    public function getUserActivity(User $user, int $limit = 10)
    {
        return ActivityLog::where('user_id', $user->id)
            ->latest()
            ->take($limit)
            ->get();
    }

    public function getResourceActivity(string $resource, int $limit = 10)
    {
        return ActivityLog::where('resource', 'LIKE', "%{$resource}%")
            ->latest()
            ->take($limit)
            ->get();
    }
}
