<x-guest-layout>
    <div class="back-top" title="Kembali ke atas">
        <ion-icon name="caret-up-outline"></ion-icon>
    </div>
    <section class="menu padding-2" id="menu">
        <h3 class="subtitle over-slider">Pilihan Spesial</h3>
        @forelse ($categories as $category)
            <h2 class="section-title over-slider">{{ $category->name }}</h2>
            <div class="menu-box over-slider">
            @forelse ($category->menus as $menu)
                <div class="menu-item">
                    <img src="{{ $menu->image_url }}" alt="{{ $menu->name }}">
                    <div class="menu__info">
                        <div class="menu__info-top">
                            <h2>{{ $menu->name }}</h2>
                            <span></span>
                            <h3>Rp{{ number_format($menu->price, 0, ',', '.') }}</h3>
                        </div>
                        <p>{{ $menu->description }}</p>
                    </div>
                </div>
            @empty
                <p class="paragraph over-slider">Menu untuk kategori ini belum tersedia.</p>
            @endforelse
            </div>
        @empty
            <p class="paragraph over-slider">Menu belum tersedia. Silakan tambahkan kategori dan menu melalui admin.</p>
        @endforelse

        <img src="/img/shape-5.png" width="921" height="1036" loading="lazy" alt="" class="shape shape-2">
        <img src="/img/shape-6.png" width="700" height="800" loading="lazy" alt="" class="shape shape-3">
    </section>
</x-guest-layout>
