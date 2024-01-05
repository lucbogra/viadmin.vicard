<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardTopupRequestRequest extends FormRequest
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

        $rule = [
            'status' => ['required', 'in:pending,validated,cancelled'],
            'confirm' => ['in:yes']
        ];

        if ($this->status == 'validated') {
            $rule = [...$rule, ...[
                    'amount' => ['required', 'numeric', 'min:1']
                ]
            ];
        }

        return $rule;
    }
}
