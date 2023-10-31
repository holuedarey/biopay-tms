<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function before(User $user)
    {
        if ($user->isAdmin()) return true;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->canAny(['read customers', 'read admin']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        if ($user->is($model)) return true;

        if ($user->isSuperAgent())
            return ($user->id == $model->super_agent_id && $user->can('read customers'));

        return $user->can('read admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create users');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        if ($user->isSuperAgent())
            return $user->is($model) || ($user->is($model->superAgent) && $user->can('edit users'));

        return $user->is($model) || $user->can('edit users');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return false;
    }
}
