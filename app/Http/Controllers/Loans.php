<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Http\Requests\LoanRequest;
use App\Models\GeneralLedger;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class Loans extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Loan::class);
    }

    public function index(Request $request)
    {
        return view('pages.loans.index');
    }

    public function update(LoanRequest $request, Loan $loan)
    {
        return back()->with('success', 'Loan request ' . $request->get('status'));
    }
}
