<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Quote;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class QuoteFactory extends Factory
{
    protected $model = Quote::class;



    public function definition()
    {
        $originCity = City::inRandomOrder()->first();
        $destinationCity = City::inRandomOrder()->first();
        return [
            'reference_number' => 'QT-' . strtoupper(Str::random(8)),
            'name' => $this->faker->name(),
            'company' => $this->faker->company(),
            'email' => $this->faker->companyEmail(),
            'phone' => $this->faker->phoneNumber(),
            'country_id' => $originCity->country_id,

            'origin_country_id' => $originCity->country_id,
            'origin_city_id' => $originCity->id,
            'origin_postal_code' => $this->faker->postcode(),
            'destination_country_id' => $destinationCity->country_id,
            'destination_city_id' => $destinationCity->id,
            'destination_postal_code' => $this->faker->postcode(),

            'description' => $this->faker->paragraph(),
            'cargo_type' => $this->faker->randomElement(['general', 'hazardous', 'perishable', 'fragile', 'valuable']),
            'estimated_weight' => $this->faker->randomFloat(2, 10, 5000),
            'weight_unit' => 'kg',
            'dimensions' => [
                'length' => $this->faker->numberBetween(10, 100),
                'width' => $this->faker->numberBetween(10, 100),
                'height' => $this->faker->numberBetween(10, 100),
                'unit' => 'cm'
            ],
            'pieces_count' => $this->faker->numberBetween(1, 100),

            'service_type' => $this->faker->randomElement([
                'air_freight',
                'sea_freight'
            ]),
            'container_size' => $this->faker->optional()->randomElement(['20ft', '40ft', '40ft HC']),
            'incoterm' => $this->faker->randomElement(['EXW', 'FOB', 'CIF', 'DDP']),
            'expected_ship_date' => $this->faker->dateTimeBetween('+1 week', '+1 month'),

            'insurance_required' => $this->faker->boolean(),
            'customs_clearance_required' => $this->faker->boolean(),
            'pickup_required' => $this->faker->boolean(),
            'packing_required' => $this->faker->boolean(),
            'special_requirements' => $this->faker->optional()->paragraph(),

            'status' => $this->faker->randomElement(['pending', 'processing', 'quoted', 'rejected']),
            'quoted_price' => $this->faker->optional()->randomFloat(2, 1000, 50000),
            'currency' => 'USD',
            'admin_notes' => $this->faker->optional()->sentence(),
            'processed_at' => $this->faker->optional()->dateTimeThisMonth(),
            'valid_until' => $this->faker->optional()->dateTimeBetween('+1 week', '+1 month')
        ];
    }

    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'pending',
                'processed_at' => null,
                'quoted_price' => null
            ];
        });
    }

    public function processing()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'processing',
                'processed_at' => null,
                'quoted_price' => null
            ];
        });
    }
    public function quoted()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'quoted',
                'processed_at' => now(),
                'quoted_price' => $this->faker->randomFloat(2, 1000, 50000)
            ];
        });
    }

    public function rejected()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'rejected',
                'processed_at' => now(),
                'quoted_price' => null
            ];
        });
    }
}

