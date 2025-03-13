<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
            'type' => 'required|in:NT,JU,GB,OT',
            'website' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'currency' => 'required|in:EUR,USD,BOV,OT',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'discount' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
            'supplier_addresses' => 'nullable|array',
            'supplier_addresses.*.address' => 'required_with:supplier_addresses|string|max:255',
            'supplier_addresses.*.state' => 'required_with:supplier_addresses|string|max:255',
            'supplier_addresses.*.municipality' => 'required_with:supplier_addresses|string|max:255',
            'supplier_addresses.*.postal_code' => 'required_with:supplier_addresses|string|max:20',
            'supplier_addresses.*.country' => 'required_with:supplier_addresses|string|max:255',
            'supplier_addresses.*.is_billing' => 'nullable|boolean',
            'supplier_emails' => 'nullable|array',
            'supplier_emails.*.email' => 'required_with:supplier_emails|email|max:255',
            'supplier_emails.*.type' => 'nullable|in:Work,Personal',
            'supplier_phones' => 'nullable|array',
            'supplier_phones.*.name' => 'required_with:supplier_phones|string|max:255',
            'supplier_phones.*.phone' => 'required_with:supplier_phones|string|max:20',
            'supplier_phones.*.type' => 'nullable|in:Work,Personal',
            'supplier_bank_accounts' => 'nullable|array',
            'supplier_bank_accounts.*.name' => 'required_with:supplier_bank_accounts|string|max:255',
            'supplier_bank_accounts.*.account_number' => 'required_with:supplier_bank_accounts|string|max:255',
            'supplier_bank_accounts.*.type' => 'nullable|in:AH,CO,OT',
        ];
    }
}
