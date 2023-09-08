<?php

namespace App\Http\Controllers\Api;

use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Terminal;
use App\Models\Transaction;
use Illuminate\Http\Request;

class   Dashboard extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return MyResponse::success('Dashboard Loaded', [
            'wallet' => auth()->user()->wallet->only(['account_number', 'balance', 'status', 'updated_at']),
            'summary' => [
                'cashout_count' => Transaction::successful()->cashout()->count(),
                'transfer_count' => Transaction::successful()->transfer()->count(),
                'bill_payments_count' => Transaction::successful()->billPayment()->count(),
                'airtime_count' => Transaction::successful()->airtime()->count(),
            ],
            'menus' => Terminal::whereSerial($request->header('deviceId'))->firstOrFail()->menus()
                ->select(['services.id', 'slug', 'menu_name', 'description'])
                ->get()->makeHidden('pivot'),
            'transactions' => TransactionResource::collection(
                auth()->user()->transactions()->latest()->limit(5)->get()
            )
        ]);
    }
}
