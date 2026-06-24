<x-guest-layout>
    <section class="reservation reservation-panel reservation-check">
        <form method="POST" action="{{ route('reservations.lookup') }}">
            @csrf
            <h2 class="section-title">Cek Reservasi</h2>
            <p class="paragraph">Masukkan email dan nomor telepon yang digunakan saat membuat reservasi.</p>
            @if ($errors->any())
                <div class="form-errors">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <div class="inputs reservation-check__inputs">
                <div>
                    <input class="input-field" type="email" value="{{ old('email', $email ?? '') }}" name="email" placeholder="Email" autocomplete="email" required>
                    <input class="input-field" type="tel" value="{{ old('phone', $phone ?? '') }}" name="phone" placeholder="Nomor Telepon" autocomplete="tel" required>
                </div>
                <button class="btn btn-secondary" type="submit" data-text="Lihat Detail">
                    <span>Lihat Reservasi</span>
                </button>
            </div>
        </form>
    </section>

    @if ($searched)
        <section class="reservation-results padding-2">
            <h2 class="section-title">Reservasi Anda</h2>
            @forelse ($reservations as $reservation)
                <article class="reservation-result">
                    <div>
                        <p class="reservation-result__label">Nama</p>
                        <h3>{{ $reservation->name }}</h3>
                    </div>
                    <div>
                        <p class="reservation-result__label">Tanggal</p>
                        <h3>{{ $reservation->date->format('d M Y, H:i') }} WITA</h3>
                    </div>
                    <div>
                        <p class="reservation-result__label">Jumlah Tamu</p>
                        <h3>{{ $reservation->guests }} tamu</h3>
                    </div>
                    <div>
                        <p class="reservation-result__label">Meja</p>
                        <h3>{{ $reservation->table?->name ?? 'Belum tersedia' }}</h3>
                    </div>
                    <div>
                        <p class="reservation-result__label">Status</p>
                        <h3>
                            <span class="reservation-status {{ $reservation->status->publicBadgeClasses() }}">
                                {{ $reservation->status->label() }}
                            </span>
                        </h3>
                    </div>
                </article>
            @empty
                <div class="empty-state">
                    <h3>Reservasi tidak ditemukan</h3>
                    <p>Pastikan email dan nomor telepon sama persis dengan data saat memesan.</p>
                </div>
            @endforelse
        </section>
    @endif
</x-guest-layout>
