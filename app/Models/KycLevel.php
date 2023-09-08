<?php

namespace App\Models;

use App\Enums\Documents;
use Cjmellor\Approval\Concerns\MustBeApproved;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class KycLevel extends Model
{
    use HasFactory, LogsActivity;

    const SILVER = 1;
    const GOLD = 2;
    const DIAMOND = 3;
    const MERCHANT = 4;

    protected $guarded = ['id'];

    protected $appends = ['required_doc'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'level_id');
    }

    public function name(): Attribute
    {
        return Attribute::set(fn($value) => strtoupper($value));
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('KycLevel')
            ->logOnly(['name', 'daily_limit']);
    }

    public function requiredDoc(): Attribute
    {
        return Attribute::get(fn() => match ($this->id) {
            1 => null,
            2 => 'BVN',
            3 => Documents::ID->name() . '/' . Documents::UTILITY->name(),
            4 => Documents::CAC->name(),
        });
    }
}
