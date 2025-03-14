<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'number' => 'required|string|max:255',
            'date' => 'required|date',
            'status' => 'required|in:pending,paid,refused',
            'total_amount' => 'required|numeric|min:0',
            'total_tax_amount' => 'required|numeric|min:0',
            'supplier_id' => 'required|exists:suppliers,id',
            'user_id' => 'required|exists:users,id',
            'purchase_lines' => 'array',
            'purchase_lines.*.description' => 'required_with:purchase_lines|string',
            'purchase_lines.*.quantity' => 'required_with:purchase_lines|integer|min:1',
            'purchase_lines.*.unit_price' => 'required_with:purchase_lines|numeric|min:0',
            'purchase_lines.*.tax_rate' => 'required_with:purchase_lines|numeric|min:0|max:100',
            'purchase_lines.*.product_id' => 'nullable|exists:products,id',
            'purchase_payments' => 'array',
            'purchase_payments.*.date' => 'required_with:purchase_payments|date',
            'purchase_payments.*.amount' => 'required_with:purchase_payments|numeric|min:0',
            'purchase_payments.*.type_payment_id' => 'required_with:purchase_payments|exists:type_payments,id',
            'purchase_due_dates' => 'nullable|array',
            'purchase_due_dates.*.date' => 'required_with:purchase_due_dates|date',
            'purchase_due_dates.*.amount' => 'required_with:purchase_due_dates|numeric|min:0',
            'purchase_due_dates.*.status' => 'required_with:purchase_due_dates|in:pending,paid,refused',
        ];
    }
}
