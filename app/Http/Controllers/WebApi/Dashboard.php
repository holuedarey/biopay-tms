<?php

namespace App\Http\Controllers\WebApi;

use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;
use App\Models\GeneralLedger;
use App\Models\Terminal;
use App\Models\Transaction;
use App\Models\User;

class Dashboard extends Controller
{
    public function __invoke()
    {
        $agents = User::viewable()->agent()->with('kycLevel')->limit(5)->get();

        $latest_transactions = Transaction::with(['agent'])->latest()->limit(5)->get();

        $terminals = Terminal::countByStatus();

        $gl_balance = GeneralLedger::getBalances();

        return view('pages.dashboard', compact('agents', 'latest_transactions', 'terminals', 'gl_balance'));
    }

    public function dashboardApi()
    {
        $agents = User::viewable()->agent()->with('kycLevel')->limit(5)->get();

        $latest_transactions = Transaction::with(['agent'])->latest()->limit(5)->get();

        $terminals = Terminal::countByStatus();

        $gl_balance = GeneralLedger::getBalances();
        return  MyResponse::staticSuccess('Data Retrieved Successfully', compact('agents', 'latest_transactions', 'terminals', 'gl_balance'));
    }
}
