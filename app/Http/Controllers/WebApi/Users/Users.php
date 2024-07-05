<?php

namespace App\Http\Controllers\WebApi\Users;

use App\Helpers\MyResponse;
use App\Helpers\RoleHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\TerminalGroup;
use App\Models\User;
use App\Notifications\AccountRegistration;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class Users extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class);
    }

    public function create()
    {
        if (request()->routeIs('agents.onboard')) {
            $roles = RoleHelper::getAgentRoles();
            $title = Role::AGENT . '/' . Role::SUPERAGENT . ' Onboarding';
            $super_agents = Role::findByName(Role::SUPERAGENT)->users;
        }
        elseif(request()->routeIs('admins.register')) {
            $roles = RoleHelper::getAdminRoles();
            $title = 'Admin Registration';
            $super_agents = collect();
        }
        else {
            abort(403, 'Invalid Request');
        }

        return view('pages.manage-users.register', compact('roles', 'title', 'super_agents'));
    }

    public function createAdmin()
    {

        if (request()->is( 'api/v1/manage-users/onboard')) {
            $roles = RoleHelper::getAgentRoles();
            $title = Role::AGENT . '/' . Role::SUPERAGENT . ' Onboarding';
            $super_agents = collect();
        }
        elseif(request()->is('api/v1/manage-users/admins/register')) {
            $roles = RoleHelper::getAdminRoles();
            $title = 'Admin Registration';
            $super_agents = collect();
        }
        else {
            return  MyResponse::staticSuccess('Invalid Request');
        }

        return  MyResponse::staticSuccess('Data Retrieved Successfully', compact('roles', 'title', 'super_agents'));
    }
    public function show(User $user)
    {
        $user->load('kycDocs', 'terminals');
        $agents = [];
        if($user->isSuperAgent()){
            $agents = User::where('super_agent_id', $user->getAuthIdentifier())->get();
        }
        $transactions = (object) [
            'today' => $user->transactions()->filterByDateDesc('today')->sumAndCount(),
            'week' => $user->transactions()->filterByDateDesc('week')->sumAndCount(),
            'month' => $user->transactions()->filterByDateDesc('month')->sumAndCount(),
            'year' => $user->transactions()->filterByDateDesc('year')->sumAndCount(),
        ];

        return view('pages.manage-users.show', compact('user', 'transactions', 'agents'));
    }

    public function store(RegisterUserRequest $request)
    {
        $data = $request->role == Role::AGENT ? $request->validated() : $request->except('super_agent_id');

        $user = User::create($data); // Observer creates password, level and wallet;

        $user->assignRole($request->role);

        $user->notify(new AccountRegistration);

        return to_route('users.show', $user)->with('success', "$request->role onboarding successful!");
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());

        return back()->with('success', 'Update successful!');
    }

    public function showApi(Request $request, User $user)
    {
        Log::notice(json_encode($request));
        $user->load('kycDocs', 'terminals');

        $transactions = (object) [
            'today' => $user->transactions()->filterByDateDesc('today')->sumAndCount(),
            'week' => $user->transactions()->filterByDateDesc('week')->sumAndCount(),
            'month' => $user->transactions()->filterByDateDesc('month')->sumAndCount(),
            'year' => $user->transactions()->filterByDateDesc('year')->sumAndCount(),
        ];
        return  MyResponse::staticSuccess('Data Retrieved Successfully', compact('transactions'));
    }

    public function storeApi(RegisterUserRequest $request)
    {
        $data = $request->role == Role::AGENT ? $request->validated() : $request->except('super_agent_id');

        $user = User::create($data); // Observer creates password, level and wallet;

        $user->assignRole($request->role);

        $user->notify(new AccountRegistration);

        return  MyResponse::staticSuccess("$request->role onboarding successful!");

    }

    public function updateApi(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        return  MyResponse::staticSuccess('Update successful!');
    }
}
