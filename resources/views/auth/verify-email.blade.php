@extends('../layout/' . 'auth')

@section('title', 'Verify Email')

@section('description')
    <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">Before we sign you in, <br /> could you verify your email?</div>
    <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-slate-400">If you didn't receive any mail, resend it and we will gladly send you another.</div>
@endsection
@section('content')
    <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">Verify Email</h2>
    <div class="intro-x mt-2 text-slate-400 text-center xl:text-left">Before we sign you in, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, please resend it and we will gladly send you another.</div>
    <div class="intro-x mt-8">
        <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
            <form id="auth-form" method="post" class="inline" action="{{ route('verification.send') }}">
                @csrf

                <button id="auth-btn" class="btn btn-primary py-3 px-4 w-full xl:w-56 xl:mr-3 align-top">Resend Verification Email</button>
            </form>

            <form action="{{ route('logout') }}" method="post" class="inline" id="logout-form">
                @csrf
                <a href="{{ route('logout') }}"
                   class="btn btn-outline-secondary py-3 px-4 w-full xl:w-32 mt-3 xl:mt-0 align-top"
                   onclick="event.preventDefault();
                            this.closest('form').submit();"
                >
                    Logout
                </a>
            </form>
        </div>
    </div>
@endsection
