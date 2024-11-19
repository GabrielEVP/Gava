<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecurringInvoiceRequest extends FormRequest
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
            'client_id' => 'required|exists:clients,id',
            'company_id' => 'required|exists:companies,id',
            'invoice_date' => 'required|date',
            'total_amount' => 'required|numeric',
            'status' => 'required|string|max:255',
            'frequency' => 'required|string|max:255',
            'next_invoice_date' => 'required|date',
            'lines' => 'required|array',
            'lines.*.product_id' => 'required|exists:products,id',
            'lines.*.quantity' => 'required|numeric',
            'lines.*.unit_price' => 'required|numeric',
            'lines.*.total_price' => 'required|numeric',
        ];
    }
}
