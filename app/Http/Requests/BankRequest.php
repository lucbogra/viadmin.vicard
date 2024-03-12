<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankRequest extends FormRequest
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
        if ($this->isMethod('PUT')) {

            return [
                'owner_name' => ['required', 'string', 'max:255'],
                'bank_name' => ['required', 'string', 'max:255', 'unique:banks,bank_name,' . $this->bank->id],
                'iban' => ['required', 'string', 'max:255', 'unique:banks,iban,' . $this->bank->id],
                'address' => ['required', 'string', 'max:255'],
    
                'owner_account' => ['nullable', 'string', 'max:255'],
                'swift_address' => ['nullable', 'string', 'max:255'],
                'bank_branch' => ['nullable', 'string', 'max:255'],
                'reference_number' => ['nullable', 'string', 'max:255'],
            ];

        }

        return [
            'owner_name' => ['required', 'string', 'max:255'],
            'bank_name' => ['required', 'string', 'max:255', 'unique:banks'],
            'iban' => ['required', 'string', 'max:255', 'unique:banks'],
            'address' => ['required', 'string', 'max:255'],

            'owner_account' => ['nullable', 'string', 'max:255'],
            'swift_address' => ['nullable', 'string', 'max:255'],
            'bank_branch' => ['nullable', 'string', 'max:255'],
            'reference_number' => ['nullable', 'string', 'max:255'],
        ];

    }
}
