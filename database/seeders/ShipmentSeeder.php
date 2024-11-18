<?php

namespace Database\Seeders;

use App\Models\{Shipment, ShipmentRoute, Document};
use Illuminate\Database\Seeder;

class ShipmentSeeder extends Seeder
{
    public function run()
    {
        // Create shipments with routes and documents
        Shipment::factory()
            ->count(20)
            ->create()
            ->each(function ($shipment) {
                // Create 3-5 routes for each shipment
                $routeCount = rand(3, 5);
                for ($i = 0; $i < $routeCount; $i++) {
                    ShipmentRoute::factory()->create([
                        'shipment_id' => $shipment->id,
                        'order' => $i + 1,
                    ]);
                }

                // Create 1-3 documents for each shipment
                Document::factory()
                    ->count(rand(1, 3))
                    ->create(['shipment_id' => $shipment->id]);
            });

        // Create some delivered shipments
        Shipment::factory()
            ->delivered()
            ->count(10)
            ->create()
            ->each(function ($shipment) {
                // Create completed routes
                $routeCount = rand(3, 5);
                for ($i = 0; $i < $routeCount; $i++) {
                    ShipmentRoute::factory()
                        ->completed()
                        ->create([
                            'shipment_id' => $shipment->id,
                            'order' => $i + 1,
                        ]);
                }

                // Create active documents
                Document::factory()
                    ->active()
                    ->count(rand(1, 3))
                    ->create(['shipment_id' => $shipment->id]);
            });
    }
}
