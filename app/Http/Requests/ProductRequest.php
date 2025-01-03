<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'barcode' => 'nullable|string|max:255',
            'reference_code' => 'nullable|string|max:255',
            'purchase_price' => 'required|numeric|min:0',
            'vat_rate' => 'required|numeric|min:0|max:100',
            'stock_quantity' => 'required|numeric|min:0',
            'units_per_box' => 'required|integer|min:1',
            'company_id' => 'nullable|exists:companies,id',
            'product_category_id' => 'nullable|exists:product_categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'purchase_id' => 'nullable|exists:purchases,id',
            'prices' => 'nullable|array',
            'prices.*.price' => 'required_with:prices|numeric|min:0',
            'prices.*.type_price_id' => 'required_with:prices|exists:type_prices,id',
        ];
    }
}