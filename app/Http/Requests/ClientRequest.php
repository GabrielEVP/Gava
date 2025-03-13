<?php

namespace App\Http\Requests;

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
            'type' => 'required|string|in:NT,JU,GB,OT',
            'website' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:100',
            'currency' => 'required|string|in:EUR,USD,BOV,OT',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'discount' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
            'phones' => 'nullable|array',
            'phones.*.name' => 'required_with:phones|string|max:20',
            'phones.*.phone' => 'required_with:phones|string|max:20',
            'phones.*.type' => 'nullable|string|in:Work,Personal',
            'phones.*.client_id' => 'required_with:phones|exists:clients,id',
            'emails' => 'nullable|array',
            'emails.*.email' => 'required_with:emails|string|email|max:255',
            'emails.*.type' => 'nullable|string|in:Work,Personal',
            'emails.*.client_id' => 'required_with:emails|exists:clients,id',
            'bank_accounts' => 'nullable|array',
            'bank_accounts.*.account_number' => 'required_with:bank_accounts|string|max:255',
            'bank_accounts.*.type' => 'nullable|string|in:AH,CO,OT',
            'bank_accounts.*.client_id' => 'required_with:bank_accounts|exists:clients,id',
            'addresses' => 'nullable|array',
            'addresses.*.address' => 'required_with:addresses|string|max:255',
            'addresses.*.state' => 'required_with:addresses|string|max:100',
            'addresses.*.municipality' => 'required_with:addresses|string|max:100',
            'addresses.*.postal_code' => 'required_with:addresses|string|max:20',
            'addresses.*.country' => 'required_with:addresses|string|max:100',
            'addresses.*.is_billing' => 'nullable|boolean',
            'addresses.*.client_id' => 'required_with:addresses|exists:clients,id',
        ];
    }
}
