<?php

namespace Database\Seeders;

use App\Services\DocumentGenerationService;
use App\Models\{Shipment, ShipmentRoute, Document};
use Illuminate\Database\Seeder;

class ShipmentSeeder extends Seeder
{
    public function run()
    {
        $this->generator = new DocumentGenerationService();
        // Create delivered shipments
        Shipment::factory()
            ->count(10)
            ->pending()
            ->create()
            ->each(function ($shipment) {
                // Create completed routes
                $this->generator->generateInitialDocuments($shipment);
            });
        // Create active shipments
        Shipment::factory()
            ->count(20)
            ->inTransit()
            ->create()
            ->each(function ($shipment ) {
                // Create 3-5 routes for each shipment
                $routeCount = rand(3, 5);
                for ($i = 0; $i < $routeCount; $i++) {
                    ShipmentRoute::factory()
                        ->create([
                        'shipment_id' => $shipment->id
                    ]);
                }

                $this->generator->generateInitialDocuments($shipment);
            });

        // Create delivered shipments
        Shipment::factory()
            ->count(10)
            ->delivered()
            ->create()
            ->each(function ($shipment) {
                // Create completed routes
                $routeCount = rand(3, 5);
                for ($i = 0; $i < $routeCount; $i++) {
                    ShipmentRoute::factory()
                        ->completed()
                        ->create([
                            'shipment_id' => $shipment->id,
                        ]);
                }
                $this->generator->generateInitialDocuments($shipment);
            });
    }
}
