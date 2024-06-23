<?php

namespace App\Http\Controllers\WebApi\Auth;

use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return MyResponse::staticSuccess('User Already verified');
        }

        $request->user()->sendEmailVerificationNotification();

        return MyResponse::staticSuccess('Email Verification Sent', [
            'message' => 'An email verification link has been sent to your email address.'
        ]);
    }
}
