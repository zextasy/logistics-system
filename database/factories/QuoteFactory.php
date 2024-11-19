<?php

namespace Database\Factories;

use App\Models\Quote;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuoteFactory extends Factory
{
    protected $model = Quote::class;

    public function definition()
    {
        return [
            'reference_number' => 'QT-R' . strtoupper($this->faker->unique()->bothify('##???####')),
            'name' => $this->faker->name(),
            'company' => $this->faker->company(),
            'country' => $this->faker->country(),
            'description' => $this->faker->paragraph(),
            'container_size' => $this->faker->optional()->randomElement(['20ft', '40ft', '40ft HC']),
            'service_type' => $this->faker->randomElement(['air_freight', 'sea_freight', 'roll_on_roll_off']),
            'status' => $this->faker->randomElement(['pending', 'processed', 'rejected']),
            'admin_notes' => $this->faker->optional()->sentence(),
            'email' => $this->faker->companyEmail(),
            'phone' => $this->faker->phoneNumber(),
            'estimated_weight' => $this->faker->randomFloat(2, 10, 5000),
            'origin_country' => $this->faker->country(),
            'destination_country' => $this->faker->country(),
            'expected_ship_date' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'pending',
                'admin_notes' => null,
            ];
        });
    }

    public function processed()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'processed',
                'admin_notes' => $this->faker->sentence(),
                'processed_at' => now(),
            ];
        });
    }
}

