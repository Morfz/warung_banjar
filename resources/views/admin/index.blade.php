<x-admin-layout>
    <x-slot name="header">Dasbor</x-slot>

    <div class="space-y-6">
        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="flex items-center gap-4 rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <span class="flex h-11 w-11 items-center justify-center rounded-lg bg-amber-100 text-amber-600">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                </span>
                <div>
                    <p class="text-sm font-medium text-slate-500">Menu</p>
                    <p class="text-2xl font-bold text-slate-950">{{ $stats['menus'] }}</p>
                </div>
            </div>

            <div class="flex items-center gap-4 rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <span class="flex h-11 w-11 items-center justify-center rounded-lg bg-sky-100 text-sky-600">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6a2.25 2.25 0 0 0 2.227 1.932H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 6 3.75h3.879a1.5 1.5 0 0 1 1.06.44l2.122 2.12a1.5 1.5 0 0 0 1.06.44H18A2.25 2.25 0 0 1 20.25 9v.776"/></svg>
                </span>
                <div>
                    <p class="text-sm font-medium text-slate-500">Kategori</p>
                    <p class="text-2xl font-bold text-slate-950">{{ $stats['categories'] }}</p>
                </div>
            </div>

            <div class="flex items-center gap-4 rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <span class="flex h-11 w-11 items-center justify-center rounded-lg bg-violet-100 text-violet-600">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15"/></svg>
                </span>
                <div>
                    <p class="text-sm font-medium text-slate-500">Meja</p>
                    <p class="text-2xl font-bold text-slate-950">{{ $stats['tables'] }}</p>
                </div>
            </div>

            <div class="flex items-center gap-4 rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <span class="flex h-11 w-11 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg>
                </span>
                <div>
                    <p class="text-sm font-medium text-slate-500">Reservasi</p>
                    <p class="text-2xl font-bold text-slate-950">{{ $stats['reservations'] }}</p>
                </div>
            </div>
        </section>

        @if ($pendingCount > 0)
            <div class="flex items-center gap-3 rounded-md border border-amber-200 bg-amber-50 px-4 py-3 text-sm font-medium text-amber-800">
                <svg class="h-5 w-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></svg>
                Ada <strong class="font-bold">{{ $pendingCount }}</strong> reservasi menunggu konfirmasi.
                <a href="{{ route('admin.reservations.index') }}" class="ml-auto font-semibold underline underline-offset-2 hover:text-amber-900">Tinjau</a>
            </div>
        @endif

        <section class="grid gap-6 xl:grid-cols-[1.15fr_0.85fr]">
            <div class="rounded-lg border border-slate-200 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                    <div>
                        <h2 class="text-base font-bold text-slate-950">Reservasi Terbaru</h2>
                        <p class="text-sm text-slate-500">Urutan berdasarkan tanggal reservasi.</p>
                    </div>
                    <a href="{{ route('admin.reservations.index') }}" class="rounded-md bg-slate-950 px-3 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">Lihat Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            <tr>
                                <th class="px-5 py-3">Nama</th>
                                <th class="px-5 py-3">Tanggal</th>
                                <th class="px-5 py-3">Tamu</th>
                                <th class="px-5 py-3">Meja</th>
                                <th class="px-5 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($latestReservations as $reservation)
                                <tr>
                                    <td class="px-5 py-4 font-semibold text-slate-900">{{ $reservation->name }}</td>
                                    <td class="px-5 py-4 text-slate-600">{{ $reservation->date->format('d M Y H:i') }}</td>
                                    <td class="px-5 py-4 text-slate-600">{{ $reservation->guests }}</td>
                                    <td class="px-5 py-4 text-slate-600">{{ $reservation->table?->name ?? '-' }}</td>
                                    <td class="px-5 py-4">
                                        <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $reservation->status->badgeClasses() }}">
                                            {{ $reservation->status->label() }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-8 text-center text-slate-500">Belum ada reservasi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <h2 class="text-base font-bold text-slate-950">Aksi Cepat</h2>
                <div class="mt-4 grid gap-3">
                    <a href="{{ route('admin.menus.create') }}" class="flex items-center gap-3 rounded-md border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-800 transition hover:border-amber-300 hover:bg-amber-50">
                        <svg class="h-5 w-5 text-amber-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        Tambah Menu
                    </a>
                    <a href="{{ route('admin.tables.create') }}" class="flex items-center gap-3 rounded-md border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-800 transition hover:border-amber-300 hover:bg-amber-50">
                        <svg class="h-5 w-5 text-amber-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        Tambah Meja
                    </a>
                    <a href="{{ route('admin.reservations.create') }}" class="flex items-center gap-3 rounded-md border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-800 transition hover:border-amber-300 hover:bg-amber-50">
                        <svg class="h-5 w-5 text-amber-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        Tambah Reservasi
                    </a>
                    <a href="{{ route('admin.categories.create') }}" class="flex items-center gap-3 rounded-md border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-800 transition hover:border-amber-300 hover:bg-amber-50">
                        <svg class="h-5 w-5 text-amber-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        Tambah Kategori
                    </a>
                </div>
            </div>
        </section>
    </div>
</x-admin-layout>
