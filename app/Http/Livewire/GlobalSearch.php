<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class GlobalSearch extends Component
{
    public string $search = '';

    public function render()
    {
        $users  = empty($this->search) ? new Collection() : User::withSearch($this->search)->limit(5)->get();

        return view('livewire.global-search', compact('users'));
    }
}
