<?php

namespace App\Observers;

use App\Models\Transaction;

class TransactionObserver
{
    /**
     * Handle the Transaction "created" event.
     */
    public function created(Transaction $transaction): void
    {
        $amount = $transaction->amount;

        if ($transaction->type == 'deposit') {

            $newAmount = $transaction->card->card_balance->getMinorAmount()->toInt() + $amount;
            
        } else {
            
            $newAmount = $transaction->card->card_balance->getMinorAmount()->toInt() - $amount;

        }

        $transaction->card()->update(['card_balance' => $newAmount]);
    }

}
