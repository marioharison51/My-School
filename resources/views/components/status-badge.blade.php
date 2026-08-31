@props(['color' => 'primary'])

@php
    $classes = match ($color) {
        'primary' => 'bg-primary-50 text-primary-700',
        'green'   => 'bg-green-50 text-green-700',
        'red'     => 'bg-red-50 text-red-700',
        'amber'   => 'bg-amber-50 text-amber-700',
        default   => 'bg-gray-50 text-gray-700',
    };
@endphp

<span {{ $attributes->merge(['class' => "text-xs font-medium px-2 py-0.5 rounded-full {$classes}"]) }}>
    {{ $slot }}
</span>
