<?php

namespace App\Http\Controllers\WebApi;

use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\KycDocRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserKycDocs extends Controller
{
    public function index(User $user)
    {
        $user->load('kycDocs');

        $kyc_docs = $user->kycDocs;
        return  MyResponse::staticSuccess('Data Retrieved Successfully', compact('user', 'kyc_docs'));
    }

    public function store(KycDocRequest $request, User $user)
    {
        $user->kycDocs()->create($request->fulfilled());
        return  MyResponse::staticSuccess('New KYC document upload awaiting approval.', compact('user'));
    }
}
