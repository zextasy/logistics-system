<?php

namespace Database\Factories;

use App\Models\Document;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    protected $model = Document::class;

    public function definition()
    {
        $type = $this->faker->randomElement([
            'airway_bill',
            'bill_of_lading',
            'commercial_invoice',
            'packing_list',
            'certificate_of_origin',
            'customs_declaration'
        ]);

        return [
            'shipment_id' => null, // To be set when creating
            'type' => $type,
            'reference_number' => 'DOC-' . strtoupper($this->faker->unique()->bothify('##???####')),
            'file_path' => 'documents/' . $this->faker->uuid() . '.pdf',
            'status' => $this->faker->randomElement(['draft', 'active', 'revoked', 'expired']),
            'generated_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'expires_at' => $this->faker->optional()->dateTimeBetween('+1 month', '+3 months'),
            'notes' => $this->faker->optional()->sentence(),
            'metadata' => json_encode([
                'generated_by' => $this->faker->name(),
                'department' => $this->faker->word(),
                'version' => $this->faker->randomFloat(1, 1, 2),
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function active()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'active',
                'expires_at' => $this->faker->dateTimeBetween('+1 month', '+3 months'),
            ];
        });
    }
}
