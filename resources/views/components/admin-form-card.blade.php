@props(['title', 'description' => null, 'back' => null])

<div class="rounded-lg border border-slate-200 bg-white shadow-sm">
    <div class="flex flex-col gap-3 border-b border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-base font-bold text-slate-950">{{ $title }}</h2>
            @if ($description)
                <p class="text-sm text-slate-500">{{ $description }}</p>
            @endif
        </div>
        @if ($back)
            <a href="{{ $back }}" class="inline-flex items-center justify-center gap-1.5 rounded-md border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-50">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                </svg>
                Kembali
            </a>
        @endif
    </div>

    <div class="p-5 sm:p-6">
        {{ $slot }}
    </div>
</div>
