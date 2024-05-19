<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Helpers\MyResponse;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TransactionsApi extends Controller
{
    public string $type = 'all';
    public ?array $date_filter = [];

    public function index(Request $request)
    {
        $request->user()->can('read transactions');
        $this->type = !empty($request->query('type')) ? $request->query('type') : $this->type;
        $transactions = match ($this->type) {
            'wallet' => $this->getWalletTransactions($request),
            'all' => $this->getTransactions($request),
            'single-user' => $this->getUserTransaction($request)
        };
        return  MyResponse::staticSuccess('Data Retrieved Successfully', compact('transactions'));
    }

    private function getWalletTransactions($request)
    {
        return WalletTransaction::latest()->with(['wallet', 'agent'])
            ->successful()->withSearch($request->query('search') || "")
            ->filterByDate($this->date_filter ?? [])->paginate();
    }

    private function getTransactions($request)
    {
        return Transaction::latest()->with(['terminal', 'agent'])->withSearch($request->query('search') || "")
            ->filterByDate($this->date_filter ?? [])->paginate();
    }

    private function getUserTransaction($request)
    {
        return $request->user()->transactions()->latest()
            ->with('terminal')->withSearch($request->query('search') | "")
            ->filterByDate($this->date_filter ?? [])->paginate();
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->user()->can('update transactions');

        $request->validate([
            'status' => ['required', Rule::in([Status::SUCCESSFUL->value, Status::FAILED->value])]
        ]);

        $transaction->update(['status' => $status = $request->get('status')]);

        if ($status == Status::FAILED->value && $transaction->wallet_debited) {
            $transaction->agent->wallet->credit($transaction->total_amount, $transaction->service, info: "REVERSAL:: $transaction->info");
        }

        return back()->with('success', "Transaction marked as $status!");
    }
}
