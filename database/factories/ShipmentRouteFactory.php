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
            'location' => $this->faker->city(),
            'location_type' => $this->faker->randomElement(['airport', 'seaport', 'warehouse', 'customs', 'distribution_center']),
            'arrival_date' => $arrivalDate,
            'departure_date' => $departureDate,
            'actual_arrival_date' => null,
            'actual_departure_date' => null,
            'status' => 'pending',
            'order' => 0,
        ];
    }

    public function completed()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'departed',
                'actual_arrival_date' => $attributes['arrival_date'],
                'actual_departure_date' => $attributes['departure_date']
            ];
        });
    }
}
