<?php

namespace App\Http\Livewire;

use App\Models\Approval;
use Livewire\Component;
use Livewire\WithPagination;

class ApprovalsTable extends Component
{
    use WithPagination;

    public function render()
    {
        $approvals = Approval::pending()->latest()->paginate();

        return view('livewire.approvals-table', compact('approvals'));
    }
}
