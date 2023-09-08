<?php

namespace App\Http\Controllers;

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
}
