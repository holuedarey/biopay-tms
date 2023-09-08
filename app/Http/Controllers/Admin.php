<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Admin extends Users
{
    public function index(Request $request)
    {
        $request->user()->can('read admin');

        return view('pages.manage-users.admin');
    }
}
