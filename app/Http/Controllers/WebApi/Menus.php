<?php

namespace App\Http\Controllers\WebApi;

use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class Menus extends Controller
{
    public function index()
    {
        $menus = Service::withCount('terminals')->whereMenu(true)->get();
        return  MyResponse::staticSuccess('Data Fetched Successfully',  compact('menus'));

    }
}
