<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecurringInvoiceRequest extends FormRequest
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
            'concept' => 'required|string|max:255',
            'date' => 'required|date',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|string|in:active,inactive',
            'next_invoice_date' => 'required|date',
            'client_id' => 'required|exists:clients,id',
            'company_id' => 'required|exists:companies,id',
            'lines' => 'nullable|array',
            'lines.*.description' => 'required_with:lines|string',
            'lines.*.quantity' => 'required_with:lines|integer|min:0',
            'lines.*.unit_price' => 'required_with:lines|numeric|min:0',
            'lines.*.vat_rate' => 'required_with:lines|numeric|min:0|max:100',
            'lines.*.total_amount' => 'nullable|numeric|min:0',
            'lines.*.total_amount_rate' => 'nullable|numeric|min:0',
            'lines.*.product_id' => 'nullable|exists:products,id',
        ];
    }
}