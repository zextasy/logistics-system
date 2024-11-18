<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrackingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tracking_number' => 'required|string|exists:shipments,tracking_number',
            'email' => 'nullable|email',
            'notification_type' => 'nullable|array',
            'notification_type.*' => 'in:email,sms,push'
        ];
    }
}
