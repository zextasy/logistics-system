<?php

namespace Database\Factories;

use App\Models\Quote;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class QuoteFactory extends Factory
{
    protected $model = Quote::class;

    public function definition()
    {
        return [
            'reference_number' => 'QT-' . strtoupper(Str::random(8)),
            'name' => $this->faker->name(),
            'company' => $this->faker->company(),
            'email' => $this->faker->companyEmail(),
            'phone' => $this->faker->phoneNumber(),
            'country' => $this->faker->country(),

            'origin_country' => $this->faker->country(),
            'origin_city' => $this->faker->city(),
            'origin_postal_code' => $this->faker->postcode(),
            'destination_country' => $this->faker->country(),
            'destination_city' => $this->faker->city(),
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
                'sea_freight',
                'road_freight',
                'rail_freight',
                'multimodal'
            ]),
            'container_size' => $this->faker->optional()->randomElement(['20ft', '40ft', '40ft HC']),
            'incoterm' => $this->faker->randomElement(['EXW', 'FOB', 'CIF', 'DDP']),
            'expected_ship_date' => $this->faker->dateTimeBetween('+1 week', '+1 month'),

            'insurance_required' => $this->faker->boolean(),
            'customs_clearance_required' => $this->faker->boolean(),
            'pickup_required' => $this->faker->boolean(),
            'packing_required' => $this->faker->boolean(),
            'special_requirements' => $this->faker->optional()->paragraph(),

            'status' => $this->faker->randomElement(['pending', 'under_review', 'processed', 'accepted', 'rejected']),
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

    public function processed()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'processed',
                'processed_at' => now(),
                'quoted_price' => $this->faker->randomFloat(2, 1000, 50000)
            ];
        });
    }
}

