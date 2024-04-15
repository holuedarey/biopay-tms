<?php

namespace App\Http\Controllers\Api;

use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Terminal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class   Register extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'serial' => 'required|string|unique:terminals',
            'device' => 'required|string',
            'first_name' => 'required|string',
            'other_names' => 'required|string',
            'email' => 'required|email:rfc,dns|unique:users',
            'phone' => 'required|digits:11|unique:users',
            'gender' => 'required|in:MALE,FEMALE',
            'dob' => 'required|date',
            'state' => 'required|string',
            'address' => 'required|string',
            'password' => 'required|confirmed',
            'role' => ['nullable', Rule::in([Role::AGENT, Role::SUPERAGENT])]
        ]);


        $user = User::create(collect($data)->except(['serial', 'device'])->toArray());

        $user->assignRole($data['role'] ?? Role::AGENT);

            $user->createDummyTerminal(...$request->only('serial', 'device', 'phone'));

        return MyResponse::success('Registration successful! Proceed to login to your device.');
    }
}
