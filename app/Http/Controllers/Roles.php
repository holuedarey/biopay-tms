<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use App\Models\Role;

class Roles extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Role::class);
    }

    public function index()
    {
        $roles = Role::orderBy('name')
            ->withCount(['users', 'permissions'])
            ->with(['users' => fn($query) => $query->inRandomOrder()->limit(6)])
            ->get();

        return view('pages.access-control.roles.index', compact('roles'));
    }

    public function show(Role $role)
    {
        $permissions = Permission::all()->sortBy('name')->pluck('name')->toArray();

        return view('pages.access-control.roles.show', compact('role', 'permissions'));
    }

    public function create()
    {
        $permissions = Permission::all();

        $types = User::GROUPS;

        return view('pages.access-control.roles.create', compact('permissions', 'types'));
    }

    public function store(RoleRequest $request)
    {
        $role = Role::create($request->only('name', 'type'));

        $role->givePermissionTo($request->permissions);

        return to_route('roles.index')->with('success', 'New role added!');
    }

    public function update(RoleRequest $request, Role $role)
    {
        if (!in_array($role->type, [Role::SUPERAGENT, Role::AGENT]))
            $role->update(['name' => $request->name]);

//            Don't change agent's permissions
        if ($role != Role::AGENT) {
            $role->syncPermissions($request->permissions);
        }

        return  back()->with('success', 'Role edited!');
    }
}
