<?php

namespace App\Http\Controllers\Api;

use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;
use App\Models\Dispute;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DisputeController extends Controller
{


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Dispute $dispute)
    {
        $data = $request->validate([
            'user_id' => 'required|numeric',
            'serial' => ['required', Rule::exists('terminals', 'serial')->where('status', 'ACTIVE')],
            'reference' => 'required|string',
            'info' => 'required|string'
        ]);

        $dispute->create(collect($data)->toArray());

        return MyResponse::success('Your Dispute has been submitted!' );
    }

}
