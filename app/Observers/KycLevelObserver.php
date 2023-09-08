<?php

namespace App\Observers;

use App\Models\KycLevel;
use Illuminate\Support\Facades\Cache;

class KycLevelObserver
{
    /**
     * Handle the KycLevel "created" event.
     *
     * @param  \App\Models\KycLevel  $kycLevel
     * @return void
     */
    public function created(KycLevel $kycLevel)
    {
        Cache::forget('kyc-levels');
    }

    /**
     * Handle the KycLevel "updated" event.
     *
     * @param  \App\Models\KycLevel  $kycLevel
     * @return void
     */
    public function updated(KycLevel $kycLevel)
    {
        Cache::forget('kyc-levels');
    }

    /**
     * Handle the KycLevel "deleted" event.
     *
     * @param  \App\Models\KycLevel  $kycLevel
     * @return void
     */
    public function deleted(KycLevel $kycLevel)
    {
        //
    }

    /**
     * Handle the KycLevel "restored" event.
     *
     * @param  \App\Models\KycLevel  $kycLevel
     * @return void
     */
    public function restored(KycLevel $kycLevel)
    {
        //
    }

    /**
     * Handle the KycLevel "force deleted" event.
     *
     * @param  \App\Models\KycLevel  $kycLevel
     * @return void
     */
    public function forceDeleted(KycLevel $kycLevel)
    {
        //
    }
}
