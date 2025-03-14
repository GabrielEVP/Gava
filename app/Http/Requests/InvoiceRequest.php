<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
            'status' => 'required|string|in:pending,paid,refused',
            'total_amount' => 'required|numeric|min:0',
            'total_tax_amount' => 'required|numeric|min:0',
            'client_id' => 'required|exists:clients,id',
            'user_id' => 'required|exists:users,id',
            'invoice_lines' => 'array',
            'invoice_lines.*.description' => 'required_with:invoice_lines|string|max:255',
            'invoice_lines.*.quantity' => 'required_with:invoice_lines|integer|min:1',
            'invoice_lines.*.unit_price' => 'numeric|min:0',
            'invoice_lines.*.tax_rate' => 'required_with:invoice_lines|numeric|min:0|max:100',
            'invoice_lines.*.total_amount' => 'required_with:invoice_lines|numeric|min:0',
            'invoice_lines.*.total_tax_amount' => 'required_with:invoice_lines|numeric|min:0',
            'invoice_lines.*.product_id' => 'nullable|exists:products,id',
            'invoice_payments' => 'nullable|array',
            'invoice_payments.*.date' => 'required_with:invoice_payments|date',
            'invoice_payments.*.amount' => 'required_with:invoice_payments|numeric|min:0',
            'invoice_payments.*.type_payment_id' => 'required_with:invoice_payments|exists:type_payments,id',
            'invoice_due_dates' => 'nullable|array',
            'invoice_due_dates.*.date' => 'required_with:invoice_due_dates|date',
            'invoice_due_dates.*.amount' => 'required_with:invoice_due_dates|numeric|min:0',
            'invoice_due_dates.*.status' => 'required_with:invoice_due_dates|string|in:pending,paid,refused',
        ];
    }
}
