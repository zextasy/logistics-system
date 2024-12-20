<?php


// app/Services/ShipmentService.php
namespace App\Services;

use App\Enums\ShipmentStatusEnum;
use App\Models\Shipment;
use App\Enums\ShipmentRouteStatusEnum;
use App\Models\ShipmentRoute;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ShipmentService
{
    protected $documentService;

    public function __construct(
        DocumentGenerationService $documentService
    ) {
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


    public function deleteShipment(Shipment $shipment)
    {
        foreach ($shipment->documents as $document) {
            $this->documentService->revoke($document, 'Shipment deleted');
        }
        $shipment->routes()->delete();
        $shipment->delete();
    }

    protected function generateTrackingNumber()
    {
        do {
            $number = 'CNL-TRK-'.strtoupper(Str::random(4)).'-'.rand(1000, 9999);
        } while (Shipment::where('tracking_number', $number)->exists());

        return $number;
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
