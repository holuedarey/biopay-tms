<?php

namespace App\Http\Controllers\WebApi;

use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class AssignUserRole extends Controller
{
    public function store(Request $request, $role)
    {
//        // Find the role by name
//        $roled = Role::findById($role);
//        dd($roled);
        $request->validate(['emails' => 'required|string']);

        $emails = array_map('trim', explode(',', $request->emails));

        $users = User::whereIn('email', $emails)->get();

        Role::findByName($role)->users()->syncWithoutDetaching($users);
        return MyResponse::staticSuccess("Successfully assigned role to user(s)");

    }

    public function destroy($role, User $user)
    {
        if (!Gate::allows('delete', $user)) {
            abort(403, 'Unauthorized action.'); // Throw 403 Forbidden if not allowed
        }

        $user->removeRole($role);
        return MyResponse::staticSuccess("$user->name's role is no longer " . ucwords($role));

    }
}
