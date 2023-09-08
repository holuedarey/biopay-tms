<?php

namespace App\Http\Controllers;

use App\Models\Processor;
use App\Models\RoutingType;
use Illuminate\Http\Request;


class Routing extends Controller
{
    public function index(Request $request)
    {
        $request->user()->can('read settings');

        $types = RoutingType::all();

        return view('pages.routing.index', compact('types'));
    }

    public function settings(Request $request, int $id)
    {
        $request->user()->can('edit settings');

        $processors = Processor::all();
        $routingType = RoutingType::find($id);
        $type = $routingType->name;


        return view("pages.routing.settings", compact('type', 'processors'));
    }

    public function addSetting(Request $request)
    {
        $request->user()->can('create settings');

        $data = request()->all();
//        dd(request()->all());


        return back()->with('pending', "Awaiting approval for new {$data['type']} setting");
    }
}
