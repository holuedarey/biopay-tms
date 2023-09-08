<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AssignUserRole extends Controller
{
    public function store(Request $request, $role)
    {
        $request->validate(['emails' => 'required|string']);

        $emails = array_map('trim', explode(',', $request->emails));

        $users = User::whereIn('email', $emails)->get();

        Role::findByName($role)->users()->syncWithoutDetaching($users);

        return back()->with('success', 'Successfully assigned role to user(s)');
    }

    public function destroy($role, User $user)
    {
        $user->removeRole($role);

        return back()->with('success', "$user->name is no longer " . ucwords($role));
    }
}
