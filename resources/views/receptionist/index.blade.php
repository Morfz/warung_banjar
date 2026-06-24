<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Console Resepsionis - Warung Banjar</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&family=Forum&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/table-map.css') }}?v=3">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Custom styled dark theme for receptionist dashboard */
        body {
            background-color: #0e0d0b;
            color: #fff;
            font-family: 'DM Sans', sans-serif;
        }
        
        .gold-border {
            border-color: rgba(228, 197, 144, 0.2);
        }
        .gold-border-focus:focus {
            border-color: #e4c590;
            box-shadow: 0 0 0 1px #e4c590;
        }

        /* Modal styling */
        .modal-container {
            background-color: #161513;
            border: 1px solid rgba(228, 197, 144, 0.2);
        }

        /* Floor plan container within modal */
        .modal-floor-map {
            background-color: #0c0b0a;
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 20px;
            position: relative;
            overflow: auto;
            max-height: 400px;
        }

        /* Override public table-map colors for premium receptionist dark theme */
        .table-map__floor {
            background-color: #12110f !important;
            border-color: rgba(228, 197, 144, 0.15) !important;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <!-- Header Navigation -->
    <header class="border-b border-white/10 bg-black/60 backdrop-blur sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="text-xl font-bold tracking-wide text-white font-forum">Warung Banjar</span>
                <span class="h-4 w-px bg-white/20"></span>
                <span class="text-xs uppercase tracking-[0.2em] font-semibold text-amber-300">Console Resepsionis</span>
            </div>
            
            <div class="flex items-center gap-4">
                <span class="hidden md:inline text-sm text-white/60">{{ now()->isoFormat('dddd, D MMMM Y') }}</span>
                <span class="h-4 w-px bg-white/20 hidden md:block"></span>
                @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.index') }}" class="rounded-md border border-white/10 px-3 py-1.5 text-xs font-semibold text-white/80 transition hover:border-amber-300 hover:text-white">
                        Panel Admin
                    </a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="rounded-md bg-rose-500/80 px-3 py-1.5 text-xs font-bold text-white transition hover:bg-rose-600">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Workspace -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
        
        <!-- Messages -->
        @if (session()->has('danger') || session()->has('success') || session()->has('warning'))
            <div class="rounded-lg border px-4 py-3 text-sm font-semibold
                {{ session()->has('success') ? 'border-emerald-500/20 bg-emerald-500/10 text-emerald-300' : '' }}
                {{ session()->has('warning') ? 'border-amber-500/20 bg-amber-500/10 text-amber-300' : '' }}
                {{ session()->has('danger') ? 'border-rose-500/20 bg-rose-500/10 text-rose-300' : '' }}">
                {{ session('success') ?? session('warning') ?? session('danger') }}
            </div>
        @endif

        <!-- Action Header -->
        <div class="flex flex-col sm:flex-row justify-between gap-4 sm:items-center">
            <div>
                <h1 class="text-2xl font-bold text-white">Daftar Kedatangan Tamu</h1>
                <p class="text-sm text-white/50">Kelola konfirmasi, pembatalan, dan catat tamu hadir (check-in) secara real-time.</p>
            </div>
            <div>
                <button type="button" onclick="openBookingModal()" class="inline-flex items-center gap-2 rounded-lg bg-amber-400 px-5 py-2.5 text-sm font-bold text-slate-950 shadow-lg hover:shadow-amber-400/10 transition hover:bg-amber-300">
                    <svg class="h-4.5 w-4.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Reservasi Baru (Walk-in)
                </button>
            </div>
        </div>

        <!-- Filter & Search Board -->
        <div class="rounded-xl border border-white/10 bg-white/5 p-5">
            <form method="GET" action="{{ route('receptionist.index') }}" class="grid gap-4 md:grid-cols-4">
                <!-- Search Input -->
                <div class="md:col-span-2">
                    <label for="search" class="block text-xs font-semibold uppercase tracking-wider text-white/50 mb-1.5">Cari Tamu</label>
                    <div class="relative">
                        <input type="text" name="search" id="search" value="{{ $search }}" placeholder="Cari nama, email, atau nomor telepon..." class="w-full rounded-lg border border-white/10 bg-black/40 py-2 pl-3 pr-10 text-sm text-white outline-none transition focus:border-amber-400 focus:bg-black/60">
                        @if($search)
                            <a href="{{ route('receptionist.index', ['date' => $date]) }}" class="absolute inset-y-0 right-0 flex items-center pr-3 text-white/40 hover:text-white/70">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Date Filter -->
                <div>
                    <label for="date" class="block text-xs font-semibold uppercase tracking-wider text-white/50 mb-1.5">Tanggal Operasional</label>
                    <input type="date" name="date" id="date" value="{{ $date }}" class="w-full rounded-lg border border-white/10 bg-black/40 py-2 px-3 text-sm text-white outline-none transition focus:border-amber-400 focus:bg-black/60">
                </div>

                <!-- Action Buttons -->
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 rounded-lg bg-amber-400 py-2 text-sm font-bold text-slate-950 transition hover:bg-amber-300">
                        Filter
                    </button>
                    <a href="{{ route('receptionist.index') }}" class="rounded-lg border border-white/10 bg-white/5 px-3 py-2 text-sm font-semibold text-white/80 transition hover:bg-white/10 hover:text-white" title="Reset Saringan">
                        Reset
                    </a>
                </div>
            </form>

            <!-- Quick Filter Tabs -->
            <div class="mt-4 flex flex-wrap gap-2 border-t border-white/5 pt-4">
                <a href="{{ route('receptionist.index', ['date' => $date, 'search' => $search]) }}" class="rounded-full px-3 py-1 text-xs font-semibold {{ !$status ? 'bg-amber-400 text-slate-950' : 'bg-white/5 text-white/60 hover:bg-white/10 hover:text-white' }}">
                    Semua Status
                </a>
                @foreach(App\Enums\ReservationStatus::cases() as $s)
                    <a href="{{ route('receptionist.index', ['status' => $s->value, 'date' => $date, 'search' => $search]) }}" class="rounded-full px-3 py-1 text-xs font-semibold {{ $status === $s->value ? 'bg-amber-400 text-slate-950' : 'bg-white/5 text-white/60 hover:bg-white/10 hover:text-white' }}">
                        {{ $s->label() }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Bookings Board -->
        <div class="overflow-hidden rounded-xl border border-white/10 bg-white/5">
            <div class="border-b border-white/10 bg-white/5 px-6 py-4">
                <h3 class="font-bold text-white">Daftar Kedatangan Tamu 
                    @if($date && !$search)
                        ({{ Carbon\Carbon::parse($date)->isoFormat('dddd, D MMMM Y') }})
                    @endif
                </h3>
            </div>

            @if($reservations->isEmpty())
                <div class="flex flex-col items-center justify-center p-12 text-center">
                    <div class="rounded-full bg-white/5 p-4 text-white/30">
                        <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.978 11.978 0 0 1 12 20.25a11.98 11.98 0 0 1-3-1.013v-.109c0-1.113.285-2.16.786-3.07M9 19.128v-.003c0-1.113-.288-2.16-.786-3.07M12 15.75a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-7.5 3.75a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm9.75-9.75a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5ZM18.75 8.25a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/></svg>
                    </div>
                    <h4 class="mt-4 font-bold text-white">Tidak Ada Data Reservasi</h4>
                    <p class="mt-1 text-sm text-white/50">Tidak ditemukan jadwal pemesanan meja yang sesuai.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse text-left text-sm text-white/60">
                        <thead class="bg-white/5 text-xs font-bold uppercase tracking-wider text-white/40">
                            <tr>
                                <th scope="col" class="px-6 py-3">Nama Tamu & Kontak</th>
                                <th scope="col" class="px-6 py-3">Jam Datang</th>
                                <th scope="col" class="px-6 py-3 text-center">Jumlah Tamu</th>
                                <th scope="col" class="px-6 py-3 text-center">Peta Meja</th>
                                <th scope="col" class="px-6 py-3 text-center">Status</th>
                                <th scope="col" class="px-6 py-3 class=text-right">Kedatangan / Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5 border-t border-white/5">
                            @foreach($reservations as $reservation)
                                <tr class="hover:bg-white/5">
                                    <!-- Guest Info -->
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-white">{{ $reservation->name }}</div>
                                        <div class="text-xs text-white/40">{{ $reservation->phone }}</div>
                                        <div class="text-xs text-white/40">{{ $reservation->email }}</div>
                                    </td>
                                    <!-- Time -->
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-white">{{ $reservation->date->format('H:i') }} WITA</div>
                                        <div class="text-xs text-white/40">{{ $reservation->date->isoFormat('D MMM Y') }}</div>
                                    </td>
                                    <!-- Guests Count -->
                                    <td class="px-6 py-4 text-center font-semibold text-amber-300">
                                        {{ $reservation->guests }} Orang
                                    </td>
                                    <!-- Table Info -->
                                    <td class="px-6 py-4 text-center">
                                        @if($reservation->table)
                                            <span class="inline-flex items-center gap-1 rounded bg-white/10 px-2.5 py-1 text-xs font-bold text-white border border-white/5">
                                                Meja {{ preg_replace('/\D+/', '', $reservation->table->name) ?: $reservation->table->name }} 
                                                <span class="text-white/40 font-normal">({{ $reservation->table->capacity }} Kursi)</span>
                                            </span>
                                        @else
                                            <span class="text-xs text-white/30">Belum disetel</span>
                                        @endif
                                    </td>
                                    <!-- Status -->
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold 
                                            {{ $reservation->status === App\Enums\ReservationStatus::Pending ? 'bg-amber-500/20 text-amber-300 border border-amber-500/10' : '' }}
                                            {{ $reservation->status === App\Enums\ReservationStatus::Confirmed ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/10' : '' }}
                                            {{ $reservation->status === App\Enums\ReservationStatus::Completed ? 'bg-sky-500/20 text-sky-300 border border-sky-500/10' : '' }}
                                            {{ $reservation->status === App\Enums\ReservationStatus::Cancelled ? 'bg-rose-500/20 text-rose-300 border border-rose-500/10' : '' }}
                                        ">
                                            {{ $reservation->status->label() }}
                                        </span>
                                    </td>
                                    <!-- Actions -->
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            @if($reservation->status === App\Enums\ReservationStatus::Pending)
                                                <!-- Confirm -->
                                                <form method="POST" action="{{ route('receptionist.confirm', $reservation) }}">
                                                    @csrf
                                                    <button type="submit" class="rounded-lg bg-emerald-500 px-3 py-1.5 text-xs font-bold text-white transition hover:bg-emerald-600">
                                                        Konfirmasi
                                                    </button>
                                                </form>
                                            @endif

                                            @if($reservation->status === App\Enums\ReservationStatus::Confirmed)
                                                <!-- Check-In -->
                                                <form method="POST" action="{{ route('receptionist.check-in', $reservation) }}">
                                                    @csrf
                                                    <button type="submit" class="rounded-lg bg-amber-400 px-3 py-1.5 text-xs font-bold text-slate-950 transition hover:bg-amber-300">
                                                        Check-In (Hadir)
                                                    </button>
                                                </form>
                                            @endif

                                            @if($reservation->status === App\Enums\ReservationStatus::Completed)
                                                <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-400">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                    Hadir
                                                </span>
                                            @endif

                                            @if($reservation->status === App\Enums\ReservationStatus::Cancelled)
                                                <span class="text-xs font-medium text-white/30">Dibatalkan</span>
                                            @endif

                                            @if($reservation->status !== App\Enums\ReservationStatus::Cancelled && $reservation->status !== App\Enums\ReservationStatus::Completed)
                                                <!-- Cancel -->
                                                <form method="POST" action="{{ route('receptionist.cancel', $reservation) }}" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?')">
                                                    @csrf
                                                    <button type="submit" class="rounded-lg border border-white/10 bg-white/5 px-3 py-1.5 text-xs font-semibold text-rose-400 transition hover:bg-white/10">
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
    </main>

    <!-- Walk-in Booking Pop-up Modal -->
    <div id="bookingModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 hidden transition-opacity duration-300">
        <div class="modal-container w-full max-w-5xl rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
            <!-- Header -->
            <div class="border-b border-white/10 px-6 py-4 flex items-center justify-between bg-white/5">
                <h3 class="text-lg font-bold text-white">Reservasi Walk-in Baru</h3>
                <button type="button" onclick="closeBookingModal()" class="rounded-md p-1.5 text-white/60 hover:bg-white/5 hover:text-white transition">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <!-- Body -->
            <form id="walkinForm" method="POST" action="{{ route('receptionist.store-walkin') }}" class="flex-1 overflow-y-auto p-6 grid gap-6 md:grid-cols-2">
                @csrf
                
                <!-- Left: Form Fields -->
                <div class="space-y-4">
                    <div>
                        <h4 class="text-sm font-bold uppercase tracking-wider text-amber-300 mb-4">Data Pelanggan</h4>
                    </div>
                    
                    <div>
                        <label for="name_walkin" class="block text-sm font-semibold text-white/80">Nama Tamu</label>
                        <input type="text" id="name_walkin" name="name" required class="mt-1.5 w-full rounded-lg border border-white/10 bg-black/40 py-2 px-3 text-sm text-white outline-none focus:border-amber-400">
                    </div>
                    
                    <div>
                        <label for="phone_walkin" class="block text-sm font-semibold text-white/80">Nomor Telepon</label>
                        <input type="tel" id="phone_walkin" name="phone" required class="mt-1.5 w-full rounded-lg border border-white/10 bg-black/40 py-2 px-3 text-sm text-white outline-none focus:border-amber-400">
                    </div>

                    <div>
                        <label for="email_walkin" class="block text-sm font-semibold text-white/80">Email <span class="text-xs text-white/40">(Opsional)</span></label>
                        <input type="email" id="email_walkin" name="email" class="mt-1.5 w-full rounded-lg border border-white/10 bg-black/40 py-2 px-3 text-sm text-white outline-none focus:border-amber-400" placeholder="customer@email.com">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="guests_walkin" class="block text-sm font-semibold text-white/80">Jumlah Tamu</label>
                            <input type="number" id="guests_walkin" name="guests" min="1" max="20" required value="2" class="mt-1.5 w-full rounded-lg border border-white/10 bg-black/40 py-2 px-3 text-sm text-white outline-none focus:border-amber-400">
                        </div>

                        <div>
                            <label for="date_only" class="block text-sm font-semibold text-white/80">Tanggal</label>
                            <input type="date" id="date_only" required value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" class="mt-1.5 w-full rounded-lg border border-white/10 bg-black/40 py-2 px-3 text-sm text-white outline-none focus:border-amber-400">
                        </div>
                    </div>

                    <div>
                        <label for="time_only" class="block text-sm font-semibold text-white/80">Waktu Kedatangan</label>
                        <select id="time_only" required class="mt-1.5 w-full rounded-lg border border-white/10 bg-black/40 py-2 px-3 text-sm text-white outline-none focus:border-amber-400">
                            @php
                                $start = Carbon\Carbon::createFromTimeString('08:00');
                                $end = Carbon\Carbon::createFromTimeString('22:00');
                            @endphp
                            @while($start->lte($end))
                                @php $timeStr = $start->format('H:i'); @endphp
                                <option value="{{ $timeStr }}" @selected($timeStr === '12:00')>{{ $timeStr }} WITA</option>
                                @php $start->addMinutes(30); @endphp
                            @endwhile
                        </select>
                    </div>

                    <!-- Hidden combined datetime -->
                    <input type="hidden" id="date_combined" name="date">
                    <!-- Selected Table -->
                    <input type="hidden" id="selected_table_id" name="table_id" required>
                </div>

                <!-- Right: Visual Table Selector -->
                <div class="flex flex-col space-y-4">
                    <div>
                        <h4 class="text-sm font-bold uppercase tracking-wider text-amber-300 mb-2">Pilih Meja pada Denah</h4>
                        <p class="text-xs text-white/50">Silakan tentukan jumlah tamu & waktu di kiri terlebih dahulu untuk melihat ketersediaan meja.</p>
                    </div>

                    <!-- Denah Layout -->
                    <div class="modal-floor-map flex-1 min-h-[350px]">
                        <div class="table-map__floor !scale-90 origin-top-left">
                            <div class="table-map__grid"></div>
                            
                            @foreach($tables as $table)
                                @php
                                    $shape = $table->layout_shape === 'horizontal' ? 'horizontal' : 'vertical';
                                @endphp
                                <label class="table-choice table-choice--{{ $shape }} table-capacity--{{ $table->capacity }}" 
                                       data-id="{{ $table->id }}" 
                                       data-capacity="{{ $table->capacity }}" 
                                       style="left: {{ $table->layout_x }}%; top: {{ $table->layout_y }}%; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center;">
                                    <input type="radio" name="modal_table_radio" value="{{ $table->id }}" class="hidden">
                                    <span class="text-[14px] font-bold italic line-height-none">{{ preg_replace('/\D+/', '', $table->name) ?: $table->name }}</span>
                                    <em class="text-[8px] opacity-60 font-sans block">{{ $table->capacity }} C</em>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>

            <!-- Footer Actions -->
            <div class="border-t border-white/10 px-6 py-4 flex items-center justify-between bg-white/5">
                <span id="selectionSummary" class="text-sm font-semibold text-amber-300">Pilih meja untuk melanjutkan...</span>
                <div class="flex items-center gap-3">
                    <button type="button" onclick="closeBookingModal()" class="rounded-lg border border-white/10 bg-white/5 px-4 py-2 text-sm font-semibold text-white/80 transition hover:bg-white/10 hover:text-white">
                        Batal
                    </button>
                    <button type="button" onclick="submitWalkin()" class="rounded-lg bg-amber-400 px-5 py-2 text-sm font-bold text-slate-950 shadow-md transition hover:bg-amber-300">
                        Buat Reservasi
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Inline script for interactive receptionist actions and modal handling -->
    <script>
        const openBookingModal = () => {
            document.getElementById('bookingModal').classList.remove('hidden');
            updateDateTimeCombined();
            fetchAvailability();
        };

        const closeBookingModal = () => {
            document.getElementById('bookingModal').classList.add('hidden');
        };

        const updateDateTimeCombined = () => {
            const dateVal = document.getElementById('date_only').value;
            const timeVal = document.getElementById('time_only').value;
            if (dateVal && timeVal) {
                document.getElementById('date_combined').value = `${dateVal} ${timeVal}`;
            }
        };

        const fetchAvailability = () => {
            updateDateTimeCombined();
            const dateCombined = document.getElementById('date_combined').value;
            const guests = parseInt(document.getElementById('guests_walkin').value) || 1;

            if (!dateCombined) return;

            // Reset current visual selection
            document.getElementById('selected_table_id').value = '';
            document.getElementById('selectionSummary').innerText = 'Pilih meja untuk melanjutkan...';

            fetch(`/receptionist/check-availability?date=${encodeURIComponent(dateCombined)}&guests=${guests}`)
                .then(response => response.json())
                .then(data => {
                    const reservedIds = data.reserved_table_ids || [];
                    const tableLabels = document.querySelectorAll('#bookingModal .table-choice');

                    tableLabels.forEach(label => {
                        const tableId = parseInt(label.getAttribute('data-id'));
                        const capacity = parseInt(label.getAttribute('data-capacity'));
                        const isReserved = reservedIds.includes(tableId);
                        const isTooSmall = capacity < guests;

                        // Reset selection style
                        label.style.background = '';
                        label.style.boxShadow = '';
                        label.style.color = '#fff';
                        
                        // Disable radio input
                        const radio = label.querySelector('input');
                        radio.checked = false;

                        if (isReserved || isTooSmall) {
                            label.classList.add('table-choice--disabled');
                            label.style.opacity = '0.25';
                            label.style.cursor = 'not-allowed';
                            label.style.pointerEvents = 'none';
                        } else {
                            label.classList.remove('table-choice--disabled');
                            label.style.opacity = '1';
                            label.style.cursor = 'pointer';
                            label.style.pointerEvents = 'auto';
                        }
                    });
                })
                .catch(err => console.error('Error fetching table availability:', err));
        };

        // Attach event listeners for live availability updates
        document.getElementById('date_only').addEventListener('change', fetchAvailability);
        document.getElementById('time_only').addEventListener('change', fetchAvailability);
        document.getElementById('guests_walkin').addEventListener('input', fetchAvailability);

        // Map selection logic
        document.querySelectorAll('#bookingModal .table-choice').forEach(label => {
            label.addEventListener('click', (e) => {
                if (label.classList.contains('table-choice--disabled')) return;

                // Reset all other selections
                document.querySelectorAll('#bookingModal .table-choice').forEach(l => {
                    if (!l.classList.contains('table-choice--disabled')) {
                        l.style.background = '';
                        l.style.boxShadow = '';
                        l.style.color = '#fff';
                        l.querySelector('input').checked = false;
                    }
                });

                // Highlight selected label
                label.style.background = 'linear-gradient(180deg, #e4c590, #caa66d)';
                label.style.color = '#0e0d0b';
                label.style.boxShadow = '0 8px 20px rgba(228, 197, 144, 0.35)';
                
                const radio = label.querySelector('input');
                radio.checked = true;
                
                const tableId = label.getAttribute('data-id');
                document.getElementById('selected_table_id').value = tableId;

                const tableName = label.querySelector('span').innerText;
                document.getElementById('selectionSummary').innerText = `Terpilih: Meja ${tableName} (${label.getAttribute('data-capacity')} Kursi)`;
            });
        });

        const submitWalkin = () => {
            const tableId = document.getElementById('selected_table_id').value;
            if (!tableId) {
                alert('Pilih meja pada denah terlebih dahulu!');
                return;
            }
            document.getElementById('walkinForm').submit();
        };
    </script>
</body>
</html>
