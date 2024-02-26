<?php

namespace App\Http\Controllers;


use App\Helpers\MyResponse;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class Agent extends Users
{
    public string $search = '';
    public ?Role $role = null;
    public string $name =  '';

    public function index(Request $request)
    {
        $request->user()->can('read customers');

        return view('pages.agents.index');
    }

    public function indexApi(Request $request)
    {
        $request->user()->can('read customers');
        $this->name = request()->is('api/v1/manage-users/agents') ? \App\Models\Role::AGENT : \App\Models\Role::SUPERAGENT;
        $this->search = $request->query('search') || '';
        if (!is_null($this->role)) {
            $users = $this->role->users()->paginate();
        }
        elseif ($this->name == 'admins') {
            $users = User::staff()->with('kycLevel')
                ->withSearch($this->search)
                ->latest()->paginate();
        }
        else {
            $users = User::role($this->name)
                ->latest()->viewable()
                ->with('kycLevel')
                ->withSearch($this->search)
                ->paginate();
        }
        return  MyResponse::staticSuccess('Data Retrieved Successfully',compact('users'));

    }
}
