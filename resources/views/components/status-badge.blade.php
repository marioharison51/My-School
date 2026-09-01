@props(['color' => 'gray'])

@php
    $colors = [
        'green'   => 'bg-green-50 text-green-700',
        'red'     => 'bg-red-50 text-red-700',
        'amber'   => 'bg-amber-50 text-amber-700',
        'primary' => 'bg-primary-50 text-primary-700',
        'gray'    => 'bg-gray-100 text-gray-600',
    ];
    $classes = $colors[$color] ?? $colors['gray'];
@endphp

<span {{ $attributes->merge(['class' => "px-2 py-0.5 rounded-full text-xs font-medium {$classes}"]) }}>
    {{ $slot }}
</span>
