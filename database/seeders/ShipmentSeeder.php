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
        // Create active shipments
        Shipment::factory()
            ->count(20)
            ->inTransit()
            ->create()
            ->each(function ($shipment ) {
                // Create 3-5 routes for each shipment
                $routeCount = rand(3, 5);
                for ($i = 0; $i < $routeCount; $i++) {
                    ShipmentRoute::factory()->create([
                        'shipment_id' => $shipment->id
                    ]);
                }

                $this->generator->generateInitialDocuments($shipment);
                // Create 1-3 documents for each shipment
//                Document::factory()
//                    ->count(rand(1, 3))
//                    ->create(['shipment_id' => $shipment->id]);
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
                // Create active documents
//                Document::factory()
//                    ->active()
//                    ->count(rand(1, 3))
//                    ->create(['shipment_id' => $shipment->id]);
            });
    }
}
