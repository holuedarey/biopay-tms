<?php

namespace App\Http\Controllers\Api;

use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\BvnRequest;

class AddBvn extends Controller
{
    public function __invoke(BvnRequest $request)
    {
        return MyResponse::success('Bvn submitted! Awaiting verification...');
    }
}
