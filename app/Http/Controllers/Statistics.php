<?php

namespace App\Http\Controllers;

use App\Helpers\MyResponse;
use App\Models\User;
use Illuminate\Http\Request;

class Statistics extends Controller
{
    public function __invoke(Request $request, ?User $user = null)
    {
        return view('pages.statistics', compact('user'));
    }

    public function statisticsApi(Request $request, ?User $user = null): \Illuminate\Http\JsonResponse
    {
        return  MyResponse::staticSuccess('Data Retrieved Successfully', compact('user', ));
    }
}
