<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'invoice_number' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'total_amount' => 'required|numeric|min:0',
            'tax_amount' => 'required|numeric|min:0',
            'status' => 'required|string|max:255',
            'client_id' => 'required|exists:clients,id',
            'lines' => 'required|array',
            'lines.*.product_id' => 'required|exists:products,id',
            'lines.*.quantity' => 'required|integer|min:1',
            'lines.*.price' => 'required|numeric|min:0',
            'due_dates' => 'required|array',
            'due_dates.*.due_date' => 'required|date',
            'payments' => 'required|array',
            'payments.*.payment_date' => 'required|date',
            'payments.*.amount' => 'required|numeric|min:0',
        ];
    }
}
