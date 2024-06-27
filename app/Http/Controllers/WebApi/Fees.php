<?php

namespace App\Http\Controllers\WebApi;


use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\TerminalGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function back;
use function to_route;
use function view;

class Fees extends Controller
{
    public function index(TerminalGroup $terminalGroup)
    {
        return  MyResponse::staticSuccess('Data Retrieved Successfully',  compact('terminalGroup'));

    }

    public function edit(Fee $fee)
    {
        $this->authorize('update', $fee);

        $group = $fee->group;

        return view('pages.fees.edit', compact('group', 'fee'));
    }


    public function update(Request $request, Fee $fee)
    {
        $this->authorize('update', $fee);

        $data = $request->only(['amount', 'amount_type', 'cap', 'info', 'config', 'newConfig']);

        if ( $request->has('config') ) {
            $configs = collect($data['config']);
        }
        else {
            $configs = collect([]);
            $data['config'] = $configs;
        }

        if ($request->has('newConfig') && sizeof($request->newConfig) > 0 ) {
            $ncArray = array_chunk(\request('newConfig'), 2);
            foreach ($ncArray as $item) {
                $configs->put($item[0], $item[1]);
            }

            unset($data['newConfig']);
            $data['config'] = $configs;
        }

        $fee->update($data);

        return  MyResponse::staticSuccess('Awaiting approval for Fee update!');

    }
}
