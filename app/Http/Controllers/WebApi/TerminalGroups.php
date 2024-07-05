<?php

namespace App\Http\Controllers\WebApi;


use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\Terminal;
use App\Models\TerminalGroup;
use Illuminate\Http\Request;
use function back;
use function to_route;
use function view;

class TerminalGroups extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(TerminalGroup::class);
    }

//    public function index()
//    {
//        return view('pages.terminal-groups.index');
//    }
    public function index(TerminalGroup $terminalGroup)
    {
        return  MyResponse::staticSuccess('Data Retrieved Successfully',compact('terminalGroup'));
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
