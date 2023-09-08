@extends('../layout/base')

@section('body')
    <body class="login">
        <!-- BEGIN: Session msg -->
        <x-session-msg />
        <!-- BEGIN: Session msg -->

        {{--@include('../layout/components/dark-mode-switcher')
        @include('../layout/components/main-color-switcher')--}}

        <div class="container sm:px-10">
            <div class="block xl:grid grid-cols-2 gap-4">
                <!-- BEGIN: Login Info -->
                <div class="hidden xl:flex flex-col min-h-screen">
                    <a href="{{ route('login') }}" class="-intro-x flex items-center pt-5">
                        <x-app-logo />
                    </a>
                    <div class="my-auto">
                        <img alt="illustration" class="-intro-x w-1/2 -mt-16" src="{{ asset('build/assets/images/illustration.svg') }}">
                        @yield('description')
                    </div>
                </div>
                <!-- END: Login Info -->
                <!-- BEGIN: Login Form -->
                <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
                    <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                        @yield('content')
                    </div>
                </div>
                <!-- END: Login Form -->
            </div>
        </div>

        <!-- BEGIN: JS Assets-->
        @vite('resources/js/app.js')
        <!-- END: JS Assets-->

        @yield('script')
{{--        for auth views--}}
        <script type="module">
            (function () {

                let authForm = $('#auth-form');
                let authBtn = $('#auth-btn');

                async function login() {
                    // Loading state
                    authBtn.html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>')
                    tailwind.svgLoader()
                    await helper.delay(1500)
                }

                authBtn.on('click', function() {
                    login()
                })
            })()
        </script>
    </body>
@endsection
