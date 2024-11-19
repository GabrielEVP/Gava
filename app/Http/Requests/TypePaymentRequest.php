<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TypePaymentRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:type_payments,name',
            'description' => 'nullable|string|max:255',
            'company_id' => 'nullable|exists:companies,id',
        ];
    }
}
