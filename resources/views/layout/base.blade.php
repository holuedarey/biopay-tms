<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ $dark_mode ? 'dark' : '' }}{{ $color_scheme != 'default' ? ' ' . $color_scheme : '' }}">
<!-- BEGIN: Head -->
<head>
    <meta charset="utf-8">
    <link href="{{ appLogo2()->value }}" rel="shortcut icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Terminal Management System.">
    <meta name="author" content="Teqpace Services">
    <title>@appName :: @yield('title', 'Dashboard')</title>
    @yield('head')

    <!-- BEGIN: CSS Assets-->
    @vite('resources/css/app.css')
    <!-- END: CSS Assets-->
    @livewireStyles

    <script defer src="{{ asset('assets/js/alpinejs@3.10.4.min.js') }}"></script>
</head>
<!-- END: Head -->

@yield('body')

</html>
