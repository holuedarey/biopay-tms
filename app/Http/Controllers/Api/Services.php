<?php

namespace App\Http\Controllers\Api;

use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;
use App\Models\Terminal;
use Illuminate\Http\Request;

class Services extends Controller
{
    public function index(Request $request)
    {
        $services = Terminal::whereSerial($request->header('deviceId'))->firstOrFail()->menus()
            ->select(['services.id', 'slug', 'name'])
            ->get()->makeHidden('pivot');

        return MyResponse::success('Services fetched', $services);
    }
}
