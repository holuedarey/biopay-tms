<?php

namespace App\Http\Livewire;

use App\Helpers\RoleHelper;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Routing\Route;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Role;

class UsersTable extends Component
{
    use WithPagination;

    public string $name;
    public bool $showRole = true;
    public bool $showLevel = false;
    public bool $showAction = true;
    public ?string $roleAction = null;
    public ?Role $role = null;

    public string $search = '';

    protected $queryString = [
        'search' => ['except' => '', 'as' => 'q']
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        if (!is_null($this->role)) {
            $users = $this->role->users()->paginate();
        }
        elseif ($this->name == 'admins') {
            $users = User::staff()->with('kycLevel')
                ->withSearch($this->search)
                ->latest()->paginate();
        }
        else {
            $users = User::role($this->name)->with('kycLevel')
                ->withSearch($this->search)
                ->latest()->paginate();
        }

        return view('pages.manage-users.table', compact('users'));
    }
}
