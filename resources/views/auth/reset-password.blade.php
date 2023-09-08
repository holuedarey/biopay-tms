@extends('../layout/' . 'auth')

@section('title', 'Password Reset')

@section('description')
    <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">Enter your new password</div>
    <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-slate-400"></div>
@endsection

@section('content')
    <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">Password Reset</h2>
    <div class="intro-x mt-2 text-slate-400">Enter your new password.</div>
    @if(session('alert') == 'auth.first-login')
        <div class="alert alert-secondary show my-2" role="alert">
            <div class="flex items-center">
                <div class="font-medium text-lg text-info">This is your first login attempt...</div>
                <div class="text-xs bg-info/20 px-1 rounded-md text-info ml-auto">Note</div>
            </div>
            <p class="mt-3">{{ __('auth.first-login') }}</p>
        </div>
    @endif
    <div class="intro-x mt-8">
        <form id="auth-form" method="post" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <input id="email" type="text" name="email" class="intro-x login__input form-control py-3 px-4 block" placeholder="Email" value="{{ request('email') }}" @readonly(request('email')) required>
            <x-input-error :input-name="$error = 'email'" />
            <input id="password" type="password" name="password" class="intro-x login__input form-control py-3 px-4 block mt-4" placeholder="Password" required>
            <x-input-error :input-name="$error = 'password'" />

            <input id="password_confirmation" type="password" name="password_confirmation" class="intro-x login__input form-control py-3 px-4 block mt-4" placeholder="Confirm Password" required>

            <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                <button id="auth-btn" class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Reset</button>
            </div>
        </form>
    </div>
@endsection
