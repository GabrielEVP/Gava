<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'barcode' => 'nullable|string|max:255',
            'reference_code' => 'nullable|string|max:255',
            'purchase_price' => 'required|numeric|min:0',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'stock_quantity' => 'required|numeric|min:0',
            'units_per_box' => 'required|integer|min:1',
            'user_id' => 'exists:users,id',
            'product_prices' => 'array',
            'product_prices.*.price' => 'required_with:product_prices|numeric|min:0',
            'products_suppliers' => 'nullable|array',
            'products_suppliers.*.supplier_id' => 'nullable|exists:suppliers,id',
            'products_categories' => 'nullable|array',
            'products_categories.*.category_id' => 'nullable|exists:category,id',
        ];
    }
}
