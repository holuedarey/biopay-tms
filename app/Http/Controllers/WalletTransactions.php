<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WalletTransactions extends Controller
{
    public function index(Request $request)
    {
        $request->user()->can('read wallets');

        return view('pages.wallets.transactions');
    }
}
