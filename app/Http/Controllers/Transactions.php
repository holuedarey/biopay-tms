<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Transactions extends Controller
{
    public function index(Request $request)
    {
        $request->user()->can('read transactions');

        return view('pages.transactions.index');
    }
}
