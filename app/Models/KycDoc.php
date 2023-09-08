<?php

namespace App\Models;

use App\Enums\Documents;
use App\Traits\BelongsToSuperAgent;
use Cjmellor\Approval\Concerns\MustBeApproved;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class KycDoc extends Model
{
    use HasFactory, LogsActivity, BelongsToSuperAgent;

    protected $guarded = ['id'];

    protected $casts = [
        'type' =>  Documents::class,
        'verified_at' => 'datetime'
    ];

//    Attribute

    public function path(): Attribute
    {
        return Attribute::get(fn($value) => asset('storage/'. $value));
    }

    public function ext(): Attribute
    {
        return Attribute::get( fn() => str($this->path)->afterLast('.'));
    }

    public function isVerified(): bool
    {
        return !is_null($this->verified_at);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('KycDocs')
            ->logOnly(['name', 'path', 'type']);
    }

    public function scopeForLevel3(Builder $builder)
    {
        $builder->whereIn('type', [Documents::ID, Documents::UTILITY]);
    }

    public function scopeForLevel4(Builder $builder)
    {
        $builder->whereType(Documents::CAC);
    }

    public function scopeVerified(Builder $builder): void
    {
        $builder->whereNotNull('verified_at');
    }
}
