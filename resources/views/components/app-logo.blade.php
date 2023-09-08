@props(['class' => ''])

@if(appLogo()->image)
    <img alt="@appName logo" class="{{ $class }} {{ config('app.logo-size') }}" src="{{ appLogo()->value }}">
@else
    <span class="logo__text text-white font-semibold text-2xl ml-3">@appName</span>
@endif