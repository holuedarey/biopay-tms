<?php

namespace App\Models;

use App\Enums\Action;
use App\Enums\Status;
use App\Traits\BelongsToSuperAgent;
use App\Traits\HasFiltering;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Znck\Eloquent\Traits\BelongsToThrough;

class WalletTransaction extends Model
{
    use HasFactory, HasFiltering, LogsActivity, BelongsToThrough, BelongsToSuperAgent;

    const TYPES = ['TRANSACTION', 'CHARGE'];

    protected $guarded = ['id'];

    protected $with = ['wallet'];

    protected $casts = [
        'status' => Status::class,
        'action' => Action::class
    ];

    // Relationships

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function agent(): \Znck\Eloquent\Relations\BelongsToThrough
    {
        return $this->belongsToThrough(User::class, Wallet::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'product_id');
    }

    public function scopeSuccessful($query)
    {
        return $query->where('status', Status::SUCCESSFUL);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Wallet-transaction')
            ->logOnly(['status']);
    }

    public function scopeWithSearch(Builder $query, $search): Builder
    {
        return $query->where('reference', 'like', '%' . $search . '%')
            ->orWhereHas('wallet', fn($query) => $query->withSearch($search))
            ->orWhereHas('service', fn($query) => $query->withSearch($search));

    }

    public function isCredit(): bool
    {
        return $this->action == Action::CREDIT;
    }

    public function isDebit(): bool
    {
        return $this->action == Action::DEBIT;
    }
}
