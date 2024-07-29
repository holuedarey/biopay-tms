<?php

namespace App\Http\Controllers\WebApi;

use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleCreateRequest;
use App\Http\Requests\RoleRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use App\Models\Role;

class Roles extends Controller
{
    public function __construct()
    {

      // $this->authorizeResource(Role::class);
    }

    public function index()
    {

//        if (!auth()->user()->can('viewAny')) {
//            return MyResponse::failed('You do not have permission to view roles.', 403);
//        }

        $roles = Role::orderBy('name')
            ->withCount(['users', 'permissions'])
            ->with(['users' => fn($query) => $query->inRandomOrder()->limit(6)])
            ->get();
        return MyResponse::staticSuccess("Roles fetched successful! ", compact('roles'));
    }



    public function store(RoleCreateRequest $request)
    {

        $role = Role::create($request->only('name', 'type'));

        $role->givePermissionTo($request->permissions);

        return MyResponse::staticSuccess("New role added! ", compact('role'));
    }

    public function update(RoleUpdateRequest $request, Role $role)
    {
       //dd($request);

        if (!in_array($role->type, [Role::SUPERAGENT, Role::AGENT]))
            $role->update(['name' => $request->name]);

//            Don't change agent's permissions
        if ($role != Role::AGENT) {
            $role->syncPermissions($request->permissions);
        }

        return MyResponse::staticSuccess("Role edited! ");
    }
}
