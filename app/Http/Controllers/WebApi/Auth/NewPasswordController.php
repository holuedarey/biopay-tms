<?php

namespace App\Http\Controllers\WebApi\Auth;

use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     *
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function create(Request $request)
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise, we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => $request->password,
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // Handle the response based on the password reset status
        if ($status === Password::PASSWORD_RESET) {
            // Password reset successful
            $message = 'Your password has been reset successfully.';

            // Check if user is an agent
            $user = User::where('email', $request->email)->first();
            if ($user && $user->isAgent()) {
                return MyResponse::staticSuccess('Password Reset Success', [
                    'message' => 'You may now proceed to login on your terminal with your new password.'
                ]);
            }

            // Default redirect for non-agents
            return MyResponse::staticSuccess('Password Reset Success', [
                'message' => $message
            ]);
        } else {
            // Password reset failed
            return MyResponse::failed('Password Reset Failed', [
                'email' => __($status)
            ]);
        }
    }

    public function show($success)
    {
        if (session()->has('alert')) return view('auth.success-reset-password');

        throw new RouteNotFoundException;
    }
}
