<?php

namespace App\Http\Controllers;

use App\Helpers\MyResponse;
use App\Http\Requests\UpdateLevelRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ManageUserLevel extends Controller
{

    public function index(User $user){

        $user->load(['kycDocs', 'kycLevel']);

        return view('pages.agents.kyc-docs.create', compact('user'));
    }

    public function store(UpdateLevelRequest $request, User $user)
    {
        return back()->with('success', 'Level update successful');
    }

    public function indexApi(User $user){

        $user->load(['kycDocs', 'kycLevel']);
        return  MyResponse::staticSuccess('Data Retrieved Successfully', compact('user'));

    }

    public function storeApi(UpdateLevelRequest $request, User $user)
    {
        return  MyResponse::staticSuccess("Level update successful");
    }
}
