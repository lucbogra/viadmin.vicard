<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardRequestRequest extends FormRequest
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
                    'card_number' => ['required', 'string', 'max:100', 'unique:cards'],
                    'card_validity' => ['required', 'date_format:Y-m-d'],
                    'card_limit' => ['required', 'numeric', 'min:0'],
                    // 'card_fees' => ['required', 'numeric', 'min:0'],
                    'daily_limit' => ['required', 'numeric', 'min:0'],
                    'per_transaction_limit' => ['required', 'numeric', 'min:0'],
                    'card_status' => ['in:activated,not activated,frozen'],
                    'card_type' => ['in:virtual,physical'],
                ]
            ];
        }

        return $rule;
    }
}
