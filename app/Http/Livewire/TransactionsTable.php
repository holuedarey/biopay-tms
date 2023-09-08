<?php

namespace App\Http\Livewire;

use App\Models\Transaction;
use App\Models\User;
use App\Models\WalletTransaction;
use Livewire\Component;
use Livewire\WithPagination;

class TransactionsTable extends Component
{
    use WithPagination;

    public ?User $user = null;

    public string $type = 'all';

    public string $search = '';

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
        $transactions = match ($this->type) {
            'wallet' => $this->getWalletTransactions(),
            'all' => $this->getTransactions(),
            'single-user' => $this->getUserTransaction()
        };

        return view('livewire.transactions-table', compact('transactions'));
    }

    private function getWalletTransactions()
    {
        return WalletTransaction::latest()->with(['wallet', 'agent'])
            ->successful()->withSearch($this->search)
            ->filterByDate($this->date_filter)->paginate();
    }

    private function getTransactions()
    {
        return Transaction::latest()->with(['terminal', 'agent'])->withSearch($this->search)
            ->filterByDate($this->date_filter)->paginate();
    }

    private function getUserTransaction()
    {
        return $this->user->transactions()->latest()
            ->with('terminal')->withSearch($this->search)
            ->filterByDate($this->date_filter)->paginate();
    }

    public function filterDate(string $date = null): void
    {
        $this->date = $date ?? '';

        $this->date_filter = is_null($date) ? null : str($date)->explode(' - ')->toArray();
    }
}
