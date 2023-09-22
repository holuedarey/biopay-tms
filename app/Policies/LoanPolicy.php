<?php

namespace App\Policies;

use App\Enums\Status;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LoanPolicy
{
    public function before(User $user)
    {
        if ($user->can('approve loans')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Loan $loan): bool
    {
        return $loan->user->super_agent_id == $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAgentGroup();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Loan $loan): bool
    {
        // Only admin that can approve loans can perform the update
        if (request('status') == Status::CONFIRMED->value) return false;

        return $user->isActive() && $user->is($loan->agent->superAgent);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Loan $loan): bool
    {
        return $loan->isPending() && $user->is($loan->user);
    }
}
