<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Seed permissions
        collect($this->permissionsSeeder())->each(fn($value) => Permission::create(['name' => $value]));

        $staff_roles = [Role::ADMIN, Role::SUPERADMIN];
        $agent_roles = [Role::SUPERAGENT, Role::AGENT];

//        create roles for admin and super admin
        collect($staff_roles)->each(function ($value) {
            $role = Role::create([
                'name' => $value,
                'type' => User::GROUPS[0]
            ]);

            $role->givePermissionTo(Permission::pluck('name')->toArray());
        });

        $role = Role::create([
            'name' => 'APPROVER',
            'type' => User::GROUPS[0]
        ]);

        $role->givePermissionTo('approve actions');

        collect($agent_roles)->each(function ($value) {
            $role = Role::create([
                'name' => $value,
                'type' => User::GROUPS[1]
            ]);

            if ($value == Role::SUPERAGENT)
                $role->givePermissionTo([
                    'read customers',
                    'create users',
                    'edit users',
                    'read terminals',
                    'create terminals',
                    'edit terminals',
                    'read ledger',
                    'read wallets',
                    'read transactions',
                    'approve loans',
                ]);
        });
    }

    public function permissionsSeeder(): array
    {
        return [
            'read admin',
            'read customers',
            'create users',
            'edit users',
            'disable users',
            'read kyc-level',
            'create kyc-level',
            'edit kyc-level',
            'read roles',
            'create roles',
            'edit roles',
            'delete roles',
            'edit permissions',
            'read wallets',
            'edit wallets',
            'read groups',
            'create groups',
            'edit groups',
            'delete groups',
            'read terminals',
            'create terminals',
            'edit terminals',
            'delete terminals',
            'read fees',
            'edit fees',
            'read general ledger',
            'edit general ledger',
            'read ledger',
            'read dispute',
            'create dispute',
            'edit dispute',
            'read settings',
            'create settings',
            'edit settings',
            'read transactions',
            'approve actions',
            'read menus',
            'edit menus',
            'create terminal-processors',
            'read terminal-processors',
            'delete terminal-processors',
            'update terminal-processors',
            'read loans',
            'approve loans',
        ];

    }
}
