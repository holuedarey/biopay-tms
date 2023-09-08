<?php

namespace App\Http\Controllers;

use App\Http\Requests\KycDocRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserKycDocs extends Controller
{
    public function index(User $user)
    {
        $user->load('kycDocs');

        $kyc_docs = $user->kycDocs;
        return view('pages.agents.kyc-docs.index', compact('user', 'kyc_docs'));
    }

    public function store(KycDocRequest $request, User $user)
    {
        $user->kycDocs()->create($request->fulfilled());

        return back()->with('pending', 'New KYC document upload awaiting approval.');
    }
}
