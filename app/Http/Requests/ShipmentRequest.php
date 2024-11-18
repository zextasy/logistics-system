<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShipmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'type' => ['required', Rule::in(['air', 'sea', 'road', 'rail'])],
            'origin_country' => 'required|string|max:100',
            'origin_city' => 'required|string|max:100',
            'origin_address' => 'nullable|string|max:255',
            'origin_postal_code' => 'nullable|string|max:20',
            'destination_country' => 'required|string|max:100',
            'destination_city' => 'required|string|max:100',
            'destination_address' => 'nullable|string|max:255',
            'destination_postal_code' => 'nullable|string|max:20',
            'weight' => 'required|numeric|min:0.01',
            'weight_unit' => 'required|in:kg,lbs',
            'dimensions' => 'nullable|array',
            'dimensions.length' => 'required_with:dimensions|numeric|min:0',
            'dimensions.width' => 'required_with:dimensions|numeric|min:0',
            'dimensions.height' => 'required_with:dimensions|numeric|min:0',
            'dimensions.unit' => 'required_with:dimensions|in:cm,inch',
            'description' => 'required|string|max:1000',
            'container_size' => 'nullable|string|max:50',
            'service_type' => 'required|string|max:50',
            'shipper_name' => 'required|string|max:100',
            'shipper_phone' => 'nullable|string|max:50',
            'shipper_email' => 'nullable|email|max:100',
            'receiver_name' => 'required|string|max:100',
            'receiver_phone' => 'nullable|string|max:50',
            'receiver_email' => 'nullable|email|max:100',
            'estimated_delivery' => 'required|date|after:today',
            'special_instructions' => 'nullable|string|max:1000',
            'customs_documents' => 'nullable|array',
            'declared_value' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|size:3',
            'insurance_required' => 'boolean',
            'insurance_amount' => 'required_if:insurance_required,true|nullable|numeric|min:0',
            'routes' => 'sometimes|array',
            'routes.*.location' => 'required|string|max:100',
            'routes.*.arrival_date' => 'required|date',
            'routes.*.departure_date' => 'nullable|date|after:routes.*.arrival_date',
            'routes.*.order' => 'required|integer|min:1'
        ];
    }

    public function messages()
    {
        return [
            'type.required' => 'Please select a shipment type',
            'origin_country.required' => 'Origin country is required',
            'destination_country.required' => 'Destination country is required',
            'weight.required' => 'Shipment weight is required',
            'weight.numeric' => 'Weight must be a number',
            'dimensions.*.numeric' => 'Dimensions must be numbers',
            'estimated_delivery.after' => 'Estimated delivery date must be after today',
            'insurance_amount.required_if' => 'Insurance amount is required when insurance is requested',
        ];
    }
}
