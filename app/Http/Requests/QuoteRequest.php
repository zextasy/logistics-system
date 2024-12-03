<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuoteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:100',
            'company' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'nullable|string|max:50',
            'country' => 'required|string|max:2',

            'origin_country' => 'required|string|max:2',
            'origin_city' => 'nullable|string|max:100',
            'origin_postal_code' => 'nullable|string|max:20',
            'destination_country' => 'required|string|max:2',
            'destination_city' => 'nullable|string|max:100',
            'destination_postal_code' => 'nullable|string|max:20',

            'description' => 'required|string|max:1000',
            'cargo_type' => [
                'required',
                Rule::in(['general', 'hazardous', 'perishable', 'fragile', 'valuable'])
            ],
            'estimated_weight' => 'nullable|numeric|min:0.01',
            'weight_unit' => 'required|in:kg,lbs',
            'dimensions' => 'nullable|array',
            'dimensions.length' => 'required_with:dimensions|numeric|min:0',
            'dimensions.width' => 'required_with:dimensions|numeric|min:0',
            'dimensions.height' => 'required_with:dimensions|numeric|min:0',
            'dimensions.unit' => 'required_with:dimensions|in:cm,inch',
            'pieces_count' => 'nullable|integer|min:1',

            'service_type' => [
                'required',
                Rule::in([
                    'air_freight',
                    'sea_freight',
                    'road_freight',
                    'rail_freight',
                    'multimodal'
                ])
            ],
            'container_size' => [
                'nullable',
                Rule::in(['LCL', '20ft', '40ft', '40ft HC'])
            ],
            'incoterm' => [
                'nullable',
                Rule::in(['EXW', 'FOB', 'CIF', 'DDP', 'DAP'])
            ],
            'expected_ship_date' => 'nullable|date|after:today',

            'insurance_required' => 'boolean',
            'customs_clearance_required' => 'boolean',
            'pickup_required' => 'boolean',
            'packing_required' => 'boolean',
            'special_requirements' => 'nullable|string|max:1000',

            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
        ];
    }
}
