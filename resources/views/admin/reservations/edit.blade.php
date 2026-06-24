<x-admin-layout>
    <x-slot name="header">Edit Reservasi</x-slot>

    <x-admin-form-card title="Edit Reservasi" description="Perbarui detail reservasi." :back="route('admin.reservations.index')">
        <form method="POST" action="{{ route('admin.reservations.update', $reservation->id) }}" class="max-w-2xl space-y-5">
            @csrf
            @method('PUT')

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-800">Nama</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $reservation->name) }}" autofocus
                        class="mt-1.5 block w-full rounded-md border-slate-300 py-2 px-3 text-sm shadow-sm focus:border-amber-400 focus:ring-amber-400 @error('name') border-rose-400 focus:border-rose-400 focus:ring-rose-400 @enderror" />
                    @error('name')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-800">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $reservation->email) }}"
                        class="mt-1.5 block w-full rounded-md border-slate-300 py-2 px-3 text-sm shadow-sm focus:border-amber-400 focus:ring-amber-400 @error('email') border-rose-400 focus:border-rose-400 focus:ring-rose-400 @enderror" />
                    @error('email')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-semibold text-slate-800">Telepon</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $reservation->phone) }}"
                        class="mt-1.5 block w-full rounded-md border-slate-300 py-2 px-3 text-sm shadow-sm focus:border-amber-400 focus:ring-amber-400 @error('phone') border-rose-400 focus:border-rose-400 focus:ring-rose-400 @enderror" />
                    @error('phone')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="guests" class="block text-sm font-semibold text-slate-800">Jumlah Tamu</label>
                    <input type="number" min="1" max="20" id="guests" name="guests" value="{{ old('guests', $reservation->guests) }}"
                        class="mt-1.5 block w-full rounded-md border-slate-300 py-2 px-3 text-sm shadow-sm focus:border-amber-400 focus:ring-amber-400 @error('guests') border-rose-400 focus:border-rose-400 focus:ring-rose-400 @enderror" />
                    @error('guests')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-slate-800">Tanggal & Waktu</label>
                    <div class="mt-1.5 flex gap-3">
                        <input type="date" id="date_picker" min="{{ now()->format('Y-m-d') }}" max="{{ now()->addWeek()->format('Y-m-d') }}" required
                            class="block w-full rounded-md border-slate-300 py-2 px-3 text-sm shadow-sm focus:border-amber-400 focus:ring-amber-400" />
                        
                        <select id="time_picker" required
                            class="block w-full rounded-md border-slate-300 py-2 px-3 text-sm shadow-sm focus:border-amber-400 focus:ring-amber-400">
                            <option value="" disabled selected>Pilih Jam…</option>
                            @php
                                $start = Carbon\Carbon::createFromTimeString('08:00');
                                $end = Carbon\Carbon::createFromTimeString('21:00');
                            @endphp
                            @while($start->lte($end))
                                @php $timeStr = $start->format('H:i'); @endphp
                                <option value="{{ $timeStr }}">{{ $timeStr }}</option>
                                @php $start->addMinutes(30); @endphp
                            @endwhile
                        </select>
                    </div>
                    <input type="hidden" id="date" name="date" value="{{ old('date', $reservation->date->format('Y-m-d\TH:i')) }}" />
                    <p class="mt-1 text-xs text-slate-400">Reservasi berlaku 7 hari ke depan, pukul 08:00–21:00 (interval 30 menit).</p>
                    @error('date')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="table_id" class="block text-sm font-semibold text-slate-800">Meja</label>
                    <select id="table_id" name="table_id"
                        class="mt-1.5 block w-full rounded-md border-slate-300 py-2 px-3 text-sm shadow-sm focus:border-amber-400 focus:ring-amber-400 @error('table_id') border-rose-400 focus:border-rose-400 focus:ring-rose-400 @enderror">
                        @foreach($tables as $table)
                            <option value="{{ $table->id }}" @selected(old('table_id', $reservation->table_id) == $table->id)>{{ $table->name }} — {{ $table->capacity }} tamu</option>
                        @endforeach
                    </select>
                    @error('table_id')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-semibold text-slate-800">Status</label>
                    <select id="status" name="status"
                        class="mt-1.5 block w-full rounded-md border-slate-300 py-2 px-3 text-sm shadow-sm focus:border-amber-400 focus:ring-amber-400 @error('status') border-rose-400 focus:border-rose-400 focus:ring-rose-400 @enderror">
                        @foreach($statuses as $status)
                            <option value="{{ $status->value }}" @selected(old('status', $reservation->status->value) === $status->value)>{{ $status->label() }}</option>
                        @endforeach
                    </select>
                    @error('status')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex justify-end border-t border-slate-100 pt-5">
                <button type="submit" class="inline-flex items-center gap-1.5 rounded-md bg-slate-950 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                    Perbarui Reservasi
                </button>
            </div>
        </form>
    </x-admin-form-card>

    <script>
        (() => {
            const datePicker = document.getElementById('date_picker');
            const timePicker = document.getElementById('time_picker');
            const hiddenDate = document.getElementById('date');

            const syncDateTime = () => {
                if (datePicker.value && timePicker.value) {
                    hiddenDate.value = `${datePicker.value} ${timePicker.value}:00`;
                } else {
                    hiddenDate.value = '';
                }
            };

            if (hiddenDate && hiddenDate.value) {
                const parts = hiddenDate.value.split(/[T ]/);
                if (parts[0] && datePicker) datePicker.value = parts[0];
                if (parts[1] && timePicker) {
                    const timeParts = parts[1].split(':');
                    timePicker.value = `${timeParts[0]}:${timeParts[1]}`;
                }
            }

            datePicker?.addEventListener('change', syncDateTime);
            timePicker?.addEventListener('change', syncDateTime);
        })();
    </script>
</x-admin-layout>
