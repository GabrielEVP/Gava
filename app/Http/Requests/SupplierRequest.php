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
            'code_number' => 'required|string|max:255',
            'registration_number' => 'required|string|max:255',
            'legal_name' => 'required|string|max:255',
            'type_supplier' => 'required|string|max:255',
            'website' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'municipality' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'credit_day_limit' => 'nullable|integer|min:0',
            'limit_credit' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'phones' => 'nullable|array',
            'phones.*.type' => 'required_with:phones|string|in:landline,mobile',
            'phones.*.phone' => 'required_with:phones|string|max:20',
            'emails' => 'nullable|array',
            'emails.*.type' => 'required_with:emails|string|in:personal,work',
            'emails.*.email' => 'required_with:emails|string|email|max:255',
            'bank_accounts' => 'nullable|array',
            'bank_accounts.*.bank_name' => 'required_with:bank_accounts|string|max:255',
            'bank_accounts.*.account_number' => 'required_with:bank_accounts|string|max:255',
            'bank_accounts.*.account_type' => 'required_with:bank_accounts|string|max:255',
        ];
    }
}
