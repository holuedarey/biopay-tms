<?php

namespace App\Http\Controllers;

use App\Helpers\MyResponse;
use App\Http\Requests\UpdateLevelRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ManageUserLevelApi extends Controller
{

    public function index(User $user){

        $user->load(['kycDocs', 'kycLevel']);

        return  MyResponse::staticSuccess('Data Retrieved Successfully', compact('user', 'user'));
    }

    public function store(UpdateLevelRequest $request, User $user)
    {
        return  MyResponse::staticSuccess('Level update successful');
    }
}
