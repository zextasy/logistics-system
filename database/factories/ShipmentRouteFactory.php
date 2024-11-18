<?php

namespace Database\Factories;

use App\Models\ShipmentRoute;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShipmentRouteFactory extends Factory
{
    protected $model = ShipmentRoute::class;

    public function definition()
    {
        $arrivalDate = $this->faker->dateTimeBetween('now', '+2 weeks');
        $departureDate = clone $arrivalDate;
        $departureDate = $departureDate->modify('+1 day');

        return [
            'shipment_id' => null, // To be set when creating
            'location' => $this->faker->city(),
            'arrival_date' => $arrivalDate,
            'departure_date' => $departureDate,
            'status' => $this->faker->randomElement(['pending', 'arrived', 'departed']),
            'order' => 0, // To be set when creating
            'notes' => $this->faker->optional()->sentence(),
            'actual_arrival_date' => null,
            'actual_departure_date' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function completed()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'departed',
                'actual_arrival_date' => $attributes['arrival_date'],
                'actual_departure_date' => $attributes['departure_date'],
            ];
        });
    }
}
