<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DocumentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'shipment_id' => 'required|exists:shipments,id',
            'type' => ['required', Rule::in([
                'airway_bill',
                'bill_of_lading',
                'commercial_invoice',
                'packing_list',
                'certificate_of_origin',
                'customs_declaration',
                'insurance_certificate',
                'delivery_order'
            ])],
            'notes' => 'nullable|string|max:1000',
            'expires_at' => 'nullable|date|after:today',
            'metadata' => 'nullable|array',
            'metadata.generated_by' => 'nullable|string',
            'metadata.department' => 'nullable|string',
            'metadata.version' => 'nullable|string'
        ];
    }
}
