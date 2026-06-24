<x-guest-layout>
    <div class="container-reservation padding-2">
        <section class="reservation reservation-panel">
        <form method="POST" action="{{ route('reservations.store') }}">
            @csrf
            <h2 class="section-title">Reservasi Online</h2>
            <p class="paragraph">Pesan melalui <a href="tel:+6281234567890">+62 812 3456 7890</a> atau isi formulir reservasi.</p>
            @if ($errors->any())
                <div class="form-errors">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <div class="inputs">
                <div class="reservation-fields">
                    <input class="input-field" type="text" value="{{ old('name') }}" id="name" name="name" placeholder="Nama Anda" autocomplete="name" required>
                    <input class="input-field" type="email" value="{{ old('email') }}" id="email" name="email" placeholder="Email" autocomplete="email" required>
                    <input class="input-field" type="tel" value="{{ old('phone') }}" id="phone" name="phone" placeholder="Nomor Telepon" autocomplete="tel" required>
                </div>
                <div class="reservation-fields">
                    <span>
                        <ion-icon name="person-outline"></ion-icon>
                        <select id="guests" name="guests" class="input-field" required>
                            <option value="" disabled @selected(! old('guests'))>Pilih jumlah tamu</option>
                            @for ($guest = 1; $guest <= 8; $guest++)
                                <option value="{{ $guest }}" @selected(old('guests') == $guest)>{{ $guest }} Orang</option>
                            @endfor
                        </select>
                        <ion-icon name="chevron-down-outline"></ion-icon>
                    </span>
                    <span>
                        <ion-icon name="calendar-outline"></ion-icon>
                        <input class="input-field" type="date" id="date_picker" min="{{ $min_date->format('Y-m-d') }}" max="{{ $max_date->format('Y-m-d') }}" required style="padding-left: 35px;">
                    </span>
                    <span>
                        <ion-icon name="time-outline"></ion-icon>
                        <select id="time_picker" class="input-field" required>
                            <option value="" disabled selected>Pilih Jam</option>
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
                        <ion-icon name="chevron-down-outline"></ion-icon>
                    </span>
                    <input type="hidden" name="date" id="date" value="{{ old('date') }}">
                </div>
                @if ($tables->isEmpty())
                    <div class="empty-state">
                        <h3>Belum ada meja</h3>
                        <p>Silakan hubungi admin untuk menambahkan data meja.</p>
                    </div>
                @else
                    <div class="table-map" aria-label="Denah meja restoran">
                        <div class="table-map__legend">
                            <span><i class="table-map__dot table-map__dot--available"></i> Tersedia</span>
                            <span><i class="table-map__dot table-map__dot--selected"></i> Dipilih</span>
                            <span><i class="table-map__dot table-map__dot--disabled"></i> Tidak tersedia</span>
                        </div>
                        <div class="table-map__floor">
                            <div class="table-map__grid"></div>
                            <div class="table-map__decor table-map__decor--counter-group">
                                <div class="table-map__decor--counter">Resepsionis</div>
                                <div class="table-map__decor--counter-wall"></div>
                            </div>
                            <div class="table-map__decor table-map__decor--entrance">↑ Pintu Masuk</div>

                            @foreach($tables as $table)
                                @php
                                    $shape = $table->layout_shape === 'horizontal' ? 'horizontal' : 'vertical';
                                @endphp
                                <label class="table-choice table-choice--{{ $shape }} table-capacity--{{ $table->capacity }} @unless($table->is_selectable) table-choice--disabled @endunless" data-capacity="{{ $table->capacity }}" style="left: {{ $table->layout_x }}%; top: {{ $table->layout_y }}%; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center;">
                                    <input type="radio" name="table_id" value="{{ $table->id }}" required @checked(old('table_id') == $table->id) @disabled(! $table->is_selectable) style="position:absolute;opacity:0;width:0;height:0;pointer-events:none;">
                                    <span style="display:block;width:100%;text-align:center;font-size:18px;font-style:italic;font-weight:700;line-height:1;">{{ preg_replace('/\D+/', '', $table->name) ?: $table->name }}</span>
                                    @if($table?->unavailable_reason)
                                        <em style="display:block;width:100%;text-align:center;font-size:9px;font-style:normal;">{{ $table->unavailable_reason }}</em>
                                    @endif
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <p class="table-map__hint">Pilih meja dari denah. Sistem akan mengecek kapasitas dan jadwal meja saat reservasi dikirim.</p>
                @endif
                <button class="btn btn-secondary" type="submit" data-text="Buat Reservasi" @disabled($tables->where('is_selectable', true)->isEmpty())>
                     <span>Buat Reservasi</span>
                </button>
            </div>
        </form>
    </section>
    </div>

    <style>
        /* Override global span { display: block } untuk nomor meja */
        .table-choice {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
            box-sizing: border-box !important;
        }
        .table-choice > span {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
            flex: 1 1 auto !important;
            text-align: center !important;
            font-size: 18px !important;
            font-style: italic !important;
            font-weight: 700 !important;
            line-height: 1 !important;
            margin: 0 !important;
            box-sizing: border-box !important;
        }
        .table-choice > input[type="radio"] {
            position: absolute !important;
            opacity: 0 !important;
            width: 0 !important;
            height: 0 !important;
            pointer-events: none !important;
        }
        .table-choice > em {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
            font-size: 9px !important;
            font-style: normal !important;
            margin: 0 !important;
            padding-bottom: 4px !important;
            box-sizing: border-box !important;
        }
        /* Fix .inputs span overriding .btn span */
        .inputs .btn span,
        .inputs .btn:after {
            position: absolute !important;
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
            display: block !important;
            width: auto !important;
            min-width: max-content !important;
            flex-grow: 0 !important;
        }

        /* Custom Flatpickr Premium Theme Styling */
        .flatpickr-calendar {
            background: var(--eerie-black-2) !important;
            border: 1px solid var(--gold-crayola) !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5) !important;
            color: var(--white) !important;
            font-family: inherit !important;
        }
        .flatpickr-calendar.arrowUp::after {
            border-bottom-color: var(--eerie-black-2) !important;
        }
        .flatpickr-calendar.arrowUp::before {
            border-bottom-color: var(--gold-crayola) !important;
        }
        .flatpickr-calendar.arrowDown::after {
            border-top-color: var(--eerie-black-2) !important;
        }
        .flatpickr-calendar.arrowDown::before {
            border-top-color: var(--gold-crayola) !important;
        }
        .flatpickr-months .flatpickr-month,
        .flatpickr-months .flatpickr-prev-month, 
        .flatpickr-months .flatpickr-next-month {
            color: var(--white) !important;
            fill: var(--white) !important;
        }
        .flatpickr-months .flatpickr-prev-month:hover svg, 
        .flatpickr-months .flatpickr-next-month:hover svg {
            fill: var(--gold-crayola) !important;
        }
        .flatpickr-weekday {
            color: var(--quick-silver) !important;
            font-weight: 600 !important;
        }
        .flatpickr-day {
            color: var(--white) !important;
        }
        .flatpickr-day:hover,
        .flatpickr-day.prevMonthDay:hover,
        .flatpickr-day.nextMonthDay:hover,
        .flatpickr-day.today:hover {
            background: var(--gold-crayola) !important;
            border-color: var(--gold-crayola) !important;
            color: var(--eerie-black-1) !important;
        }
        .flatpickr-day.selected,
        .flatpickr-day.selected:hover {
            background: var(--gold-crayola) !important;
            border-color: var(--gold-crayola) !important;
            color: var(--eerie-black-1) !important;
            font-weight: bold !important;
        }
        .flatpickr-day.today {
            border-color: var(--gold-crayola) !important;
        }
        .flatpickr-day.flatpickr-disabled,
        .flatpickr-day.flatpickr-disabled:hover,
        .flatpickr-day.prevMonthDay,
        .flatpickr-day.nextMonthDay {
            color: var(--davys-grey) !important;
            background: transparent !important;
            border-color: transparent !important;
        }
    </style>

    <script>
        (() => {
            // Date & Time pickers sync logic
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

            const fp = flatpickr(datePicker, {
                minDate: datePicker.getAttribute('min'),
                maxDate: datePicker.getAttribute('max'),
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d F Y",
                disableMobile: "true",
                onChange: function(selectedDates, dateStr) {
                    datePicker.value = dateStr;
                    syncDateTime();
                }
            });

            timePicker?.addEventListener('change', syncDateTime);

            const guests = document.getElementById('guests');
            const choices = [...document.querySelectorAll('.table-choice')];

            // Load saved cashier position
            const cashierGroup = document.querySelector('.table-map__decor--counter-group');
            if (cashierGroup) {
                const savedX = localStorage.getItem('cashier_x');
                const savedY = localStorage.getItem('cashier_y');
                if (savedX && savedY) {
                    cashierGroup.style.left = `${savedX}%`;
                    cashierGroup.style.top = `${savedY}%`;
                    cashierGroup.style.bottom = 'auto'; // Disable default bottom positioning
                }
            }

            // Load saved entrance position
            const entranceNode = document.querySelector('.table-map__decor--entrance');
            if (entranceNode) {
                const savedX = localStorage.getItem('entrance_x');
                const savedY = localStorage.getItem('entrance_y');
                if (savedX && savedY) {
                    entranceNode.style.left = `${savedX}%`;
                    entranceNode.style.top = `${savedY}%`;
                    entranceNode.style.bottom = 'auto'; // Disable default bottom positioning
                    entranceNode.style.transform = 'translate(-50%, -50%)';
                }
            }

            const updateCapacity = () => {
                const totalGuests = Number(guests.value || 0);

                choices.forEach((choice) => {
                    const input = choice.querySelector('input[name="table_id"]');
                    const capacity = Number(choice.dataset.capacity || 0);
                    const unavailable = choice.classList.contains('table-choice--disabled');
                    
                    let isMismatched = false;
                    if (totalGuests > 0) {
                        const allowedCapacity = totalGuests <= 2 ? 2 : (totalGuests <= 4 ? 4 : (totalGuests <= 6 ? 6 : 8));
                        isMismatched = capacity !== allowedCapacity;
                    }

                    choice.classList.toggle('table-choice--capacity-disabled', isMismatched);

                    if (input) {
                        input.disabled = unavailable || isMismatched;

                        if (input.checked && input.disabled) {
                            input.checked = false;
                        }
                    }
                });
            };

            guests?.addEventListener('change', updateCapacity);
            updateCapacity();
        })();
    </script>
</x-guest-layout>
