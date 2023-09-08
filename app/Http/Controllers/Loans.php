<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\GeneralLedger;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class Loans extends Controller
{
    public function index(Request $request)
    {
        return view('pages.loans.index');
    }

    public function update(Request $request, Loan $loan)
    {
        $user = auth()->user();
        $status = $request->get('status');

        $request->validate([
            'status' => ['required', Rule::in(Status::forLoans()),
                Rule::prohibitedIf(
                    // Confirmation for admin only
                    ($status == Status::CONFIRMED->value && $user->cannot('approve loans')) ||

                    // Approval for super agent or admin
                    ($status == Status::APPROVED->value && (!$user->isSuperAgent() || $user->cannot('approve loans')))
                )
            ],
            'reason' => 'required_if:status,' . Status::DECLINED->value,
            'amount' => ['nullable', 'numeric', 'min:500', 'max:' . $loan->amount,
                Rule::prohibitedIf($status != Status::APPROVED->value)
            ]
        ]);

        // If confirmation is to be done by admin
        if ($status == Status::CONFIRMED->value) {
            // If the loan ledger balance is less than the requested amount
            if (GeneralLedger::forService('loan')->first()->balance < $loan->amount) {
                return back()->with('error', 'Insufficient ledger balance.');
            }
        }

        $loan->update($request->only(['status', 'reason']));

        $loan->processTransaction();

        return back()->with('success', 'Loan request ' . $request->get('status'));
    }
}
