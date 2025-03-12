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
            'invoice_number' => 'required|string|max:255',
            'concept' => 'required|string|max:255',
            'date' => 'required|date',
            'status' => 'required|string|in:pending,paid,overdue',
            'total_amount' => 'required|numeric|min:0',
            'client_id' => 'required|exists:clients,id',
            'user_id' => 'required|exists:users,id',
            'lines' => 'nullable|array',
            'lines.*.description' => 'required_with:lines|string',
            'lines.*.quantity' => 'required_with:lines|integer|min:0',
            'lines.*.unit_price' => 'required_with:lines|numeric|min:0',
            'lines.*.vat_rate' => 'required_with:lines|numeric|min:0|max:100',
            'payments' => 'nullable|array',
            'payments.*.payment_date' => 'required_with:payments|date',
            'payments.*.amount' => 'required_with:payments|numeric|min:0',
            'payments.*.status' => 'required_with:payments|string|in:pending,paid,overdue',
            'payments.*.type_payment_id' => 'required_with:payments|exists:type_payments,id',
            'due_dates' => 'nullable|array',
            'due_dates.*.due_date' => 'required_with:due_dates|date',
            'due_dates.*.amount' => 'required_with:due_dates|numeric|min:0',
        ];
    }
}
