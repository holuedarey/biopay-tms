<?php

namespace App\Http\Controllers\WebApi\Auth;

use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink($request->only('email'));

        // Check the status of the password reset link sending attempt
        if ($status === Password::RESET_LINK_SENT) {
            // Password reset link sent successfully
            $data = [
                'message' => __('A password reset link has been sent to your email address.'),
            ];

            return MyResponse::staticSuccess('Password Reset Link Sent', $data);
        } else {
            // Password reset link sending failed
            return MyResponse::failed('Error', ['email' => __($status)]);
        }
    }
}
