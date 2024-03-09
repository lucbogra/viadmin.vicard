<?php

namespace App\Http\Requests;

use App\Rules\CardTransactionLimitRule;
use Illuminate\Foundation\Http\FormRequest;

class CardWithdrawRequest extends FormRequest
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
            'confirm' => ['in:yes'],
            'date' => ['required', 'date_format:Y-m-d'],
            'merchant' => ['required', 'exists:merchants,id'],
            'amount' => ['required', 'numeric', 'min:1', new CardTransactionLimitRule($this->card)]
        ];

    }
}
