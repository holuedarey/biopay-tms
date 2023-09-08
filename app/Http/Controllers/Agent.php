<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class Agent extends Users
{
    public function index(Request $request)
    {
        $request->user()->can('read customers');

        return view('pages.agents.index');
    }
}
