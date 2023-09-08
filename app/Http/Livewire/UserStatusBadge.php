<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Component;

class UserStatusBadge extends Component
{

    public User $user;
    public array $statuses = User::ALL_STATUS;

    public function render()
    {
        return view('pages.manage-users.status-badge');
    }

    public function updateStatus(string $status = null)
    {
        if (!in_array($status, $this->statuses)) abort(403, 'Invalid Request!');

        $this->user->update(['status' => $status]);
    }
}
