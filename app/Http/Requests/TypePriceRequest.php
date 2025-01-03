<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TypePriceRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'type' => 'required|string|in:fixed,percentage',
            'margin' => 'required|numeric|min:0|max:100',
            'company_id' => 'nullable|exists:companies,id',
        ];
    }
}