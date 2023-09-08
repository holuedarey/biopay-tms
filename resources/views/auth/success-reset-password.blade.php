@extends('../layout/' . 'auth')

@section('title', 'Password Reset')

@section('description')
    <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">New Password</div>
@endsection

@section('content')
    <div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="check-circle" data-lucide="check-circle" class="lucide lucide-check-circle w-16 h-16 text-success mx-auto mt-3"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg></div>
    <h2 class="intro-x font-bold xl:text-4xl text-center text-success xl:text-left">Password Reset Successful!</h2>
    <p class="intro-x mt-3 text-slate-400 text-lg text-center">You may now proceed to sign in on your terminal with your new password.</p>
@endsection
