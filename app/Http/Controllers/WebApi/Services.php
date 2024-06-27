<?php

namespace App\Http\Controllers\WebApi;

use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class Services extends Controller
{
    public function index(Request $request)
    {
        $request->user()->can('read settings');

        $services = Service::orderBy('name')->with('providers')->get();

        return MyResponse::success('Services fetched', $services);
    }

    public function update(Request $request, Service $service)
    {
        $request->user()->can('edit settings');

        $service->update($request->only(['name', 'description', 'is_available', 'menu_name']));

        $name = $request->filled('menu_name') ? 'Menu name' : 'Service';

        return back()->with('pending', "$name update awaiting approval.");
    }

    public function jsonData()
    {
        return response()->json(Service::all());
    }
}
