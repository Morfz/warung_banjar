<x-admin-layout>
    <x-slot name="header">Atur Denah Meja</x-slot>

    <form method="POST" action="{{ route('admin.tables.layout.update') }}" class="space-y-5" id="layout-form">
        @csrf
        @method('PUT')

        <div class="grid gap-5 xl:grid-cols-[280px_minmax(0,1fr)] layout-grid-container">
            <aside class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm layout-sidebar-tables">
                <div class="mb-4">
                    <h2 class="text-base font-bold text-slate-950">Pilihan Meja</h2>
                    <p class="mt-1 text-sm text-slate-500">Tarik meja ke lantai, lalu pilih bentuknya bila perlu.</p>
                </div>

                <div class="space-y-3">
                    @foreach ($tables as $table)
                        <button type="button"
                            class="layout-list-item flex w-full items-center justify-between rounded-md border border-slate-200 bg-slate-50 px-3 py-2 text-left text-sm transition hover:border-amber-300 hover:bg-amber-50"
                            draggable="true"
                            data-table-id="{{ $table->id }}">
                            <span>
                                <strong class="block text-slate-950">{{ $table->name }}</strong>
                                <span class="text-xs text-slate-500">{{ $table->capacity }} Tamu</span>
                            </span>
                            <span class="rounded-full bg-white px-2 py-1 text-xs font-semibold text-slate-600">{{ $table->layout_shape === 'horizontal' ? 'horizontal' : 'vertical' }}</span>
                        </button>
                    @endforeach
                </div>
            </aside>

            <section class="rounded-lg border border-slate-200 bg-white shadow-sm layout-main-section">
                <div class="flex flex-col gap-3 border-b border-slate-200 px-5 py-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-base font-bold text-slate-950">Lantai Restoran</h2>
                        <p class="text-sm text-slate-500">Klik meja untuk mengubah bentuk, tarik untuk memindahkan posisi.</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('admin.tables.index') }}" class="rounded-md border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Kembali</a>
                        <button type="submit" class="rounded-md bg-slate-950 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">Simpan Denah</button>
                    </div>
                </div>

                <div class="p-5 layout-editor-container">
                    <div class="layout-editor-wrapper">
                        <div class="layout-editor" id="layout-floor">
                            @foreach ($tables as $table)
                                @php
                                    $shape = $table->layout_shape === 'horizontal' ? 'horizontal' : 'vertical';
                                @endphp
                                <div class="layout-table layout-table--{{ $shape }} layout-capacity--{{ $table->capacity }}"
                                    draggable="true"
                                    data-table-id="{{ $table->id }}"
                                    data-capacity="{{ $table->capacity }}"
                                    data-shape="{{ $shape }}"
                                    style="left: {{ $table->layout_x }}%; top: {{ $table->layout_y }}%;"><strong>{{ preg_replace('/\D+/', '', $table->name) ?: $table->name }}</strong></div>
                                <input type="hidden" name="tables[{{ $loop->index }}][id]" value="{{ $table->id }}">
                                <input type="hidden" name="tables[{{ $loop->index }}][layout_x]" value="{{ $table->layout_x }}" data-x-for="{{ $table->id }}">
                                <input type="hidden" name="tables[{{ $loop->index }}][layout_y]" value="{{ $table->layout_y }}" data-y-for="{{ $table->id }}">
                                <input type="hidden" name="tables[{{ $loop->index }}][layout_shape]" value="{{ $shape }}" data-shape-for="{{ $table->id }}">
                            @endforeach

                            <div class="layout-decor layout-decor--counter-group" draggable="true">
                                <div class="layout-decor--counter">Resepsionis</div>
                                <div class="layout-decor--counter-wall"></div>
                            </div>
                            <div class="layout-decor layout-decor--entrance" draggable="true">↑ Pintu Masuk</div>
                        </div>
                    </div>

                    <div class="mt-4 flex flex-wrap gap-2 text-xs text-slate-500">
                        <span class="rounded-full bg-slate-100 px-3 py-1">Bentuk: klik meja untuk mengganti</span>
                        <span class="rounded-full bg-slate-100 px-3 py-1">Posisi disimpan dalam persen</span>
                        <span class="rounded-full bg-slate-100 px-3 py-1">Denah publik mengikuti halaman ini</span>
                    </div>
                </div>
            </section>
        </div>
    </form>

    <style>
        @media (min-width: 1280px) {
            html, body {
                overflow: hidden !important;
                height: 100vh !important;
            }

            .min-h-screen.lg\:flex {
                height: 100vh !important;
                overflow: hidden !important;
            }

            .min-w-0.flex-1 {
                display: flex !important;
                flex-direction: column !important;
                height: 100vh !important;
                overflow: hidden !important;
            }

            main {
                flex: 1 !important;
                overflow: hidden !important;
                display: flex !important;
                flex-direction: column !important;
                padding-top: 1.5rem !important;
                padding-bottom: 1.5rem !important;
            }

            #layout-form {
                flex: 1 !important;
                display: flex !important;
                flex-direction: column !important;
                overflow: hidden !important;
                margin-top: 0 !important;
                margin-bottom: 0 !important;
            }

            .layout-grid-container {
                flex: 1 !important;
                display: grid !important;
                grid-template-columns: 280px minmax(0, 1fr) !important;
                grid-template-rows: 1fr !important;
                overflow: hidden !important;
                height: 100% !important;
            }

            .layout-sidebar-tables {
                display: flex !important;
                flex-direction: column !important;
                overflow-y: auto !important;
                max-height: 100% !important;
            }

            .layout-main-section {
                display: flex !important;
                flex-direction: column !important;
                overflow: hidden !important;
                height: 100% !important;
            }

            .layout-editor-container {
                flex: 1 !important;
                overflow: hidden !important;
                display: flex !important;
                flex-direction: column !important;
                min-height: 0 !important;
                padding: 1.25rem !important;
            }

            .layout-editor-wrapper {
                flex: 1 !important;
                overflow: hidden !important;
                min-height: 0 !important;
                border: 1px solid rgba(228, 197, 144, .35);
                border-radius: 0.5rem;
                background: #121111;
                container-type: size !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
            }

            .layout-editor {
                border: none !important;
                min-height: 0 !important;
                width: min(100cqw, 100cqh * 16 / 9) !important;
                height: min(100cqh, 100cqw * 9 / 16) !important;
            }
        }

        .layout-editor {
            aspect-ratio: 16 / 9;
            background-color: #121111;
            background-image:
                linear-gradient(rgba(228, 197, 144, .08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(228, 197, 144, .08) 1px, transparent 1px);
            background-size: 32px 32px;
            border: 1px solid rgba(228, 197, 144, .35);
            min-height: 560px;
            overflow: hidden;
            position: relative;
        }

        .layout-table {
            align-items: center;
            background: linear-gradient(180deg, #2b2a27, #181716);
            box-shadow: 0 14px 24px rgba(0, 0, 0, .35), inset 0 0 0 1px rgba(228, 197, 144, .3);
            color: #fff;
            cursor: grab;
            display: flex;
            flex-direction: column;
            gap: 3px;
            height: 74px;
            justify-content: center;
            position: absolute;
            text-align: center;
            transform: translate(-50%, -50%);
            user-select: none;
            width: 58px;
            z-index: 2;
        }

        .layout-table::before,
        .layout-table::after {
            background:
                linear-gradient(180deg, rgba(255, 255, 255, .12), transparent),
                #3a3833;
            border-radius: 8px;
            box-shadow:
                0 3px 8px rgba(0, 0, 0, .26),
                inset 0 0 0 1px rgba(228, 197, 144, .18);
            content: "";
            height: 26px;
            position: absolute;
            top: 12px;
            width: 16px;
        }

        .layout-table::before { left: -22px; }
        .layout-table::after { right: -22px; }

        .layout-table:active {
            cursor: grabbing;
        }

        .layout-table strong {
            font-size: 18px;
            font-style: italic;
        }

        .layout-table small {
            color: #a6a6a6;
            font-size: 10px;
        }

        .layout-table--horizontal { height: 58px; width: 132px; }
        .layout-table--horizontal::before,
        .layout-table--horizontal::after {
            height: 16px;
            top: -22px;
            width: 28px;
        }
        .layout-table--horizontal::before {
            box-shadow:
                43px 0 0 #3a3833,
                86px 0 0 #3a3833,
                0 96px 0 #3a3833,
                43px 96px 0 #3a3833,
                86px 96px 0 #3a3833;
            left: 10px;
        }
        .layout-table--horizontal::after { display: none; }

        .layout-table--horizontal.layout-capacity--4 {
            height: 50px;
            width: 68px;
        }
        .layout-table--horizontal.layout-capacity--4::before {
            box-shadow:
                32px 0 0 #3a3833,
                0 78px 0 #3a3833,
                32px 78px 0 #3a3833;
            left: 4px;
        }

        .layout-table--square { border-radius: 14px; height: 74px; width: 74px; }
        .layout-table--square::before,
        .layout-table--square::after {
            height: 22px;
            width: 22px;
        }
        .layout-table--square::before {
            left: -18px;
            top: -12px;
            transform: rotate(45deg);
            box-shadow: 56px 0 0 #3a3833;
        }
        .layout-table--square::after {
            right: -18px;
            top: 58px;
            transform: rotate(45deg);
            box-shadow: -56px 0 0 #3a3833;
        }

        .layout-table--small { height: 50px; width: 68px; }
        .layout-table--small::before,
        .layout-table--small::after {
            height: 24px;
            top: 13px;
            width: 18px;
        }

        .layout-table--diagonal { transform: translate(-50%, -50%) rotate(-45deg); }
        .layout-table--diagonal > * { transform: rotate(45deg); }
        .layout-table--long { height: 138px; width: 64px; }
        .layout-table--long::before,
        .layout-table--long::after {
            box-shadow:
                0 34px 0 #3a3833,
                0 68px 0 #3a3833;
        }

        .layout-table--long.layout-capacity--8::before,
        .layout-table--long.layout-capacity--8::after {
            box-shadow:
                0 32px 0 #3a3833,
                0 64px 0 #3a3833,
                0 96px 0 #3a3833;
        }

        .layout-table--vertical.layout-capacity--4 {
            height: 68px;
            width: 50px;
        }
        .layout-table--vertical.layout-capacity--4::before,
        .layout-table--vertical.layout-capacity--4::after {
            box-shadow: 0 32px 0 #3a3833;
            top: 5px;
        }

        .layout-table--vertical.layout-capacity--6 {
            height: 112px;
            width: 64px;
        }

        .layout-table--vertical.layout-capacity--6::before,
        .layout-table--vertical.layout-capacity--6::after {
            box-shadow:
                0 34px 0 #3a3833,
                0 68px 0 #3a3833;
        }

        .layout-table--vertical.layout-capacity--8 {
            height: 138px;
            width: 64px;
        }

        .layout-table--vertical.layout-capacity--8::before,
        .layout-table--vertical.layout-capacity--8::after {
            box-shadow:
                0 32px 0 #3a3833,
                0 64px 0 #3a3833,
                0 96px 0 #3a3833;
        }

        .layout-table--horizontal.layout-capacity--2 {
            height: 48px;
            width: 54px;
        }

        .layout-table--horizontal.layout-capacity--2::before {
            box-shadow: 0 76px 0 #3a3833;
            left: 13px;
            top: -22px;
        }

        .layout-table--horizontal.layout-capacity--2::after {
            display: none;
        }

        .layout-table--vertical.layout-capacity--2 {
            height: 54px;
            width: 48px;
        }

        .layout-table--vertical.layout-capacity--2::before,
        .layout-table--vertical.layout-capacity--2::after {
            top: 14px;
        }

        .layout-table--horizontal.layout-capacity--6::before {
            box-shadow:
                43px 0 0 #3a3833,
                86px 0 0 #3a3833,
                0 96px 0 #3a3833,
                43px 96px 0 #3a3833,
                86px 96px 0 #3a3833;
            left: 10px;
        }

        .layout-table--horizontal.layout-capacity--8 {
            height: 64px;
            width: 164px;
        }

        .layout-table--horizontal.layout-capacity--8::before {
            box-shadow:
                40px 0 0 #3a3833,
                80px 0 0 #3a3833,
                120px 0 0 #3a3833,
                0 102px 0 #3a3833,
                40px 102px 0 #3a3833,
                80px 102px 0 #3a3833,
                120px 102px 0 #3a3833;
            left: 10px;
        }

        .layout-table.is-selected {
            background: linear-gradient(180deg, #e4c590, #caa66d);
            color: #0e0d0b;
        }

        .layout-table.is-selected small {
            color: #0e0d0b;
        }

        .layout-decor {
            position: absolute;
            pointer-events: none;
        }

        .layout-decor--counter-group {
            position: absolute;
            left: 14%;
            top: 80%;
            transform: translate(-50%, -50%);
            width: 120px;
            height: 186px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
            cursor: grab;
            user-select: none;
            pointer-events: auto;
        }

        .layout-decor--counter-group:active {
            cursor: grabbing;
        }

        .layout-decor--counter {
            align-items: center;
            background: #2b2a27;
            border-radius: 10px 10px 38px 10px;
            color: #e4c590;
            display: flex;
            font-size: 11px;
            font-weight: 800;
            height: 130px;
            justify-content: center;
            text-transform: uppercase;
            width: 86px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, .3), inset 0 0 0 1px rgba(228, 197, 144, .25);
            pointer-events: none;
        }

        .layout-decor--counter-wall {
            position: absolute;
            border: 2px dashed rgba(228, 197, 144, .4);
            width: 120px;
            height: 186px;
            pointer-events: none;
            border-radius: 8px;
            top: 0;
            left: 0;
        }

        .layout-decor--entrance {
            bottom: 0px;
            left: 14%;
            transform: translateX(-50%);
            background: #2b2a27;
            border: 1px solid rgba(228, 197, 144, .8);
            border-bottom: none;
            border-radius: 6px 6px 0 0;
            color: #e4c590;
            font-size: 11px;
            font-weight: bold;
            padding: 4px 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
            pointer-events: auto;
            cursor: grab;
            z-index: 3;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.5);
        }
    </style>

    <script>
        (() => {
            const floor = document.getElementById('layout-floor');
            const shapes = ['vertical', 'horizontal'];
            let dragged = null;
            let dragOffsetX = 0;
            let dragOffsetY = 0;

             // Load saved cashier position
            const cashierGroup = document.querySelector('.layout-decor--counter-group');
            if (cashierGroup) {
                const savedX = localStorage.getItem('cashier_x');
                const savedY = localStorage.getItem('cashier_y');
                if (savedX && savedY) {
                    cashierGroup.style.left = `${savedX}%`;
                    cashierGroup.style.top = `${savedY}%`;
                }

                cashierGroup.addEventListener('dragstart', (event) => {
                    dragged = cashierGroup;
                    event.dataTransfer.effectAllowed = 'move';
                    const rect = cashierGroup.getBoundingClientRect();
                    dragOffsetX = event.clientX - (rect.left + rect.width / 2);
                    dragOffsetY = event.clientY - (rect.top + rect.height / 2);
                });
            }

             // Load saved entrance position
            const entranceNode = document.querySelector('.layout-decor--entrance');
            if (entranceNode) {
                const savedX = localStorage.getItem('entrance_x');
                const savedY = localStorage.getItem('entrance_y');
                if (savedX && savedY) {
                    entranceNode.style.left = `${savedX}%`;
                    entranceNode.style.top = `${savedY}%`;
                    entranceNode.style.bottom = 'auto';
                    entranceNode.style.transform = 'translate(-50%, -50%)';
                }

                entranceNode.addEventListener('dragstart', (event) => {
                    dragged = entranceNode;
                    event.dataTransfer.effectAllowed = 'move';
                    const rect = entranceNode.getBoundingClientRect();
                    dragOffsetX = event.clientX - (rect.left + rect.width / 2);
                    dragOffsetY = event.clientY - (rect.top + rect.height / 2);
                });
            }

            const allowedShapes = (table) => {
                const capacity = Number(table.dataset.capacity || 0);

                return ['vertical', 'horizontal'];
            };

            const syncInputs = (table) => {
                const id = table.dataset.tableId;
                document.querySelector(`[data-x-for="${id}"]`).value = Math.round(parseFloat(table.style.left));
                document.querySelector(`[data-y-for="${id}"]`).value = Math.round(parseFloat(table.style.top));
                document.querySelector(`[data-shape-for="${id}"]`).value = table.dataset.shape;
            };

             const moveTable = (table, clientX, clientY) => {
                const rect = floor.getBoundingClientRect();
                const isEntrance = table.classList.contains('layout-decor--entrance');
                const isReceptionist = table.classList.contains('layout-decor--counter-group');
                
                let minX = 4, maxX = 96, minY = 6, maxY = 94;
                if (isEntrance) {
                    minX = 0; maxX = 100;
                    minY = 0; maxY = 100;
                } else if (isReceptionist) {
                    minX = 2; maxX = 98;
                    minY = 2; maxY = 98;
                }
                
                const targetX = clientX - dragOffsetX;
                const targetY = clientY - dragOffsetY;
                
                const x = Math.min(maxX, Math.max(minX, ((targetX - rect.left) / rect.width) * 100));
                const y = Math.min(maxY, Math.max(minY, ((targetY - rect.top) / rect.height) * 100));
                table.style.left = `${x}%`;
                table.style.top = `${y}%`;
                if (table.classList.contains('layout-decor--counter-group')) {
                    localStorage.setItem('cashier_x', Math.round(x));
                    localStorage.setItem('cashier_y', Math.round(y));
                } else if (table.classList.contains('layout-decor--entrance')) {
                    table.style.bottom = 'auto';
                    table.style.transform = 'translate(-50%, -50%)';
                    localStorage.setItem('entrance_x', Math.round(x));
                    localStorage.setItem('entrance_y', Math.round(y));
                } else {
                    syncInputs(table);
                }
            };

            document.querySelectorAll('.layout-table').forEach((table) => {
                table.addEventListener('dragstart', (event) => {
                    dragged = table;
                    event.dataTransfer.effectAllowed = 'move';
                    const rect = table.getBoundingClientRect();
                    dragOffsetX = event.clientX - (rect.left + rect.width / 2);
                    dragOffsetY = event.clientY - (rect.top + rect.height / 2);
                });

                table.addEventListener('click', () => {
                    document.querySelectorAll('.layout-table').forEach((item) => item.classList.remove('is-selected'));
                    table.classList.add('is-selected');
                    const options = allowedShapes(table);
                    const current = Math.max(0, options.indexOf(table.dataset.shape));
                    const next = options[(current + 1) % options.length];
                    shapes.forEach((shape) => table.classList.remove(`layout-table--${shape}`));
                    table.classList.add(`layout-table--${next}`);
                    table.dataset.shape = next;
                    syncInputs(table);
                });
            });

            document.querySelectorAll('.layout-list-item').forEach((item) => {
                item.addEventListener('dragstart', (event) => {
                    dragged = document.querySelector(`.layout-table[data-table-id="${item.dataset.tableId}"]`);
                    event.dataTransfer.effectAllowed = 'move';
                    dragOffsetX = 0;
                    dragOffsetY = 0;
                });

                item.addEventListener('click', () => {
                    const table = document.querySelector(`.layout-table[data-table-id="${item.dataset.tableId}"]`);
                    table?.scrollIntoView({ block: 'center', inline: 'center' });
                    table?.classList.add('is-selected');
                    setTimeout(() => table?.classList.remove('is-selected'), 900);
                });
            });

            floor.addEventListener('dragover', (event) => {
                event.preventDefault();
            });

            floor.addEventListener('drop', (event) => {
                event.preventDefault();
                if (! dragged) return;
                moveTable(dragged, event.clientX, event.clientY);
                dragged = null;
            });
        })();
    </script>
</x-admin-layout>
