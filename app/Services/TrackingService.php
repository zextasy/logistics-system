<?php

namespace App\Services;

use App\Models\Shipment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class TrackingService
{
    /**
     * Calculate estimated delivery date and time
     */
    public function calculateEstimatedDelivery(Shipment $shipment)
    {
        $baseDeliveryTime = $shipment->routes->last()?->estimated_arrival;

        // Check for delays and adjust estimated time
        $delays = $this->calculateTotalDelays($shipment);

        return [
//            'estimated_date' => $baseDeliveryTime->addHours($delays),
            'is_delayed' => $delays > 0,
            'delay_hours' => $delays,
            'confidence_score' => $this->calculateConfidenceScore($shipment)
        ];
    }

    /**
     * Get current shipment status with detailed information
     */
    public function getCurrentStatus(Shipment $shipment)
    {
        $shipment->touch();
        $shipment->routes->each->touch();
        $currentRoute = $shipment->routes()
            ->where('arrival_date', '<=', now())
            ->orderBy('order', 'desc')
            ->first();

        return [
            'location' => $currentRoute ? $currentRoute->location : $shipment->origin,
            'status' => $shipment->status,
            'last_update' => $currentRoute ? $currentRoute->updated_at : $shipment->created_at,
            'next_destination' => $this->getNextDestination($shipment),
            'current_stage' => $this->determineShipmentStage($shipment)
        ];
    }

    /**
     * Get milestone progress for the shipment
     */
    public function getMilestones(Shipment $shipment)
    {
        $milestones = [];
        $totalSteps = $shipment->routes->count();
        $completedSteps = $shipment->routes()
            ->where('arrival_date', '<=', now())
            ->count();

        foreach ($shipment->routes as $route) {
            $milestones[] = [
                'location' => $route->location,
                'status' => $this->getMilestoneStatus($route),
                'scheduled_date' => $route->arrival_date,
                'actual_date' => $route->actual_arrival_date,
                'is_completed' => $route->arrival_date <= now(),
                'has_delay' => $route->actual_arrival_date &&
                    $route->actual_arrival_date->gt($route->arrival_date)
            ];
        }

        return [
            'milestones' => $milestones,
            'progress_percentage' => ($completedSteps / $totalSteps) * 100,
            'current_stage' => $completedSteps + 1,
            'total_stages' => $totalSteps
        ];
    }

    /**
     * Get delay information if any
     */
    public function getDelayInformation(Shipment $shipment)
    {
        $delays = $shipment->routes()
            ->whereNotNull('actual_arrival_date')
            ->get()
            ->filter(function ($route) {
                return $route->actual_arrival_date->gt($route->arrival_date);
            });

        if ($delays->isEmpty()) {
            return null;
        }

        return [
            'total_delay_hours' => $this->calculateTotalDelays($shipment),
            'delay_reasons' => $this->getDelayReasons($shipment),
            'affected_locations' => $delays->pluck('location'),
            'recovery_plan' => $this->getRecoveryPlan($shipment)
        ];
    }

    /**
     * Get weather information for current location
     */
    public function getWeatherInfo($location)
    {
        // This would integrate with a weather API
        // Example implementation:
        try {
            $response = Http::get("https://api.weather.com", [
                'location' => $location,
                'api_key' => config('services.weather.key')
            ]);

            return $response->json();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Subscribe user to shipment updates
     */
    public function subscribeToUpdates(Shipment $shipment, string $email, array $notificationTypes)
    {
        return null;
    }

    /**
     * Report an issue with the shipment
     */
    public function reportIssue(Shipment $shipment, string $issueType, string $description, string $contactEmail, ?string $contactPhone)
    {
        return null;
    }

    /**
     * Generate route map data
     */
    public function generateRouteMap(Shipment $shipment)
    {
        $routePoints = $shipment->routes->map(function ($route) {
            return [
                'location' => $route->location,
//                'coordinates' => $this->getCoordinates($route->location),
                'status' => $route->status,
                'arrival_date' => $route->arrival_date->format('Y-m-d H:i:s')
            ];
        });

        return [
//            'origin' => $this->getCoordinates($shipment->origin),
//            'destination' => $this->getCoordinates($shipment->destination),
            'route_points' => $routePoints,
//            'current_location' => $this->getCoordinates($shipment->current_location)
        ];
    }

    // Private helper methods...
    private function calculateTotalDelays(Shipment $shipment)
    {
        return $shipment->routes
            ->sum(function ($route) {
                if (!$route->actual_arrival_date) {
                    return 0;
                }
                return $route->actual_arrival_date->diffInHours($route->arrival_date);
            });
    }

    private function calculateConfidenceScore(Shipment $shipment)
    {
        // Implementation for calculating delivery confidence score
        return 85; // Example return
    }

    private function getNextDestination(Shipment $shipment)
    {
        return $shipment->routes()
            ->where('arrival_date', '>', now())
            ->orderBy('order', 'asc')
            ->first();
    }

    private function determineShipmentStage(Shipment $shipment)
    {
        // Implementation for determining current shipping stage
        return 'on_transit'; // Example return
    }

    private function getMilestoneStatus($route)
    {
        if ($route->arrival_date > now()) {
            return 'pending';
        }
        return $route->actual_arrival_date ? 'completed' : 'in_progress';
    }

    private function getDelayReasons(Shipment $shipment)
    {
        return 'Reasons';
    }

    private function getRecoveryPlan(Shipment $shipment)
    {
        return 'Plans';
    }
}
