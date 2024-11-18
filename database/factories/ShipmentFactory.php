<?php

// database/factories/ShipmentFactory.php
namespace Database\Factories;

use App\Models\Shipment;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShipmentFactory extends Factory
{
    protected $model = Shipment::class;

    public function definition()
    {
        $type = $this->faker->randomElement(['air', 'sea']);
        $status = $this->faker->randomElement(['pending', 'in_transit', 'customs', 'delivered', 'cancelled']);
        $containerSize = $type === 'sea' ? $this->faker->randomElement(['20ft', '40ft', '40ft HC']) : null;

        return [
            'tracking_number' => 'TRK' . strtoupper($this->faker->unique()->bothify('##???####')),
            'type' => $type,
            'status' => $status,
            'origin_country' => $this->faker->country(),
            'origin_city' => $this->faker->city(),
            'destination_country' => $this->faker->country(),
            'destination_city' => $this->faker->city(),
            'estimated_delivery' => $this->faker->dateTimeBetween('+1 week', '+3 weeks'),
            'description' => $this->faker->sentence(),
            'shipper_name' => $this->faker->company(),
            'receiver_name' => $this->faker->company(),
            'current_location' => $this->faker->city(),
            'container_size' => $containerSize,
            'service_type' => $type === 'air' ? 'express' : 'standard',
            'weight' => $this->faker->randomFloat(2, 1, 1000),
            'dimensions' => json_encode([
                'length' => $this->faker->numberBetween(10, 100),
                'width' => $this->faker->numberBetween(10, 100),
                'height' => $this->faker->numberBetween(10, 100),
            ]),
            'special_instructions' => $this->faker->optional()->sentence(),
            'customs_status' => $status === 'customs' ? 'processing' : null,
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }

    public function air()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'air',
                'service_type' => $this->faker->randomElement(['express', 'priority', 'economy']),
                'container_size' => null,
            ];
        });
    }

    public function sea()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'sea',
                'service_type' => $this->faker->randomElement(['fcl', 'lcl', 'bulk']),
                'container_size' => $this->faker->randomElement(['20ft', '40ft', '40ft HC']),
            ];
        });
    }

    public function delivered()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'delivered',
                'actual_delivery' => $this->faker->dateTimeBetween('-1 week', 'now'),
            ];
        });
    }
}
