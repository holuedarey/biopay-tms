<?php

namespace App\Policies;

use App\Models\Terminal;
use App\Models\TerminalProcessor;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TerminalProcessorPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('read terminal-processors');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TerminalProcessor $terminalProcessor): bool
    {
        return $user->is($terminalProcessor->owner) || $user->can('update', $terminalProcessor);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create terminal-processors');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TerminalProcessor $terminalProcessor): bool
    {
        return $user->is($terminalProcessor->owner) || $user->can('update terminal-processors');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Terminal $terminal): bool
    {
        //
    }
}
