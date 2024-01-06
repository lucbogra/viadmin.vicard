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

    /**
     * Handle the Transaction "updated" event.
     */
    public function updated(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "deleted" event.
     */
    public function deleted(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "restored" event.
     */
    public function restored(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "force deleted" event.
     */
    public function forceDeleted(Transaction $transaction): void
    {
        //
    }
}
