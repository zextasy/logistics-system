<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DocumentRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->is_admin;
    }

    public function rules()
    {
        return [
            'shipment_id' => 'required|exists:shipments,id',
            'type' => [
                'required',
                Rule::in([
                    'airway_bill',
                    'bill_of_lading',
                    'commercial_invoice',
                    'packing_list',
                    'certificate_of_origin',
                    'customs_declaration'
                ])
            ],
            'metadata' => 'nullable|array',
            'metadata.template_version' => 'nullable|string',
            'metadata.generated_by' => 'nullable|string',
            'metadata.custom_fields' => 'nullable|array',
            'expires_at' => 'nullable|date|after:today',
            'notify_customer' => 'boolean'
        ];
    }
}
