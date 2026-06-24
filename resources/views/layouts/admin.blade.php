<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Warung Banjar') }} Admin</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-100 font-sans text-slate-900 antialiased">
        <div x-data="{ sidebarOpen: false }" class="min-h-screen lg:flex">
            <aside class="fixed inset-y-0 left-0 z-40 w-72 -translate-x-full bg-slate-950 text-white shadow-2xl transition lg:static lg:translate-x-0" :class="{ 'translate-x-0': sidebarOpen }">
                <div class="flex h-full flex-col">
                    <div class="border-b border-white/10 px-6 py-6">
                        <a href="{{ route('admin.index') }}" class="block text-xl font-bold tracking-wide">Warung Banjar</a>
                        <p class="mt-1 text-xs font-medium uppercase tracking-[0.24em] text-amber-300">Admin Console</p>
                    </div>

                    <nav class="flex-1 space-y-1 px-4 py-6">
                        <x-admin-nav-link :href="route('admin.index')" :active="request()->routeIs('admin.index')">
                            <x-slot name="icon">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z"/></svg>
                            </x-slot>
                            Dasbor
                        </x-admin-nav-link>
                        <x-admin-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                            <x-slot name="icon">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6a2.25 2.25 0 0 0 2.227 1.932H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 6 3.75h3.879a1.5 1.5 0 0 1 1.06.44l2.122 2.12a1.5 1.5 0 0 0 1.06.44H18A2.25 2.25 0 0 1 20.25 9v.776"/></svg>
                            </x-slot>
                            Kategori
                        </x-admin-nav-link>
                        <x-admin-nav-link :href="route('admin.menus.index')" :active="request()->routeIs('admin.menus.*')">
                            <x-slot name="icon">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                            </x-slot>
                            Menu
                        </x-admin-nav-link>
                        <x-admin-nav-link :href="route('admin.tables.index')" :active="request()->routeIs('admin.tables.*')">
                            <x-slot name="icon">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15"/></svg>
                            </x-slot>
                            Meja
                        </x-admin-nav-link>
                        <x-admin-nav-link :href="route('admin.reservations.index')" :active="request()->routeIs('admin.reservations.*')">
                            <x-slot name="icon">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg>
                            </x-slot>
                            Reservasi
                        </x-admin-nav-link>
                        <x-admin-nav-link :href="route('receptionist.index')" :active="request()->routeIs('receptionist.*')">
                            <x-slot name="icon">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </x-slot>
                            Resepsionis (Tamu)
                        </x-admin-nav-link>
                    </nav>

                    <div class="border-t border-white/10 p-4">
                        <a href="{{ route('welcome') }}" class="mb-3 block rounded-md border border-white/10 px-3 py-2 text-sm font-medium text-slate-200 transition hover:border-amber-300 hover:text-white">Lihat Situs</a>
                        <div class="rounded-md bg-white/5 p-3">
                            <p class="text-sm font-semibold">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-400">{{ Auth::user()->email }}</p>
                            <div class="mt-3 flex gap-2">
                                <a href="{{ route('profile.edit') }}" class="rounded-md bg-slate-800 px-3 py-2 text-xs font-semibold text-slate-100 transition hover:bg-slate-700">Profil</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="rounded-md bg-rose-500 px-3 py-2 text-xs font-semibold text-white transition hover:bg-rose-600">Keluar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

            <div class="fixed inset-0 z-30 bg-slate-950/50 lg:hidden" x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false"></div>

            <div class="min-w-0 flex-1">
                <header class="sticky top-0 z-20 border-b border-slate-200 bg-white/90 backdrop-blur">
                    <div class="flex min-h-16 items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center gap-3">
                            <button type="button" class="rounded-md border border-slate-200 p-2 text-slate-700 lg:hidden" @click="sidebarOpen = true">
                                <span class="sr-only">Buka menu</span>
                                <span class="block h-0.5 w-5 bg-current"></span>
                                <span class="mt-1 block h-0.5 w-5 bg-current"></span>
                                <span class="mt-1 block h-0.5 w-5 bg-current"></span>
                            </button>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Operasional</p>
                                <h1 class="text-lg font-bold text-slate-950">{{ $header ?? 'Dasbor' }}</h1>
                            </div>
                        </div>
                        <p class="hidden text-sm text-slate-500 sm:block">{{ now()->format('d M Y, H:i') }}</p>
                    </div>
                </header>

                <main class="px-4 py-6 sm:px-6 lg:px-8">
                    @if (session()->has('danger') || session()->has('success') || session()->has('warning'))
                        <div class="mb-5 rounded-md border px-4 py-3 text-sm font-medium
                            {{ session()->has('success') ? 'border-emerald-200 bg-emerald-50 text-emerald-800' : '' }}
                            {{ session()->has('warning') ? 'border-amber-200 bg-amber-50 text-amber-800' : '' }}
                            {{ session()->has('danger') ? 'border-rose-200 bg-rose-50 text-rose-800' : '' }}">
                            {{ session()->get('success') ?? session()->get('warning') ?? session()->get('danger') }}
                        </div>
                    @endif

                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
