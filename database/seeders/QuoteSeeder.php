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

        // Create processed quotes
        Quote::factory()
            ->processed()
            ->count(10)
            ->create();
    }
}
