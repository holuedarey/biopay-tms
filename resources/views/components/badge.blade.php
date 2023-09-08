@props(['value', 'color' => null])

@php($color = is_null($color) ? 'bg-info text-white' : "bg-$color-100 text-$color-600")

<span {{ $attributes->merge(['class' => "$color text-xs font-semibold mr-2 px-2.5 py-0.5 rounded"]) }}>
    {{ isset($value) ? strtoupper($value) : $slot }}
</span>
