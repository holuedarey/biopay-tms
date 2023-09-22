<?php

namespace App\Observers;

use App\Models\WalletTransaction;
use App\Notifications\TransactionReceipt;

class WalletTransactionObserver
{
    /**
     * Handle the WalletTransaction "created" event.
     */
    public function created(WalletTransaction $walletTransaction): void
    {
        $walletTransaction->agent->notify(new TransactionReceipt($walletTransaction));
    }
}
