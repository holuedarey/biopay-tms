<?php

namespace App\Http\Controllers;

use App\Helpers\General;
use App\Http\Requests\KycLevelRequest;
use App\Models\KycLevel;
use Illuminate\Http\Request;

class KycLevels extends Controller
{
    public function index(Request $request)
    {
        $request->user()->can('read kyc-level');

        return view('pages.kyc-level.index');
    }

    public function store(KycLevelRequest $request)
    {
        $request->user()->can('create kyc-level');

        $data = $request->validated();

        KycLevel::create($data);

        return to_route('kyc-levels.index')->with('pending', 'New KYC Level awaiting approval.');
    }

    public function update(KycLevelRequest $request, KycLevel $kycLevel)
    {
        $request->user()->can('edit kyc-level');

        $kycLevel->update($request->validated());

        return to_route('kyc-levels.index')->with('pending', 'KYC Level update awaiting approval.');
    }

}
