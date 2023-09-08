<?php

namespace App\Http\Livewire;

use App\Models\Wallet;
use Livewire\Component;
use Livewire\WithPagination;

class WalletsTable extends Component
{
    use WithPagination;

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
        $wallets = Wallet::orderBy('account_number')->withSearch($this->search)
            ->with('agent')->paginate(config('app.pagination'));

        return view('pages.wallets.table', compact('wallets'));
    }
}
