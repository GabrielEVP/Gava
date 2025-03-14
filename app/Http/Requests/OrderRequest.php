<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'order_lines' => 'nullable|array',
            'order_lines.*.description' => 'required_with:order_lines|string|max:255',
            'order_lines.*.quantity' => 'required_with:order_lines|integer|min:1',
            'order_lines.*.unit_price' => 'numeric|min:0',
            'order_lines.*.tax_rate' => 'required_with:order_lines|numeric|min:0|max:100',
            'order_lines.*.total_amount' => 'required_with:order_lines|numeric|min:0',
            'order_lines.*.total_tax_amount' => 'required_with:order_lines|numeric|min:0',
            'order_lines.*.product_id' => 'nullable|exists:products,id',
        ];
    }
}
