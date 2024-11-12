<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'barcode' => 'nullable|string|max:255',
            'reference_code' => 'nullable|string|max:255',
            'purchase_price' => 'required|numeric|min:0',
            'vat_rate' => 'required|numeric|min:0|max:100',
            'stock_quantity' => 'required|numeric|min:0',
            'units_per_box' => 'required|integer|min:1',
            'company_id' => 'required|exists:companies,id',
            'product_category_id' => 'nullable',
            'supplier_id' => 'nullable',
            'purchase_id' => 'nullable',
        ];
    }
}
