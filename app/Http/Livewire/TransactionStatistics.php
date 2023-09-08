<?php

namespace App\Http\Livewire;

use App\Models\Transaction;
use App\Models\WalletTransaction;
use Livewire\Component;

class TransactionStatistics extends Component
{
    public string $filter = 'today';

    public function render()
    {
        $transactions = (object) [
            'total' => Transaction::successful()->filterByDateDesc($this->filter)->sum('amount'),
            'count' => Transaction::successful()->filterByDateDesc($this->filter)->count(),
        ];

        $revenue = Transaction::successful()->filterByDateDesc($this->filter)->sum('charge');

        // Credit and debit total amounts
        $type = WalletTransaction::filterByDateDesc($this->filter)->groupBy('action')
            ->selectRaw('action, sum(amount) as amount')
            ->pluck('amount', 'action');

        $services_stats = Transaction::successful()->filterByDateDesc($this->filter, 'transactions.created_at')
            ->sumAmountAndCountByService()->get();

        $this->dispatchBrowserEvent('dashboard-transaction-chart');

        return view('livewire.transaction-statistics', compact('transactions', 'revenue', 'type', 'services_stats'));
    }


}
