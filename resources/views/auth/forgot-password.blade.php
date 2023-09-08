@extends('../layout/' . 'auth')

@section('title', 'Forgot Password')

@section('description')
    <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">Forgot your password? <br /> That's okay, it happens.</div>
    <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-slate-400">Enter your email to reset your password.</div>
@endsection

@section('content')
    <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">Forgot Password?</h2>
    <div class="intro-x mt-2 text-slate-400 xl:hidden text-center">That's okay, it happens. Enter your email to reset your password.</div>
    <div class="intro-x mt-8">
        <form id="auth-form" method="post" action="{{ route('password.email') }}">
            @csrf
            <input id="email" type="text" name="email" class="intro-x login__input form-control py-3 px-4 block" placeholder="Email">
            <x-input-error input-name="email" />

            <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                <button id="auth-btn" class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Submit</button>
            </div>
        </form>
    </div>
@endsection
