<?php

namespace App\Http\Controllers\Api;

use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Services\Transfer;

class Banks extends Controller
{
    public function index()
    {
        $provider = Transfer::provider();

        $banks = Bank::whereProvider($provider::name())->orderBy('name')->get();

        return MyResponse::success(data: $banks);
    }
}
