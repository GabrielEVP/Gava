<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'order_date' => 'required|date',
            'customer_id' => 'required|exists:customers,id',
            'order_lines' => 'required|array',
            'order_lines.*.product_id' => 'required|exists:products,id',
            'order_lines.*.quantity' => 'required|integer|min:1',
            'order_lines.*.price' => 'required|numeric|min:0',
        ];
    }
}
