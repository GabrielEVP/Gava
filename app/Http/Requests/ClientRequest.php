<?php
namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'registration_number' => 'required|string|max:255',
            'legal_name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'website' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'municipality' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'credit_day_limit' => 'nullable|integer|min:0',
            'limit_credit' => 'nullable|numeric|min:0',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'discount' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
            'phones.*.name' => 'required_with:phones|string|max:20',
            'phones.*.phone' => 'required_with:phones|string|max:20',
            'emails' => 'nullable|array',
            'emails.*.email' => 'required_with:emails|string|email|max:255',
            'bank_accounts' => 'nullable|array',
            'bank_accounts.*.account_number' => 'required_with:bank_accounts|string|max:255',
        ];
    }
}
