<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IssueReportRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'shipment_id' => 'required|exists:shipments,id',
            'issue_type' => ['required', Rule::in(['delay', 'damage', 'loss', 'other'])],
            'description' => 'required|string|max:1000',
            'severity' => ['required', Rule::in(['low', 'medium', 'high', 'critical'])],
            'contact_name' => 'required|string|max:100',
            'contact_email' => 'required|email|max:100',
            'contact_phone' => 'nullable|string|max:50',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
        ];
    }
}
