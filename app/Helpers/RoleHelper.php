<?php

namespace App\Helpers;

use App\Models\User;
use Spatie\Permission\Models\Role;

class RoleHelper
{
    public static function getAgentRoles(): array
    {
        return Role::whereType(User::GROUPS[1])->pluck('name')->toArray();
    }

    public static function getAdminRoles(): array
    {
        return Role::whereType(User::GROUPS[0])->pluck('name')->toArray();
    }
}
