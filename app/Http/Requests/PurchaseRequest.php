<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'purchase_date' => 'required|date',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|string',
            'supplier_id' => 'required|exists:suppliers,id',
            'company_id' => 'required|exists:companies,id',
            'purchase_lines' => 'required|array',
            'purchase_lines.*.concept' => 'required|string|max:255',
            'purchase_lines.*.description' => 'required|string',
            'purchase_lines.*.quantity' => 'required|numeric|min:0',
            'purchase_lines.*.unit_price' => 'required|numeric|min:0',
            'purchase_lines.*.vat_rate' => 'required|numeric|min:0|max:100',
            'purchase_lines.*.total_amount' => 'required|numeric|min:0',
            'purchase_lines.*.total_amount_rate' => 'required|numeric|min:0',
            'purchase_lines.*.product_id' => 'nullable|exists:products,id',
            'purchase_lines.*.purchase_id' => 'required|exists:purchases,id',
        ];
    }
}
