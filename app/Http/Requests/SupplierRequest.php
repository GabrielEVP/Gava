<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
            'code_number' => 'required|string|max:255',
            'registration_number' => 'required|string|max:255',
            'legal_name' => 'required|string|max:255',
            'type_supplier' => 'required|string|max:255',
            'website' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'municipality' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'credit_day_limit' => 'nullable|integer|min:0',
            'limit_credit' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'company_id' => 'required|exists:companies,id',
            'phones' => 'nullable|array',
            'phones.*.type' => 'required_with:phones|string|in:landline,mobile',
            'phones.*.phone' => 'required_with:phones|string|max:20',
            'emails' => 'nullable|array',
            'emails.*.type' => 'required_with:emails|string|in:personal,work',
            'emails.*.email' => 'required_with:emails|string|email|max:255',
            'bank_accounts' => 'nullable|array',
            'bank_accounts.*.bank_name' => 'required_with:bank_accounts|string|max:255',
            'bank_accounts.*.account_number' => 'required_with:bank_accounts|string|max:255',
            'bank_accounts.*.account_type' => 'required_with:bank_accounts|string|max:255',
        ];
    }

    /**
     * Get the custom validation messages.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'code_number.required' => 'El número de código es obligatorio.',
            'code_number.string' => 'El número de código debe ser una cadena de texto.',
            'code_number.max' => 'El número de código no puede tener más de 255 caracteres.',
            'registration_number.required' => 'El número de registro es obligatorio.',
            'registration_number.string' => 'El número de registro debe ser una cadena de texto.',
            'registration_number.max' => 'El número de registro no puede tener más de 255 caracteres.',
            'legal_name.required' => 'El nombre legal es obligatorio.',
            'legal_name.string' => 'El nombre legal debe ser una cadena de texto.',
            'legal_name.max' => 'El nombre legal no puede tener más de 255 caracteres.',
            'type_supplier.required' => 'El tipo de cliente es obligatorio.',
            'type_supplier.string' => 'El tipo de cliente debe ser una cadena de texto.',
            'type_supplier.max' => 'El tipo de cliente no puede tener más de 255 caracteres.',
            'website.string' => 'El sitio web debe ser una cadena de texto.',
            'website.max' => 'El sitio web no puede tener más de 255 caracteres.',
            'address.string' => 'La dirección debe ser una cadena de texto.',
            'address.max' => 'La dirección no puede tener más de 255 caracteres.',
            'city.string' => 'La ciudad debe ser una cadena de texto.',
            'city.max' => 'La ciudad no puede tener más de 100 caracteres.',
            'state.string' => 'El estado debe ser una cadena de texto.',
            'state.max' => 'El estado no puede tener más de 100 caracteres.',
            'municipality.string' => 'El municipio debe ser una cadena de texto.',
            'municipality.max' => 'El municipio no puede tener más de 100 caracteres.',
            'postal_code.string' => 'El código postal debe ser una cadena de texto.',
            'postal_code.max' => 'El código postal no puede tener más de 20 caracteres.',
            'country.string' => 'El país debe ser una cadena de texto.',
            'country.max' => 'El país no puede tener más de 100 caracteres.',
            'credit_day_limit.integer' => 'El límite de días de crédito debe ser un número entero.',
            'credit_day_limit.min' => 'El límite de días de crédito no puede ser menor que 0.',
            'limit_credit.numeric' => 'El límite de crédito debe ser un número.',
            'limit_credit.min' => 'El límite de crédito no puede ser menor que 0.',
            'notes.string' => 'Las notas deben ser una cadena de texto.',
            'company_id.required' => 'La compañía es obligatoria.',
            'company_id.exists' => 'La compañía seleccionada no existe.',
            'phones.array' => 'Los teléfonos deben ser un arreglo.',
            'phones.*.type.required_with' => 'El tipo de teléfono es obligatorio cuando se proporciona un teléfono.',
            'phones.*.type.string' => 'El tipo de teléfono debe ser una cadena de texto.',
            'phones.*.type.in' => 'El tipo de teléfono debe ser "landline" o "mobile".',
            'phones.*.phone.required_with' => 'El número de teléfono es obligatorio cuando se proporciona un tipo de teléfono.',
            'phones.*.phone.string' => 'El número de teléfono debe ser una cadena de texto.',
            'phones.*.phone.max' => 'El número de teléfono no puede tener más de 20 caracteres.',
            'emails.array' => 'Los correos electrónicos deben ser un arreglo.',
            'emails.*.type.required_with' => 'El tipo de correo electrónico es obligatorio cuando se proporciona un correo electrónico.',
            'emails.*.type.string' => 'El tipo de correo electrónico debe ser una cadena de texto.',
            'emails.*.type.in' => 'El tipo de correo electrónico debe ser "personal" o "work".',
            'emails.*.email.required_with' => 'El correo electrónico es obligatorio cuando se proporciona un tipo de correo electrónico.',
            'emails.*.email.string' => 'El correo electrónico debe ser una cadena de texto.',
            'emails.*.email.email' => 'El correo electrónico debe ser válido.',
            'emails.*.email.max' => 'El correo electrónico no puede tener más de 255 caracteres.',
            'bank_accounts.array' => 'Las cuentas bancarias deben ser un arreglo.',
            'bank_accounts.*.bank_name.required_with' => 'El nombre del banco es obligatorio cuando se proporciona una cuenta bancaria.',
            'bank_accounts.*.bank_name.string' => 'El nombre del banco debe ser una cadena de texto.',
            'bank_accounts.*.bank_name.max' => 'El nombre del banco no puede tener más de 255 caracteres.',
            'bank_accounts.*.account_number.required_with' => 'El número de cuenta es obligatorio cuando se proporciona un banco.',
            'bank_accounts.*.account_number.string' => 'El número de cuenta debe ser una cadena de texto.',
            'bank_accounts.*.account_number.max' => 'El número de cuenta no puede tener más de 255 caracteres.',
            'bank_accounts.*.account_type.required_with' => 'El tipo de cuenta es obligatorio cuando se proporciona un banco.',
            'bank_accounts.*.account_type.string' => 'El tipo de cuenta debe ser una cadena de texto.',
            'bank_accounts.*.account_type.max' => 'El tipo de cuenta no puede tener más de 255 caracteres.',
        ];
    }
}