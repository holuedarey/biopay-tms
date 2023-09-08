@props(['user'])
<img alt="{{ $user->name }} avatar" src="{{ $user->avatar }}" {{ $attributes->merge(['class' => ""]) }}>
