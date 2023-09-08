<?php

namespace App\Observers;

use App\Enums\Status;
use App\Jobs\ImpactGeneralLedger;
use App\Models\Loan;
use App\Models\Service;
use App\Models\Terminal;
use App\Models\Transaction;

class LoanObserver
{
    /**
     * Handle the Loan "created" event.
     */
    public function created(Loan $loan): void
    {

    }

    /**
     * Handle the Loan "updating" event.
     */
    public function updating(Loan $loan): void
    {
        if ($loan->isDirty('status')) {
            if ($loan->status == Status::DECLINED) {
                $loan->declined_by = auth()->id();
            }

            if ($loan->status == Status::CONFIRMED) {
                $loan->confirmed_by = auth()->id();
            }
        }
    }

    /**
     * Handle the Loan "updated" event.
     */
    public function updated(Loan $loan): void
    {

    }

    /**
     * Handle the Loan "restored" event.
     */
    public function restored(Loan $loan): void
    {
        //
    }

    /**
     * Handle the Loan "force deleted" event.
     */
    public function forceDeleted(Loan $loan): void
    {
        //
    }
}
