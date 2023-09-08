@extends('../layout/' . 'auth')

@section('title', 'Login')

@section('description')
    <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">A platform where retailers <br/> & wholesalers trade.</div>
    <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-slate-400">Manage terminals and transactions...</div>
@endsection
@section('content')
    <div>
        <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">Sign In</h2>
        <div class="intro-x mt-2 text-slate-400 xl:hidden">A platform where retailers and wholesalers trade. Manage your account and transactions.</div>
        <div class="intro-x mt-8">
            <form id="auth-form" method="post" action="{{ route('login') }}">
                @csrf
                <input id="email" type="text" name="email" class="intro-x login__input form-control py-3 px-4 block" placeholder="Email">
                <x-input-error input-name="email" />
                <input id="password" type="password" name="password" class="intro-x login__input form-control py-3 px-4 block mt-4" placeholder="Password">

                <div class="intro-x flex text-slate-600 dark:text-slate-500 text-xs sm:text-sm mt-4">
                    <div class="flex items-center mr-auto">
                        <input id="remember-me" type="checkbox" name="remember" class="form-check-input border mr-2">
                        <label class="cursor-pointer select-none" for="remember-me">Remember me</label>
                    </div>
                    <a href="{{ route('password.request') }}">Forgot Password?</a>
                </div>
                <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                    <button id="auth-btn" class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Login</button>
                </div>
            </form>
        </div>
        <div class="intro-x mt-10 xl:mt-24 text-slate-600 dark:text-slate-500 text-center xl:text-left">
            {{--                        By signin up, you agree to our <a class="text-primary dark:text-slate-200" href="">Terms and Conditions</a> & <a class="text-primary dark:text-slate-200" href="">Privacy Policy</a>--}}
        </div>
    </div>

@endsection
