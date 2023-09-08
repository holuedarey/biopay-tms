<?php

namespace App\Http\Controllers;

use App\Enums\Action;
use App\Models\Approval;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class Wallets extends Controller
{
    public function index(Request $request)
    {
        $request->user()->can('read wallets');

        return view('pages.wallets.index');
    }

    public function update(Request $request, Wallet $wallet)
    {
        $request->validate([
            'amount' => 'required|numeric|min:50',
            'action' => ['required', Rule::in(Action::values())],
            'info' => 'required|string|max:100'
        ]);

        $action = $request->get('action');

        Approval::create([
            'approvalable_type' => Wallet::class,
            'approvalable_id' => $wallet->id,
            'performed_by' => auth()->id(),
            'new_data' => [
                'info' => $request->get('info') . ' - By ' . auth()->user()->name,
                'account_number' => $wallet->account_number,
                'account_holder' => $wallet->agent->name,
                'amount' => (float) $request->get('amount'),
                'action' => $action,
            ]
        ]);

        return back()->with('pending', "Awaiting approval for wallet $action!");
    }
}
