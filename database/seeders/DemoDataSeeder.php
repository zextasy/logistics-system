<?php

// database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            ShipmentSeeder::class,
            QuoteSeeder::class,
        ]);
    }
}
