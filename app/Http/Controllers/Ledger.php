<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Ledger extends Controller
{
    public function index(Request $request)
    {
        $request->user()->can('read ledger');

        return view('pages.ledger.index');
    }
}
