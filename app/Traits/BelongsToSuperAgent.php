<?php

namespace App\Traits;

use App\Models\Scopes\SuperAgentScope;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToSuperAgent
{
    public static function bootBelongsToSuperAgent(): void
    {
        static::addGlobalScope(new SuperAgentScope);
    }

    /**
     * @return BelongsTo
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeForAgent(Builder $builder, $agent): void
    {
        $builder->whereBelongsTo($agent, 'agent');
    }
}
