<?php

namespace App\Http\Controllers\WebApi;

use App\Helpers\General;
use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\KycLevelCreateRequest;
use App\Http\Requests\KycLevelRequest;
use App\Models\KycLevel;
use Illuminate\Http\Request;

class KycLevels extends Controller
{
    public function index(Request $request)
    {
        $request->user()->can('read kyc-level');
        return  MyResponse::staticSuccess('Data Retrieved Successfully');
    }

    public function store(KycLevelCreateRequest $request)
    {
        $request->user()->can('create kyc-level');

        $data = $request->validated();

        KycLevel::create($data);
        return  MyResponse::staticSuccess('New KYC Level awaiting approval.');
    }

    public function update(KycLevelRequest $request, KycLevel $kycLevel)
    {
        $request->user()->can('edit kyc-level');

        $kycLevel->update($request->validated());
        return  MyResponse::staticSuccess('KYC Level update awaiting approval.');
    }

}
