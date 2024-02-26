<?php

namespace App\Http\Controllers;

use App\Helpers\MyResponse;
use App\Helpers\RoleHelper;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class Admin extends Users
{
    public ?Role $role = null;
    public string $name ='admins';
    public string $search = '';

    public function index(Request $request)
    {
        $request->user()->can('read admin');

        return view('pages.manage-users.admin');
    }

    public function indexApi(Request $request)
    {
        $request->user()->can('read admin');
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
