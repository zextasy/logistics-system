<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->user()->id)],
            'phone' => 'nullable|string|max:50',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:1000',
            'preferences' => 'nullable|array',
            'preferences.notification_email' => 'boolean',
            'preferences.notification_sms' => 'boolean',
            'preferences.language' => 'string|size:2',
            'preferences.timezone' => 'string|timezone',
            'current_password' => 'required_with:password|current_password',
            'password' => 'nullable|string|min:8|confirmed',
            'password_confirmation' => 'required_with:password'
        ];
    }
}
