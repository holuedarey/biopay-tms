<?php

namespace App\Http\Controllers;

use App\Enums\Action;
use App\Helpers\MyResponse;
use App\Http\Requests\GlRequest;
use App\Models\Approval;
use App\Models\GeneralLedger;
use App\Models\GLT;
use Illuminate\Http\Request;

class GeneralLedgers extends Controller
{
    public function index(Request $request)
    {
        $request->user()->can('read general ledger');

        $gls = GeneralLedger::whereNot('service_id', 1)
            ->with('service')->get()->sortBy('service.name');

        return view('pages.general-ledger.index', compact('gls'));
    }

    public function indexApi(Request $request)
    {
        $request->user()->can('read general ledger');

        $gls = GeneralLedger::whereNot('service_id', 1)
            ->with('service')->get()->sortBy('service.name');
        return  MyResponse::staticSuccess('Data Retrieved Successfully',compact('gls'));
    }

    public function show(GlRequest $request)
    {
        $request->user()->can('read general ledger');

//        Select cashout gl for the index route else service if available in the request.
        $gl = GeneralLedger::whereHas('service',
            fn($q) => $q->where('slug', $request->get('service', 'cashoutwithdrawal'))
        )?->first();

        $sum = $gl->glts()->groupBy('type')->selectRaw('type, sum(amount) as sum')->pluck('sum', 'type');

        return view('pages.general-ledger.show', compact('gl', 'sum'));
    }

    public function showApi(GlRequest $request)
    {
        $request->user()->can('read general ledger');

//        Select cashout gl for the index route else service if available in the request.
        $gl = GeneralLedger::whereHas('service',
            fn($q) => $q->where('slug', $request->get('service', 'cashoutwithdrawal'))
        )?->first();

        $sum = $gl->glts()->groupBy('type')->selectRaw('type, sum(amount) as sum')->pluck('sum', 'type');


        return  MyResponse::staticSuccess('Data Retrieved Successfully', compact('gl', 'sum'));
    }

    public function update(GlRequest $request, GeneralLedger $gl)
    {
        $request->user()->can('edit general ledger');

        Approval::create([
            'approvalable_type' => GeneralLedger::class,
            'approvalable_id' => $gl->id,
            'performed_by' => auth()->id(),
            'new_data' => [
                'info' => 'General Ledger was funded by ' . auth()->user()->name,
                'amount' => (float) $request->get('amount'),
            ]
        ]);

        return back()->with('pending', 'General ledger funding awaiting approval.');
    }
    public function updateApi(GlRequest $request, GeneralLedger $gl)
    {
        $request->user()->can('edit general ledger');

        Approval::create([
            'approvalable_type' => GeneralLedger::class,
            'approvalable_id' => $gl->id,
            'performed_by' => auth()->id(),
            'new_data' => [
                'info' => 'General Ledger was funded by ' . auth()->user()->name,
                'amount' => (float) $request->get('amount'),
            ]
        ]);
        return  MyResponse::staticSuccess('Pending General ledger funding awaiting approval.');
    }
}
