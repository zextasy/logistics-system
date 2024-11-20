<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuoteUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->is_admin;
    }

    public function rules()
    {
        return [
            'status' => [
                'required',
                Rule::in(['pending', 'under_review', 'processed', 'accepted', 'rejected'])
            ],
            'quoted_price' => 'required_if:status,processed|nullable|numeric|min:0',
            'currency' => 'required_with:quoted_price|string|size:3',
            'admin_notes' => 'nullable|string|max:1000',
            'pricing_details' => 'nullable|array',
            'pricing_details.*.description' => 'required|string',
            'pricing_details.*.amount' => 'required|numeric|min:0',
            'valid_until' => 'nullable|date|after:today',
            'assigned_to' => 'nullable|exists:users,id'
        ];
    }
}
