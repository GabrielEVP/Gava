<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TypePriceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'type' => 'required|string|in:fixed,percentage',
            'margin' => 'required|numeric|min:0|max:100',
        ];
    }
}
