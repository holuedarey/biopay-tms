<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class Menus extends Controller
{
    public function index()
    {
        $menus = Service::withCount('terminals')->whereMenu(true)->get();

        return view('pages.menus.index', compact('menus'));
    }
}
