<?php

namespace App\Http\Controllers;

use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;
use App\Repository\Teqrypt;

class DarkModeController extends Controller
{
    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function switch()
    {
        session([
            'dark_mode' => session()->has('dark_mode') ? !session()->get('dark_mode') : true
        ]);

        return back();
    }

    public function testEncrypt()
    {
        $teqrypt = new Teqrypt;

        $request = [
            'serial' => '125382820hs12',
            'device' => 'android',
            'first_name' => 'samuel',
            'other_names' => 'oludare',
                'email' => 'holudare2076@gmail.com',
            'phone' => '08102020680',
            'gender' => 'MALE',
            'dob' => '1990-02-05 20:51:09',
            'state' => 'Lagos',
            'address' => '17 oyedele street',
            'password' => 'samuel@1234567',
            'password_confirmation' => 'samuel@1234567',
            'role' => 'AGENT'
        ];
        $login = [
            'serial' => '125382820hs12',
            'password' => 'samuel@1234567'
        ];


        $forgetPass = [
            'email' => 'holudare2076@gmail.com'
        ];

        return MyResponse::success('response retrieved', $forgetPass);
    }
}
