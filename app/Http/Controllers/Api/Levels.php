<?php

namespace App\Http\Controllers\Api;

use App\Enums\Documents;
use App\Enums\Status;
use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateLevelRequest;
use App\Models\KycLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Levels extends Controller
{
    public function index()
    {
        $levels = KycLevel::withExists([
            'users as is_current' => fn($query) => $query->whereId(auth()->id())
        ])->get();

        $user = Auth::user();

        $levels->map(function (KycLevel $level) use ($user) {
            $level->completed = true;

            if ($level->id == 2 && is_null($user->bvn))  $level->completed = false;

            if ($level->id == 3 && $user->kycDocs()->forLevel3()->doesntExist()) $level->completed = false;

            if ($level->id == 4 && $user->kycDocs()->forLevel4()->doesntExist()) $level->completed = false;
        });

        return MyResponse::success('Levels loaded', $levels);
    }

    public function store(UpdateLevelRequest $request)
    {
        return MyResponse::success('Level update successful');
    }
}
