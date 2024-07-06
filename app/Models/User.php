<?php

namespace App\Models;

use App\Enums\Documents;
use App\Enums\Status;
use App\Helpers\FileHelper;
use App\Traits\HasKycCheck;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

/**
 * @method static find($userId)
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, LogsActivity, CausesActivity, HasApiTokens, HasKycCheck, SoftDeletes;

    /**
     * The application has two types of users which can either be `Agents` or `Admins`
     *<p>The role management of this system is divided into these as the groups.
     * <p>Therefore, each role created can either be an Admin (always the first index) or an Agent (the second index).
     */
    const GROUPS = ['Admins', 'Agents'];
    const ALL_STATUS = ['ACTIVE', 'INACTIVE', 'SUSPENDED', 'DISABLED'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $with = ['roles'];

    protected static string $logName = 'User';


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed'
    ];

    protected $appends = ['name'];

//    Relationships

    public function superAgent(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function agents(): HasMany
    {
        return $this->hasMany(User::class, 'super_agent_id');
    }

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function walletTransactions(): HasManyThrough
    {
        return $this->hasManyThrough(WalletTransaction::class, Wallet::class)
            ->where('wallet_transactions.status', Status::SUCCESSFUL);
    }

    public function terminals(): HasMany
    {
        return $this->hasMany(Terminal::class);
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    public function disputes(): HasMany
    {
        return $this->hasMany(Dispute::class);
    }

// Attributes

    /**
     * The getter that return accessible URL for user photo.
     *
     * @return Attribute
     */
    public function avatar(): Attribute
    {
        return Attribute::make(
            get: fn($value) => !is_null($value) ? asset('storage/'. $value)
                : asset('build/assets/images/'. strtolower($this->gender) .'.jpeg'),
            set: fn($value) => FileHelper::processFileUpload($value, 'avatar')
        );
    }

    public function name(): Attribute
    {
        return Attribute::get(
            fn($value) => "$this->first_name $this->other_names"
        );
    }

    public function roleName(): Attribute
    {
        $roles = $this->getRoleNames();

        return Attribute::get(
            fn($value) => $roles->count() < 1 ? null : $roles->first()
        );
    }

    public function roleType(): Attribute
    {
        return Attribute::get(
            fn($value) => $this->roles->first()->type
        );
    }

    public function isActive(): Attribute
    {
        return Attribute::get(
            fn($value) => $this->status == 'ACTIVE'
        );
    }

//    Methods

    /**
     * check that the user is part of agents roles
     * @return bool
     */
    public function isAgentGroup(): bool
    {
        $agents = Role::where('type', self::GROUPS[1])->pluck('name')->toArray();

        return $this->hasAnyRole($agents);
    }

    public function isAdmin(): bool
    {
        // Cache to avoid fetching model multiple times in a day.
        return Cache::remember("{$this->id}_is_admin", now()->addDay(),
            fn() => $this->roles()->where('type', User::GROUPS[0])->exists()
        );
    }

    public function isSuperAgent(): bool
    {
        // Cache to avoid fetching model multiple times in a day.
        return Cache::remember("{$this->id}_id_superagent", now()->addDay(),
            fn() => $this->getRoleNames()->contains(Role::SUPERAGENT)
        );
    }

    public function isAgent(): bool
    {
        // Cache to avoid fetching model multiple times in a day.
        return Cache::remember("{$this->id}_id_agent", now()->addDay(),
            fn() => $this->getRoleNames()->contains(Role::AGENT)
        );
    }

    /**
     * Change the terminal status to the opposite value
     */
    public function changeStatus(string $new_status = null): void
    {
        $this->status = $new_status;
        $this->save();
    }

    /**
     * Generate the api token for the terminal authentication.
     *
     * @param Terminal $terminal
     * @return array<string,string> of the token <b>value</b>, <b>type</b> and <b>expires_at</b>
     */
    public function generateToken(Terminal $terminal): array
    {
        return [
            'value'  => $this->createToken("$terminal->serial terminal token")->plainTextToken,
            'type'    => 'Bearer',
            'expires_at' => now()->addMinutes(config('sanctum.expiration'))->toDateTimeString()
        ];
    }

    /**
     * @return array
     */
    public function scopeToken(): array
    {
        return [
            'access_type' => 'Bearer',
            'access_token' => $this->createToken($this->id)->plainTextToken
        ];
    }

    /**
     * Set the initial user password to the specified user's <b>first_name</b>
     * combined with the last 5 digits of their <b>phone_number</b>.
     *
     * @return string
     */
    public function getInitialPassword(): string
    {
        return App::isProduction() ?
            str($this->phone)->substr(-5)->prepend($this->first_name)->lower() : 'tms4231';
    }

    public function updateLevel(int $level): void
    {
        $this->level_id = $level;
        $this->save();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Users')
            ->logOnly(['name', 'email'])
            ->logOnlyDirty();
    }


    public function scopeWithSearch(Builder $query, $search): Builder
    {
        return $query->where('first_name', 'like', '%' . $search . '%')
            ->orWhere('other_names', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%')
            ->orWhere('phone', 'like', '%' . $search . '%');
    }

    public function scopeAgent(Builder $builder): void
    {
        $builder->whereRelation('roles', 'type', User::GROUPS[1]);
    }

    public function scopeStaff(Builder $builder): void
    {
        $builder->whereRelation('roles', 'type', User::GROUPS[0]);
    }

    public function scopeViewable(Builder $builder): void
    {
        $user = Auth::user();

        $builder->when($user->isSuperAgent(),
            fn(Builder $query) => $query->where('super_agent_id', $user->id)
        );
    }

    public function createDummyTerminal(string $serial, string $device, string $phone): void
    {
        $this->terminals()->create([
            'serial' => $serial,
            'device' => $device,
            'mid' => str_pad('2023', 15, '0', STR_PAD_RIGHT),
            'tid' => Terminal::generateTid($phone)
        ])->withoutApproval()->save();
    }

    public function hasVerifiedDocsForLevel3(): bool
    {
        return Cache::remember('leve3-docs', now()->seconds(10), function () {
            return $this->kycDocs()->verified()->whereType(Documents::UTILITY->value)->exists()
            && $this->kycDocs()->verified()->whereType(Documents::ID->value)->exists();
        });
    }

    public function hasVerifiedDocsForLevel4(): bool
    {
        return Cache::remember('level4-docs', now()->addSeconds(10), function () {
            return $this->kycDocs()->verified()->whereType(Documents::CAC->value)->exists()
                && $this->hasVerifiedDocsForLevel3();
        });
    }

    /**
     * @return Arrayable
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function transactionStats(): Arrayable
    {
        $stats = $this->transactions()->successful()
            ->filterByDateDesc(request()->get('date_filter'), 'transactions.created_at')
            ->sumAmountAndCountByService()->get();

        return Service::limit(6)->orderBy('slug')->get()->map(function ($service) use ($stats) {
            return collect($service->only(['slug', 'name']))->merge([
                'amount' => $stats->where('slug', $service->slug)->first()->amount ?? 0,
                'count' => $stats->where('slug', $service->slug)->first()->count ?? 0
            ]);
        });
    }

    /**
     * Get the wallet of the Super Agent else get the system admin wallet.
     *
     * @return Wallet
     */
    public function getSuperAgentWallet(): Wallet
    {
        return $this->superAgent?->wallet ?? Wallet::find(1);
    }
}
