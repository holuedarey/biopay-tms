<?php

namespace App\Http\Controllers;

use App\Models\GeneralLedger;
use App\Models\Terminal;
use App\Models\Transaction;
use App\Models\User;

class Dashboard extends Controller
{
    public function __invoke()
    {
        $agents = User::agent()->with('kycLevel')->limit(5)->get();

        $latest_transactions = Transaction::with(['agent'])->latest()->limit(5)->get();

        $terminals = Terminal::countByStatus();

        $gl_balance = GeneralLedger::getBalances();

        return view('pages.dashboard', compact('agents', 'latest_transactions', 'terminals', 'gl_balance'));
    }
}
