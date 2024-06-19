<?php

namespace App\Http\Controllers;


use App\Helpers\MyResponse;
use App\Models\Fee;
use App\Models\Terminal;
use App\Models\TerminalGroup;
use Illuminate\Http\Request;
use function back;
use function to_route;
use function view;

class TerminalGroupsApi extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(TerminalGroup::class);
    }

    public function index()
    {
        return view('pages.terminal-groups.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:terminal_groups']
        ]);

        TerminalGroup::create(['name'  => $request->name, 'info' => $request->info]);
        return  MyResponse::staticSuccess("Awaiting approval for new Terminal Group '$request->name'!");
    }

    public function jsonData()
    {
        return response()->json(TerminalGroup::all());
    }
}
