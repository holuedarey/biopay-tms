<?php

namespace App\Http\Controllers;

use App\Models\Dispute;
use Illuminate\Http\Request;

class DisputeController extends Controller
{

    public function index()
    {
        $disputes = Dispute::latest()->get();

        return view('pages.dispute.index', compact('disputes'));
    }
}
