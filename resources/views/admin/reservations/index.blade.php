<x-admin-layout>
    <x-slot name="header">Reservasi</x-slot>

    <div class="rounded-lg border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col gap-3 border-b border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-950">Daftar Reservasi</h2>
                <p class="text-sm text-slate-500">{{ $reservations->total() }} reservasi tercatat.</p>
            </div>
            <a href="{{ route('admin.reservations.create') }}" class="inline-flex items-center justify-center gap-1.5 rounded-md bg-slate-950 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Tambah Reservasi
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-5 py-3">Tamu</th>
                        <th class="px-5 py-3">Kontak</th>
                        <th class="px-5 py-3">Jadwal</th>
                        <th class="px-5 py-3">Meja</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($reservations as $reservation)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-4">
                                <p class="font-semibold text-slate-950">{{ $reservation->name }}</p>
                                <p class="text-sm text-slate-500">{{ $reservation->guests }} tamu</p>
                            </td>
                            <td class="px-5 py-4 text-slate-600">
                                <p>{{ $reservation->email }}</p>
                                <p class="text-slate-500">{{ $reservation->phone }}</p>
                            </td>
                            <td class="px-5 py-4 font-medium text-slate-700">{{ $reservation->date->format('d M Y H:i') }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $reservation->table?->name ?? '-' }}</td>
                            <td class="px-5 py-4">
                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $reservation->status->badgeClasses() }}">
                                    {{ $reservation->status->label() }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-2" x-data="{ open: false }">
                                    <div class="relative">
                                        <button type="button" @click="open = !open" class="inline-flex items-center gap-1 rounded-md bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-200">
                                            Status
                                            <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
                                        </button>
                                        <div x-show="open" @click.outside="open = false" x-transition
                                            class="absolute right-0 z-10 mt-1 w-48 overflow-hidden rounded-md border border-slate-200 bg-white py-1 shadow-lg">
                                            @foreach (\App\Enums\ReservationStatus::cases() as $status)
                                                <form method="POST" action="{{ route('admin.reservations.status', $reservation->id) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="{{ $status->value }}">
                                                    <button type="submit" class="block w-full px-4 py-2 text-left text-xs font-medium text-slate-700 transition hover:bg-amber-50 {{ $reservation->status === $status ? 'text-slate-400' : '' }}">
                                                        {{ $status->label() }}@if($reservation->status === $status) ✓@endif
                                                    </button>
                                                </form>
                                            @endforeach
                                        </div>
                                    </div>
                                    <a href="{{ route('admin.reservations.edit', $reservation->id) }}" class="rounded-md bg-amber-100 px-3 py-2 text-xs font-semibold text-amber-800 transition hover:bg-amber-200">Edit</a>
                                    <form method="POST" action="{{ route('admin.reservations.destroy', $reservation->id) }}" onsubmit="return confirm('Hapus reservasi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-md bg-rose-100 px-3 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-200">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-slate-500">Belum ada reservasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <x-admin-pagination :paginator="$reservations" />
    </div>
</x-admin-layout>
