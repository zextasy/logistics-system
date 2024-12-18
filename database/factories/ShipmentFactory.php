<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Shipment;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShipmentFactory extends Factory
{
    protected $model = Shipment::class;

    public function definition()
    {
        $type = $this->faker->randomElement(['air', 'sea']);//, 'road', 'rail'
        $status = $this->faker->randomElement([
            'pending',
            'picked_up',
            'on_transit',
            'customs',
            'out_for_delivery',
            'delivered',
            'cancelled',
            'on_hold'
        ]);
        $originCity = City::inRandomOrder()->first();
        $destinationCity = City::inRandomOrder()->first();

        return [
            'tracking_number' => 'TRK-' . strtoupper($this->faker->unique()->bothify('##???###')),
            'type' => $type,
            'status' => $status,
            'origin_country_id' => $originCity->country_id,
            'origin_city_id' => $originCity->id,
            'origin_address' => $this->faker->streetAddress(),
            'origin_postal_code' => $this->faker->postcode(),
            'loading_port' => $originCity->name,
            'destination_country_id' => $destinationCity->country_id,
            'destination_city_id' => $destinationCity->id,
            'destination_address' => $this->faker->streetAddress(),
            'destination_postal_code' => $this->faker->postcode(),
            'final_place_for_delivery' => $destinationCity->name,
            'discharge_port' => $destinationCity->name,
            'weight' => $this->faker->randomFloat(2, 1, 1000),
            'weight_unit' => $this->faker->randomElement(['kg', 'lbs']),
            'dimensions' => [
                'length' => $this->faker->numberBetween(10, 100),
                'width' => $this->faker->numberBetween(10, 100),
                'height' => $this->faker->numberBetween(10, 100),
                'unit' => 'cm'
            ],
            'description' => $this->faker->sentence(),
            'container_size' => $type === 'sea' ? $this->faker->randomElement(['LCL','20ft', '40ft', '40ft_HC']) : null,
            'service_type' => $this->faker->randomElement(['express', 'standard', 'economy']),
            'shipper_name' => $this->faker->name(),
            'shipper_phone' => $this->faker->phoneNumber(),
            'shipper_email' => $this->faker->email(),
            'shipper_address' => $this->faker->address(),
            'notify_party_name' => $this->faker->name(),
            'notify_party_phone' => $this->faker->phoneNumber(),
            'notify_party_email' => $this->faker->email(),
            'notify_party_address' => $this->faker->address(),
            'consignee_name' => $this->faker->company(),
            'consignee_phone' => $this->faker->phoneNumber(),
            'consignee_email' => $this->faker->email(),
            'consignee_address' => $this->faker->address(),
            'vessel' => $this->faker->company(),
            'current_location' => $this->faker->city(),
            'estimated_delivery' => $this->faker->dateTimeBetween('+1 week', '+3 weeks'),
            'actual_delivery' => $status === 'delivered' ? $this->faker->dateTimeBetween('-1 week', 'now') : null,
            'special_instructions' => $this->faker->optional()->sentence(),
            'customs_status' => $status === 'customs' ? 'processing' : null,
            'customs_documents' => null,
            'customs_cleared' => false,
            'declared_value' => $this->faker->randomFloat(2, 100, 10000),
            'currency' => 'USD',
            'charges' => [
                'freight' => $this->faker->randomFloat(2, 100, 5000),
                'customs' => $this->faker->randomFloat(2, 50, 500),
                'handling' => $this->faker->randomFloat(2, 25, 250)
            ],
            'insurance_required' => $this->faker->boolean(),
            'insurance_amount' => $this->faker->randomFloat(2, 100, 1000),
            'metadata' => null,
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'updated_at' => function (array $attributes) {
                return $this->faker->dateTimeBetween($attributes['created_at'], 'now');
            }
        ];
    }

    public function delivered()
    {
        return $this->state(function (array $attributes) {
            return [
                'date_of_shipment' => $this->faker->dateTimeBetween('-1 month', '-1 week'),
                'status' => 'delivered',
                'actual_delivery' => $this->faker->dateTimeBetween('-1 week', 'now')
            ];
        });
    }

    public function inTransit()
    {
        return $this->state(function (array $attributes) {
            return [
                'date_of_shipment' => $this->faker->dateTimeBetween('-1 month', '-1 week'),
                'status' => 'on_transit',
                'actual_delivery' => null
            ];
        });
    }

    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'date_of_shipment' => null,
                'status' => 'pending',
                'actual_delivery' => null
            ];
        });
    }
}
