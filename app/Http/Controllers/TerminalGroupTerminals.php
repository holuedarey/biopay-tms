<?php

namespace App\Http\Controllers;

use App\Http\Requests\TerminalRequest;
use App\Models\TerminalGroup;
use App\Models\User;

class TerminalGroupTerminals extends Controller
{
    public function index(TerminalGroup $terminalGroup)
    {
        return view('pages.terminal-groups.terminals', compact('terminalGroup'));
    }

    public function store(TerminalRequest $request, TerminalGroup $terminalGroup)
    {
        $user = User::firstWhere('email', $request->email);

        $terminalGroup->terminals()->create([
            'user_id'   => $user->id,
            'device'    => $request->device,
            'tid'       => $request->tid,
            'mid'       => $request->mid,
            'serial'    => $request->serial,
        ]);

        return back()->with('pending', "New $user->email - Terminal ID '$request->tid' awaiting approval! ");
    }
}
