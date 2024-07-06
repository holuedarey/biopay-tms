<?php

namespace App\Http\Controllers\WebApi\Auth;

use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\LoginWithSerialRequest;
use App\Models\Terminal;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $user = auth()->user();
        activity()->enableLogging();

        activity()->performedOn($user)
            ->causedBy($user)
            ->withProperties([
                'attributes' => $user->only(['name', 'email'])])
            ->inLog('User')
            ->createdAt(now())
            ->log('login');

        // For first time login
        if (is_null(Auth::user()->password_change_at)) {
            $token = Password::createToken(Auth::user());
            $email = Auth::user()->email;

            Auth::logout();

            return to_route('password.reset', [$token, 'email' => $email])->with('alert', 'auth.first-login');
        }

        $request->session()->regenerate();

        session()->flash('message', 'Logged In! Welcome back.');

        return redirect()->intended(RouteServiceProvider::HOME);
    }


    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiLogin(LoginRequest $request)
    {
        $request->authenticateApi();

        $user = auth()->user();
        activity()->enableLogging();

        activity()->performedOn($user)
            ->causedBy($user)
            ->withProperties([
                'attributes' => $user->only(['name', 'email'])])
            ->inLog('User')
            ->createdAt(now())
            ->log('login');

        $data = array_merge(collect($user)->toArray(),  auth()->user()->token());
        return MyResponse::staticSuccess('Success', $data);
    }

    public function apiLoginWithterminalSerial(LoginWithSerialRequest $request)
    {
        $terminal = Terminal::where('serial', $request->serial)->first();

        if (!$terminal) {
            return response()->json(['error' => 'Terminal not found'], 404);
        }

        $userId = $terminal->user_id;

        // Retrieve the user based on user_id
        $user = User::find($userId);

        if (!$user) {
            return MyResponse::failed('User not found');
        }

        // Authenticate the user and generate token
        $token = $user->createToken('TerminalLoginToken')->plainTextToken;

        // Log the login activity
        activity()
            ->performedOn($user)
            ->causedBy($user)
            ->withProperties(['attributes' => $user->only(['name', 'email'])])
            ->log('login');

        // Return success response with user data and token
        $data = array_merge($user->toArray(), ["access_type"=>"Bearer", 'access_token' => $token]);
        return MyResponse::staticSuccess('Success', $data);
    }


    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();

        activity()->enableLogging();

        activity()->performedOn($user)
            ->causedBy($user)
            ->withProperties([
                'attributes' => $user->only(['name', 'email'])
            ])
            ->inLog('User')
            ->createdAt(now())
            ->log('Logged Out');

        $user->tokens()->delete();


        return MyResponse::success('Successfully logged out');
    }
}
