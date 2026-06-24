@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center gap-3 rounded-md bg-amber-400 px-3 py-2 text-sm font-semibold text-slate-950 shadow-sm'
            : 'flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium text-slate-300 transition hover:bg-slate-800 hover:text-white focus:outline-none focus:ring-2 focus:ring-amber-300';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    @isset($icon)
        <span class="shrink-0">{{ $icon }}</span>
    @endisset
    <span>{{ $slot }}</span>
</a>
