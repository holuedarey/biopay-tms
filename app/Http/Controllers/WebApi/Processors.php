<?php

namespace App\Http\Controllers\WebApi;

use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;
use App\Models\Processor;
use Illuminate\Http\Request;

class Processors extends Controller
{
    public function index()
    {
        $processors = Processor::all();

        return MyResponse::success('Data fetched successfully', $processors);
    }

    public function update(Request $request, Processor $processor)
    {
        $data = $request->validate([
            'name' => 'string',
            'host' => 'string',
            'port' => 'digits_between:4,6',
            'ssl'  => 'bool',
            'requiresKey'  => 'bool',
            'comp1' => 'string',
            'comp2' => 'string',
            'zpk' => 'nullable|string',
        ]);

        $processor->update($data);

        return back()->with('pending', 'Awaiting approval for processor update');
    }
}
