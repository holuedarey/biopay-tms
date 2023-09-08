<?php

namespace App\Http\Controllers;

use App\Models\Processor;
use Illuminate\Http\Request;

class Processors extends Controller
{
    public function index()
    {
        $processors = Processor::all();

        return view('pages.processors.index', compact('processors'));
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
