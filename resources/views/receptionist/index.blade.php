<x-admin-layout>
    <x-slot name="header">Resepsionis & Penerimaan Tamu</x-slot>

    <div class="space-y-6">
        <!-- Dashboard Summary & Quick Actions -->
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Console Resepsionis</h2>
                <p class="text-sm text-slate-500">Cek daftar reservasi, konfirmasi pemesanan, atau check-in tamu hari ini.</p>
            </div>
            <div>
                <a href="{{ route('admin.reservations.create') }}" class="inline-flex items-center gap-2 rounded-md bg-amber-400 px-4 py-2.5 text-sm font-bold text-slate-950 shadow-sm transition hover:bg-amber-300">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Reservasi Baru (Walk-in / Telepon)
                </a>
            </div>
        </div>

        <!-- Filter & Search Card -->
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <form method="GET" action="{{ route('receptionist.index') }}" class="grid gap-4 md:grid-cols-4">
                <!-- Search Input -->
                <div class="md:col-span-2">
                    <label for="search" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1.5">Cari Tamu</label>
                    <div class="relative">
                        <input type="text" name="search" id="search" value="{{ $search }}" placeholder="Cari nama, email, atau telepon..." class="w-full rounded-lg border border-slate-200 bg-slate-50 py-2 pl-3 pr-10 text-sm text-slate-900 outline-none transition focus:border-amber-400 focus:bg-white">
                        @if($search)
                            <a href="{{ route('receptionist.index', ['date' => $date]) }}" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Date Filter -->
                <div>
                    <label for="date" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1.5">Tanggal</label>
                    <input type="date" name="date" id="date" value="{{ $date }}" class="w-full rounded-lg border border-slate-200 bg-slate-50 py-2 px-3 text-sm text-slate-900 outline-none transition focus:border-amber-400 focus:bg-white">
                </div>

                <!-- Action Buttons (Submit & Reset) -->
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 rounded-lg bg-slate-950 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">
                        Saring
                    </button>
                    <a href="{{ route('receptionist.index') }}" class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50" title="Reset Saringan">
                        Batal
                    </a>
                </div>
            </form>

            <!-- Quick Filter Tabs -->
            <div class="mt-4 flex flex-wrap gap-2 border-t border-slate-100 pt-4">
                <a href="{{ route('receptionist.index', ['date' => $date, 'search' => $search]) }}" class="rounded-full px-3 py-1 text-xs font-semibold {{ !$status ? 'bg-slate-950 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Semua
                </a>
                @foreach(App\Enums\ReservationStatus::cases() as $s)
                    <a href="{{ route('receptionist.index', ['status' => $s->value, 'date' => $date, 'search' => $search]) }}" class="rounded-full px-3 py-1 text-xs font-semibold {{ $status === $s->value ? 'bg-slate-950 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        {{ $s->label() }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Reservations List Card -->
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                <h3 class="font-bold text-slate-900">Daftar Tamu 
                    @if($date && !$search)
                        ({{ Carbon\Carbon::parse($date)->isoFormat('dddd, D MMMM Y') }})
                    @endif
                </h3>
            </div>

            @if($reservations->isEmpty())
                <div class="flex flex-col items-center justify-center p-12 text-center">
                    <div class="rounded-full bg-slate-100 p-4 text-slate-400">
                        <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.978 11.978 0 0 1 12 20.25a11.98 11.98 0 0 1-3-1.013v-.109c0-1.113.285-2.16.786-3.07M9 19.128v-.003c0-1.113-.288-2.16-.786-3.07M12 15.75a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-7.5 3.75a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm9.75-9.75a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5ZM18.75 8.25a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/></svg>
                    </div>
                    <h4 class="mt-4 font-bold text-slate-900">Tidak Ada Reservasi</h4>
                    <p class="mt-1 text-sm text-slate-500">Tidak ditemukan data reservasi yang cocok dengan kriteria saringan Anda.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse text-left text-sm text-slate-500">
                        <thead class="bg-slate-50/75 text-xs font-bold uppercase tracking-wider text-slate-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Nama Tamu & Kontak</th>
                                <th scope="col" class="px-6 py-3">Waktu Kedatangan</th>
                                <th scope="col" class="px-6 py-3 text-center">Jumlah Tamu</th>
                                <th scope="col" class="px-6 py-3 text-center">Pilihan Meja</th>
                                <th scope="col" class="px-6 py-3 text-center">Status</th>
                                <th scope="col" class="px-6 py-3 text-right">Aksi Kedatangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 border-t border-slate-100">
                            @foreach($reservations as $reservation)
                                <tr class="hover:bg-slate-50/50">
                                    <!-- Guest Info -->
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-slate-900">{{ $reservation->name }}</div>
                                        <div class="text-xs text-slate-400">{{ $reservation->phone }}</div>
                                        <div class="text-xs text-slate-400">{{ $reservation->email }}</div>
                                    </td>
                                    <!-- Date & Time -->
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-slate-900">{{ $reservation->date->format('H:i') }} WITA</div>
                                        <div class="text-xs text-slate-400">{{ $reservation->date->isoFormat('D MMM Y') }}</div>
                                    </td>
                                    <!-- Guest Count -->
                                    <td class="px-6 py-4 text-center font-semibold text-slate-800">
                                        {{ $reservation->guests }} Orang
                                    </td>
                                    <!-- Table Info -->
                                    <td class="px-6 py-4 text-center">
                                        @if($reservation->table)
                                            <span class="inline-flex items-center gap-1 rounded bg-slate-100 px-2 py-1 text-xs font-bold text-slate-700">
                                                Meja {{ preg_replace('/\D+/', '', $reservation->table->name) ?: $reservation->table->name }} 
                                                <span class="text-slate-400 font-normal">({{ $reservation->table->capacity }} Kursi)</span>
                                            </span>
                                        @else
                                            <span class="text-xs text-slate-400">Belum disetel</span>
                                        @endif
                                    </td>
                                    <!-- Status Badge -->
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $reservation->status->badgeClasses() }}">
                                            {{ $reservation->status->label() }}
                                        </span>
                                    </td>
                                    <!-- Actions -->
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            @if($reservation->status === App\Enums\ReservationStatus::Pending)
                                                <!-- Confirm Button -->
                                                <form method="POST" action="{{ route('receptionist.confirm', $reservation) }}">
                                                    @csrf
                                                    <button type="submit" class="rounded-lg bg-emerald-500 px-3 py-1.5 text-xs font-bold text-white transition hover:bg-emerald-600">
                                                        Konfirmasi
                                                    </button>
                                                </form>
                                            @endif

                                            @if($reservation->status === App\Enums\ReservationStatus::Confirmed)
                                                <!-- Check-In Button -->
                                                <form method="POST" action="{{ route('receptionist.check-in', $reservation) }}">
                                                    @csrf
                                                    <button type="submit" class="rounded-lg bg-amber-400 px-3 py-1.5 text-xs font-bold text-slate-950 transition hover:bg-amber-300">
                                                        Tamu Hadir (Check-In)
                                                    </button>
                                                </form>
                                            @endif

                                            @if($reservation->status === App\Enums\ReservationStatus::Completed)
                                                <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                    Telah Hadir
                                                </span>
                                            @endif

                                            @if($reservation->status === App\Enums\ReservationStatus::Cancelled)
                                                <span class="text-xs font-medium text-slate-400">Dibatalkan</span>
                                            @endif

                                            @if($reservation->status !== App\Enums\ReservationStatus::Cancelled && $reservation->status !== App\Enums\ReservationStatus::Completed)
                                                <!-- Cancel Button -->
                                                <form method="POST" action="{{ route('receptionist.cancel', $reservation) }}" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?')">
                                                    @csrf
                                                    <button type="submit" class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-rose-600 transition hover:bg-rose-50 hover:border-rose-100">
                                                        Batal
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
