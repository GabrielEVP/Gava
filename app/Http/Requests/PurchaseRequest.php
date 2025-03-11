<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            'purchase_number' => 'required|string|max:255',
            'concept' => 'required|string|max:255',
            'date' => 'required|date',
            'status' => 'required|string|in:pending,paid,overdue',
            'total_amount' => 'required|numeric|min:0',
            'supplier_id' => 'required|exists:suppliers,id',
            'lines' => 'nullable|array',
            'lines.*.description' => 'required_with:lines|string',
            'lines.*.quantity' => 'required_with:lines|numeric|min:0',
            'lines.*.unit_price' => 'required_with:lines|numeric|min:0',
            'lines.*.vat_rate' => 'required_with:lines|numeric|min:0|max:100',
            'payments' => 'nullable|array',
            'payments.*.payment_date' => 'required_with:payments|date',
            'payments.*.amount' => 'required_with:payments|numeric|min:0',
            'payments.*.type_payment_id' => 'required_with:payments|exists:type_payments,id',
            'due_dates' => 'nullable|array',
            'due_dates.*.due_date' => 'required_with:due_dates|date',
            'due_dates.*.amount' => 'required_with:due_dates|numeric|min:0',
        ];
    }
}