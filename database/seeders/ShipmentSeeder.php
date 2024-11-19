<?php

namespace Database\Seeders;

use App\Models\{Shipment, ShipmentRoute, Document};
use Illuminate\Database\Seeder;

class ShipmentSeeder extends Seeder
{
    public function run()
    {
        // Create active shipments
        Shipment::factory()
            ->count(20)
            ->inTransit()
            ->has(
                ShipmentRoute::factory()
                    ->count(4)
                    ->sequence(fn ($sequence) => ['order' => $sequence->index + 1])
            )
            ->create();

        // Create delivered shipments
        Shipment::factory()
            ->count(10)
            ->delivered()
            ->has(
                ShipmentRoute::factory()
                    ->count(4)
                    ->completed()
                    ->sequence(fn ($sequence) => ['order' => $sequence->index + 1])
            )
            ->create();
    }
}
