<?php

namespace App\Http\Livewire;

use App\Models\WalletTransaction;
use Livewire\Component;
use Livewire\WithPagination;

class LedgerPage extends Component
{
    use WithPagination;

    public $search = '';

    public string $date = '';

    public ?array $date_filter = null;

    protected $queryString = [
        'search' => ['except' => '', 'as' => 'q']
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $transactions = WalletTransaction::latest()
            ->successful()->with(['service', 'wallet', 'agent'])
            ->withSearch($this->search)
            ->filterByDate($this->date_filter)
            ->paginate();

        $type = WalletTransaction::successful()->withSearch($this->search)
            ->filterByDate($this->date_filter)->groupBy('action')
            ->selectRaw('action, sum(amount) as amount')
            ->pluck('amount', 'action');

        $yesterday = date("Y-m-d", strtotime( '-1 days' ) );
        $openingBalance = WalletTransaction::whereDate('created_at', $yesterday)->latest()->first();
        $openingBalance = $openingBalance->new_balance ?? 0;

        $closingBalance = WalletTransaction::whereDate('created_at', today()->format('Y-m-d'))->latest()->first();
        $closingBalance = $closingBalance->new_balance ?? 0;

        return view('livewire.ledger-page', compact('type', 'transactions', 'closingBalance', 'openingBalance'));
    }

    public function filterDate(string $date = null): void
    {
        $this->date = $date ?? '';

        $this->date_filter = is_null($date) ? null : str($date)->explode(' - ')->toArray();
    }
}
