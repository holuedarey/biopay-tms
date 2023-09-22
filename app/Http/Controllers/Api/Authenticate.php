<?php

namespace App\Http\Controllers\Api;

use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;
use App\Models\Terminal;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class Authenticate extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'serial' => ['required', Rule::exists('terminals', 'serial')->where('status', 'ACTIVE')],
            'password' => 'required|string'
        ]);

        $terminal = Terminal::whereSerial($request->get('serial'))->first();

        if ( !auth()->attempt(['email' => $terminal->agent->email, 'password' => $request->get('password')]) ) {
            throw ValidationException::withMessages([
                'email' => "The password you entered is incorrect.",
            ]);
        }

        if ( $terminal->status != 'ACTIVE' ) {
            return MyResponse::failed("You terminal is $terminal->status", code: 403);
        }

        $user = auth()->user();

        if ( $user->status != 'ACTIVE' ) {
            return MyResponse::failed("You account is $user->status", code: 403);
        }

        if ( $user->wallet->status != 'ACTIVE' ) {
            return MyResponse::failed("You account is {$user->wallet->status}", code: 403);
        }

        return MyResponse::success('Terminal authentication successful.', [
            'id'                => $user->id,
            'tid'               => $terminal->tid,
            'mid'               => $terminal->mid,
            'tmk'               => $terminal->tmk,
            'tsk'               => $terminal->tsk,
            'tpk'               => $terminal->tpk,
            'country_code'      => $terminal->country_code,
            'currency_code'     => $terminal->currency_code,
            'serial'            => $terminal->serial,
            'first_name'        => $user->first_name,
            'name'              => $user->name,
            'phone'             => $user->phone,
            'email'             => $user->email,
            'level'             => $user->kycLevel->name,
            'avatar'            => $user->avatar,
            'terminal_status'   => $terminal->status,
            'admin_pin'         => $terminal->admin_pin,
            'address'           => $user->address ?? $terminal->name_location,
            'is_super_agent'    => $user->isSuperAgent(),
            'access_token'      => $user->generateToken($terminal),
        ]);
    }
}
