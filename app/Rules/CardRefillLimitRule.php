<?php

namespace App\Rules;

use Closure;
use App\Models\Card;
use Illuminate\Contracts\Validation\ValidationRule;

class CardRefillLimitRule implements ValidationRule
{
    public function __construct(private Card $card) { }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        
        $cardLimit = (float) $this->card->getRawOriginal('card_limit');
        $balance = (float) $this->card->getRawOriginal('card_balance');

        if ($cardLimit > 0) {
            $cardLimit = $cardLimit / 100;
        }

        if ($balance > 0) {
            $balance = $balance / 100;
        }

        $leftAmount = abs($cardLimit - $balance);

        if ($value > $leftAmount) {
            $fail("Can no longer add more than {$leftAmount} due to the limit of this card which is $cardLimit");
        }


    }
}
