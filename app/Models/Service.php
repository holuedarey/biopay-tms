<?php

namespace App\Models;

use App\Enums\Status;
use App\Exceptions\FailedApiResponse;
use Cjmellor\Approval\Concerns\MustBeApproved;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * These hold the services for which every transaction occurring on the system is carried out for.
 * <p>They include **bill payments**, **transfers**, **withdrawal**, **funding**, etc.
 */
class Service extends Model
{
    use HasFactory, LogsActivity, MustBeApproved;

    protected $guarded = ['id'];

    protected $casts = [
        'is_available' => 'boolean',
        'menu' => 'boolean'
    ];

    protected $appends = [
        'icon'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(fn ($service) => $service->slug = str($service->name)->slug(''));

        static::created(function ($service) {
            \Cache::forget('services');
            if ($service->wasChanged(['menu_name'])) \Cache::forget('default-menus');
        });

        static::updated(function ($service) {
            \Cache::forget('services');
            if ($service->wasChanged(['menu_name'])) \Cache::forget('default-menus');
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected function icon(): Attribute
    {
        return Attribute::get(function () {
            return match ($this->slug) {
                'banktransfer' => asset('assets/images/services/transfer.webp'),
                'cashoutwithdrawal' => asset('assets/images/services/cashout.webp'),
                'cabletv' => asset('assets/images/services/cabletv.webp'),
                'loan' => asset('assets/images/services/loan.webp'),
                'internetdata' => asset('assets/images/services/data.webp'),
                'airtime' => asset('assets/images/services/airtime.webp'),
                'electricity' => asset('assets/images/services/electricity.webp'),
                default => asset('assets/images/services/topup.webp')
            };
        });
    }

// Relationships

    public function providers(): HasMany
    {
        return $this->hasMany(ServiceProvider::class);
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(ServiceProvider::class, 'provider_id');
    }

    public function walletTransactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'type_id');
    }

    public function generalLedger(): HasOne
    {
        return $this->hasOne(GeneralLedger::class);
    }

    public function terminals(): BelongsToMany
    {
        return $this->belongsToMany(Terminal::class)->withTimestamps();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Service')
            ->logOnly(['name', 'description', 'provider']);
    }

    public function scopeWithSearch(Builder $query, $search): Builder
    {
        return $query->where('name', 'like', '%' . $search . '%');
    }

    public function scopeRegular(Builder $query): Builder
    {
        return $query->orderBy('name')->whereNotIn('slug', ['wallettransfer']);
    }

    public function scopeTransactionCount(Builder $query, string $period, ?User $user = null): Builder
    {
        // Get the failed and successful transactions for the time period.
        $selected = [
            'transactions as failed' => fn($query) => $query->filterByDateDesc($period)
                ->whereStatus(Status::FAILED)
                ->when($user ?? false)->forUser($user),
            'transactions as successful' => fn($query) => $query->filterByDateDesc($period)
                ->whereStatus(Status::SUCCESSFUL)
                ->when($user ?? false)->forUser($user),
        ];

        // Get the failed and successful transactions for the previous time period.
        switch ($period) {
            case 'today':
                $previous = [
                    'transactions as previous_failed' => fn($query) => $query->filterByDateDesc('yesterday')
                        ->whereStatus(Status::FAILED)
                        ->when($user ?? false)->forUser($user),
                    'transactions as previous_successful' => fn($query) => $query->filterByDateDesc('yesterday')
                        ->whereStatus(Status::SUCCESSFUL)
                        ->when($user ?? false)->forUser($user),
                ];
                break;

            case 'yesterday': $date = [today()->subDays(2)->toDateString()];
                $previous = [
                    'transactions as previous_failed' => fn($query) => $query->filterByDate($date)
                        ->whereStatus(Status::FAILED)
                        ->when($user ?? false)->forUser($user),
                    'transactions as previous_successful' => fn($query) => $query->filterByDate($date)
                        ->whereStatus(Status::SUCCESSFUL)
                        ->when($user ?? false)->forUser($user),
                ];
                break;

            case 'month': $date = today()->subMonth();
                $previous = [
                    'transactions as previous_failed' => fn($query) => $query->whereStatus(Status::FAILED)
                        ->whereMonth(self::CREATED_AT, $date->month)
                        ->whereYear(self::CREATED_AT, $date->year)
                        ->when($user ?? false)->forUser($user),
                    'transactions as previous_successful' => fn($query) => $query->whereStatus(Status::SUCCESSFUL)
                        ->whereMonth(self::CREATED_AT, $date->month)
                        ->whereYear(self::CREATED_AT, $date->year)
                        ->when($user ?? false)->forUser($user),
                ];
                break;

            case 'year': $date = today()->subYear();
                $previous = [
                    'transactions as previous_failed' => fn($query) => $query->whereStatus(Status::FAILED)
                        ->whereYear(self::CREATED_AT, $date->year)
                        ->when($user ?? false)->forUser($user),
                    'transactions as previous_successful' => fn($query) => $query->whereStatus(Status::SUCCESSFUL)
                        ->whereYear(self::CREATED_AT, $date->year)
                        ->when($user ?? false)->forUser($user),
                ];
                break;

            default: $previous = [];
                break;
        }

        return $query->withCount(array_merge($selected, $previous));
    }

    /**
     * Get the class for the active provider of the service.
     *
     * @param string $service The slug for the service as stored in the db <i>services</i> table.
     * @param string $error_name The name of the error to show on failed response.
     * @return mixed
     * @throws \Throwable
     */
    public static function getActiveProviderFor(string $service, string $error_name): mixed
    {
        $provider = Service::whereSlug($service)->first()?->provider;

        throw_if(is_null($provider), new FailedApiResponse("$error_name is currently unavailable.", 404));

        return new $provider->class;
    }
}
