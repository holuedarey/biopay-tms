<?php

namespace App\Models;

use App\Traits\BelongsToSuperAgent;
use App\Traits\HasWalletMethods;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ramsey\Uuid\Uuid;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Wallet extends Model
{
    use HasFactory, LogsActivity, HasWalletMethods, BelongsToSuperAgent;

    protected $guarded = ['id'];

    /**
     * Boot function from laravel.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($wallet) {
            $wallet->uwid = Uuid::uuid4();

            $wallet->account_number = self::generateAccountNumber($wallet->owner->phone);
        });
    }

    public function getRouteKeyName()
    {
        return 'uwid';
    }

    public function resolveRouteBinding($value, $field = null): ?Model
    {
        return $this->where('uwid', $value)->firstOrFail();
    }


//      Relationships

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Wallet has Many Transactions
     * @return HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class);
    }

//    Attribute

    public function isActive(): Attribute
    {
        return Attribute::get(
            fn($value) => $this->status == 'ACTIVE'
        );
    }

    /**
     * Change the terminal status to the opposite value
     */
    public function changeStatus(): void
    {
        $this->status = $this->is_active ? 'SUSPENDED' : 'ACTIVE';
        $this->save();
    }

    /**
     * @param null $phone
     * @return string
     */
    private static function generateAccountNumber( $phone = null): string
    {
        start:

        if ( $phone == null ) {
            $number = '30' . rand(10000000, 99999999);
        }
        else {
             $number = substr($phone, strlen($phone) - 10, 10);
        }

        if ( self::whereAccountNumber($number)->exists() ) {
            if ( $phone != null ) $phone = null;

            goto start;
        }

        return $number;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Wallet')
            ->logOnly(['account_number', 'status']);
    }
    public function scopeWithSearch(Builder $query, $search): Builder
    {
        return $query->where('account_number', 'like', '%' . $search . '%')
            ->orWhereHas('agent', fn($query) => $query->withSearch($search));
    }

    public function getSummary(): array
    {
        $stats = $this->transactions()
            ->filterByDateDesc(request()->get('date_filter'))
            ->selectRaw('action, sum(amount) as amount')
            ->groupBy('action')
            ->pluck('amount', 'action');

        return [
            'credit' => $stats['CREDIT'] ?? 0,
            'debit' => $stats['DEBIT'] ?? 0,
        ];
    }
}
