<?php


// app/Services/ShipmentService.php
namespace App\Services;

use App\Models\Shipment;
use App\Enums\ShipmentRouteStatusEnum;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ShipmentService
{
    protected $notificationService;
    protected $documentService;

    public function __construct(
        NotificationService $notificationService,
        DocumentGenerationService $documentService
    ) {
        $this->notificationService = $notificationService;
        $this->documentService = $documentService;
    }

    public function createShipment(array $data)
    {
        $data['tracking_number'] = $this->generateTrackingNumber();

        $shipment = Shipment::create($data);

        if (isset($data['routes']) && is_array($data['routes'])) {
            foreach ($data['routes'] as $index => $route) {
                $shipment->routes()->create([
                    ...$route,
                    'status' => ShipmentRouteStatusEnum::PENDING
                ]);
            }
        }

        $this->documentService->generateInitialDocuments($shipment);

        return $shipment;
    }

    public function updateShipment(Shipment $shipment, array $data)
    {
        $oldStatus = $shipment->status;

        $shipment->update($data);

        if (isset($data['routes']) && is_array($data['routes'])) {
            $shipment->routes()->delete();
            foreach ($data['routes'] as $index => $route) {
                $shipment->routes()->create([
                    ...$route,
                ]);
            }
        }

        if ($oldStatus !== $shipment->status) {
            $this->notificationService->sendStatusUpdateNotification($shipment, $oldStatus);
        }

        return $shipment;
    }

    public function updateRoute(Shipment $shipment, $routeId, array $data)
    {
        $route = $shipment->routes()->findOrFail($routeId);
        $route->update($data);

        $this->updateShipmentStatus($shipment);

        return $route;
    }

    public function deleteShipment(Shipment $shipment)
    {
        foreach ($shipment->documents as $document) {
            $this->documentService->revoke($document, 'Shipment deleted');
        }

        $shipment->delete();
    }

    protected function generateTrackingNumber()
    {
        do {
            $number = strtoupper(Str::random(4)).'-'.rand(1000, 9999);
        } while (Shipment::where('tracking_number', $number)->exists());

        return $number;
    }

    protected function updateShipmentStatus(Shipment $shipment)
    {
        $latestRoute = $shipment->routes()
            ->where('arrival_date', '<=', now())
            ->orderBy('arrival_date', 'desc')
            ->first();

        if (!$latestRoute) {
            return;
        }

        $status = match ($latestRoute->status) {
            'arrived' => 'in_transit',
            'departed' => $latestRoute->order === $shipment->routes()->count() ? 'delivered' : 'in_transit',
            default => $shipment->status
        };

        if ($status !== $shipment->status) {
            $shipment->update(['status' => $status]);
        }
    }

    public function getCountries()
    {
        return [
            'US' => 'United States',
            'GB' => 'United Kingdom',
            'CN' => 'China',
            'JP' => 'Japan',
            'DE' => 'Germany',
            // TODO  Use Country Model
        ];
    }

    public function calculateShippingCost(Shipment $shipment)
    {
        $baseRate = config("shipping.rates.{$shipment->service_type}", 0);
        $weightRate = $shipment->weight * config("shipping.weight_multiplier.{$shipment->weight_unit}", 1);

        $distance = $this->calculateDistance(
            $shipment->origin_country,
            $shipment->destination_country
        );

        $cost = ($baseRate + $weightRate) * ($distance / 1000);

        if ($shipment->insurance_required) {
            $cost += ($shipment->declared_value * 0.01); // 1% insurance rate
        }

        return round($cost, 2);
    }

    protected function calculateDistance($originCountry, $destinationCountry)
    {
        // Simplified distance calculation - in real application,
        // would use proper geocoding and distance calculation
        $distances = config('shipping.country_distances', []);
        $key = "{$originCountry}-{$destinationCountry}";

        return $distances[$key] ?? 5000; // Default distance if not found
    }
}
