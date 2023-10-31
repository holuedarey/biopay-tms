<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class SuperAgentScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $user = Auth::user();

        $builder->when($user?->isSuperAgent() ?? false,
            fn(Builder $builder) => $builder->whereRelation('agent',
                fn($builder) => $builder->where('super_agent_id', $user->id)
                    ->orWhere('users.id', $user->id)
            )
        );
    }
}
