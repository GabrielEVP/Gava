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
            'user_id' => 'nullable|exists:users,id',
            'product_prices' => 'array',
            'product_prices.*.price' => 'required_with:product_prices|numeric|min:0',
            'product_prices.*.type_price_id' => 'required_with:product_prices|exists:type_prices,id',
            'categories' => 'nullable|array',
            'categories.*.id' => 'required_with:categories|exists:categories,id',
            'products_suppliers' => 'nullable|array',
            'products_suppliers.*.supplier_id' => 'required_with:products_suppliers|exists:suppliers,id',
        ];
    }
}
