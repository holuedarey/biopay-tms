<?php

namespace App\Traits;

use App\Exceptions\FailedApiResponse;
use App\Models\KycDoc;
use App\Models\KycLevel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasKycCheck
{
    public function kycDocs(): HasMany
    {
        return $this->hasMany(KycDoc::class);
    }

    public function kycLevel(): BelongsTo
    {
        return $this->belongsTo(KycLevel::class, 'level_id');
    }

    public function ensureKycChecks(float $amount): void
    {
        throw_unless($this->isActive(), new FailedApiResponse("This account is currently $this->status"));

        // Ignore amount validation for loan requests.
        if (request()->routeIs('api.loans.store')) return;

        if ($amount > $this->kycLevel->single_trans_max) {
            throw new FailedApiResponse('Your single transaction limit is ' . moneyFormat($this->kycLevel->single_trans_max));
        }

        $amount_today = $this->transactions()->successful()->today()->sum('amount');

        if (($amount_today + $amount) > $this->kycLevel->daily_limit) {
            $remainder = moneyFormat($this->kycLevel->daily_limit - $amount_today);

            throw new FailedApiResponse("Daily transaction limit exceeded! You can still transact with $remainder");
        }
    }
}
