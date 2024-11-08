<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'legal_name' => 'required|string|max:255',
            'vat_number' => 'nullable|string|max:50',
            'registration_number' => 'nullable|string|max:50',
            'email' => 'nullable|string|email|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'currency' => 'nullable|string|max:10',
            'bank_account' => 'nullable|string|max:50',
            'invoice_prefix' => 'nullable|string|max:10',
            'status' => 'nullable|string|max:50',
            'logo_url' => 'nullable|string|max:255',
            'industry' => 'nullable|string|max:100',
            'number_of_employees' => 'nullable|integer',
            'notes' => 'nullable|string',
        ];
    }
}
