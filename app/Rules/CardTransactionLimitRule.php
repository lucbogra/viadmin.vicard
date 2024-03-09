<?php

namespace App\Rules;

use Closure;
use App\Models\Card;
use App\Models\Transaction;
use Illuminate\Contracts\Validation\ValidationRule;

class CardTransactionLimitRule implements ValidationRule
{
    public function __construct(private Card $card) { }
    
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        
        $perTransactionLimit = (float) $this->card->getRawOriginal('per_transaction_limit');
        $dailyLimit = (float) $this->card->getRawOriginal('daily_limit');

        if ($perTransactionLimit > 0) {
            $perTransactionLimit = $perTransactionLimit / 100;
        }

        if ($dailyLimit > 0) {
            $dailyLimit = $dailyLimit / 100;
        }

        $transactionTotal = Transaction::where("card_id", $this->card->id)
                                    ->where("type", "withdraw")
                                    ->whereDate("date", request()->date)
                                    ->sum('amount');

        if ($transactionTotal > 0) {
            $transactionTotal = $transactionTotal / 100;
        }

        if ($value > $perTransactionLimit) {
            $fail("This card has a per transaction limit of $perTransactionLimit therefore you cannot continue");
        }

        $possibleWithdraw = $dailyLimit - $transactionTotal;

        if (($transactionTotal + $value) > $dailyLimit) {
            $fail("This card has a daily withdrawal limit of $dailyLimit you have already withdrawn $transactionTotal, you can only withdraw $possibleWithdraw");
            // $fail("This card cannot be withdrawn more than $dailyLimit per day");
        }

    }
}
