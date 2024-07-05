<?php

namespace App\Http\Controllers\WebApi;

use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;
use App\Models\Terminal;
use Illuminate\Http\Request;

class TerminalMenus extends Controller
{
    public function store(Request $request, Terminal $terminal)
    {
        $request->validate(['menus.*' => 'required|exists:services,id']);

        $terminal->menus()->sync($request->menus);
        return MyResponse::staticSuccess("Menus for terminal - $terminal->tid updated!");

    }


}
