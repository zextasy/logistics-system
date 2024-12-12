<?php

namespace Database\Seeders;

use App\Models\Quote;
use Illuminate\Database\Seeder;

class QuoteSeeder extends Seeder
{
    public function run()
    {
        // Create pending quotes
        Quote::factory()
            ->pending()
            ->count(15)
            ->create();
        // Create processing quotes
        Quote::factory()->processing()
            ->count(20)
            ->create();
        // Create quoted quotes
        Quote::factory()
            ->quoted()
            ->count(10)
            ->create();
        // Create rejected quotes
        Quote::factory()->rejected()
            ->count(5)
            ->create();
    }
}
