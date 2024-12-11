<?php

namespace Database\Factories;

use App\Models\ShipmentRoute;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShipmentRouteFactory extends Factory
{
    protected $model = ShipmentRoute::class;

    public function definition()
    {
        $arrivalDate = $this->faker->dateTimeBetween('-6 weeks', '+6 weeks');
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
        ];
    }

    public function completed()
    {
        $arrivalDate = $this->faker->dateTimeBetween('-6 weeks', '-1 day');
        $departureDate = clone $arrivalDate;
        $departureDate = $departureDate->modify('+1 day');
        return $this->state(function (array $attributes) use ($departureDate, $arrivalDate) {
            return [
                'status' => 'departed',
                'arrival_date' => $arrivalDate,
                'actual_arrival_date' => $arrivalDate,
                'departure_date' => $departureDate,
                'actual_departure_date' => $departureDate,
            ];
        });
    }
}
