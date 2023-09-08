<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class Statistics extends Controller
{
    public function __invoke(Request $request, ?User $user = null)
    {
        return view('pages.statistics', compact('user'));
    }
}
