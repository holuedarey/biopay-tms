<?php

namespace App\Http\Livewire;

use App\Models\Loan;
use Livewire\Component;
use Livewire\WithPagination;

class LoansTable extends Component
{
    use WithPagination;

    public function render()
    {
        $loans = Loan::latest()->with(['agent', 'transaction'])
            ->when(!auth()->user()->isAdmin(),
                fn($query) => $query->with('confirmedBy')
            )->paginate();

        return view('livewire.loans-table', compact('loans'));
    }
}
