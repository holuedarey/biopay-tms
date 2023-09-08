<?php

namespace App\Rules;

use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class UserIsAgent implements Rule
{
    public User|null $user = null;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $this->user = User::where($attribute, $value)->first();

        return  $this->user?->hasAnyRole([Role::AGENT, Role::SUPERAGENT]) ?? false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Invalid '. Role::AGENT . '/' . Role::SUPERAGENT . ' email.';
    }
}
