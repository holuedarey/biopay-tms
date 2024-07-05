<?php

namespace App\Http\Controllers\WebApi;

use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class Permissions extends Controller
{
    public function index()
    {
        \Auth::user()->can('read admin');

        $permissions = Permission::all();
        return MyResponse::staticSuccess("Data fetched successfully!",compact('permissions'));

    }
}
