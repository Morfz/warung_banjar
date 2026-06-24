<x-guest-layout>
    <div class="back-top" title="Kembali ke atas">
        <ion-icon name="caret-up-outline"></ion-icon>
    </div>


    <!-- 
        SERVICE
    -->
    <section class="services padding-2" id="chefs">
        <h3 class="subtitle">Rasa yang Istimewa</h3>
        <h2 class="section-title">Kami Menawarkan yang Terbaik</h2>
        <p class="paragraph">Jaringan sosial terbaik adalah meja penuh dengan makanan enak dan dikelilingi oleh orang-orang yang Anda cintai. 
            Kami memasak dengan cinta agar Anda dapat makan dengan hati nurani.</p>
        <div class="services-box">
            @foreach ($categories as $category)
                <div class="service">
                    <picture>
                        <img src="{{ $category->image_url }}" alt="{{ $category->name }}">
                    </picture>
                    <h2>{{ $category->name }}</h2>
                    <button onclick="window.location.href='{{ route('menus.index') }}'">Lihat Menu</button>
                </div>
            @endforeach
        </div>
    </section>


    <!-- 
        ABOUT 
    -->
    <section class="about padding-2" id="about">
        <div class="about__info">
            <h3 class="subtitle">Cerita Kami</h3>
            <h2 class="section-title">Kisah dalam Setiap Rasa</h2>
            <p class="paragraph">Warung Banjar menghadirkan rasa rumahan khas Banjar dengan bahan segar, racikan rempah yang akrab,
                dan pelayanan hangat untuk makan keluarga, singgah santai, maupun acara bersama.</p>
            <h3 class="highlight">Pesan Melalui Telepon</h3>
            <strong>+62 812 3456 7890</strong>
            <button class="btn" data-text="Selengkapnya" onclick="window.location.href='{{ route('about.index') }}'">
                <span>Selengkapnya</span>
            </button>
        </div>
        <div class="about__image">
            <div class="badge">
                <img src="/img/badge-2.png" alt="Lencana Warung Banjar">
                <img src="/img/badge-2-bg.png" alt="Latar lencana Warung Banjar">
            </div>
            <picture>
                <img src="/img/about-abs-image.jpg" alt="About abs image">
            </picture>
        </div>
    </section>


    <!-- 
        SPECIAL DISH 
    -->
    <section class="special-dish">
        @if ($randomMenu)
            <div class="special__image">
                <img src="{{ $randomMenu->image_url }}" alt="Hidangan spesial {{ $randomMenu->name }}">
            </div>
            <div class="special__info">
                <img src="/img/badge-1.png" alt="Badge">
                <h2 class="subtitle">Hidangan Spesial</h2>
                <h1 class="section-title">{{ $randomMenu->name }}</h1>
                <p class="paragraph">{{ $randomMenu->description }}</p>
                <div class="price">
                    <span>Mulai dari</span>
                    <span>Rp{{ number_format($randomMenu->price, 0, ',', '.') }}</span>
                </div>
                <button class="btn" data-text="Lihat Semua Menu" onclick="window.location.href='{{ route('menus.index') }}'">
                    <span>Lihat Semua Menu</span>
                </button>
            </div>
        @endif
    </section>
    


    <!-- 
        MENU
    -->
    <section class="menu padding-2" id="menu">
        <h3 class="subtitle over-slider">Pilihan Spesial</h3>
        <h2 class="section-title over-slider">Menu Lezat</h2>
        <div class="menu-box over-slider">
            @if ($specials && $specials->menus->count() > 0)
                @foreach ($specials->menus as $menu)
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
                @endforeach
            @else
                <p class="paragraph">Menu spesial belum tersedia. Tambahkan kategori "Menu Spesial" dari halaman admin.</p>
            @endif
        </div>
    
        <button class="btn over-slider" data-text="Lihat Semua Menu" onclick="window.location.href='{{ route('menus.index') }}'">
            <span>Lihat Semua Menu</span>
        </button>
    
        <img src="/img/shape-5.png" width="921" height="1036" loading="lazy" alt="" class="shape shape-2">
        <img src="/img/shape-6.png" width="700" height="800" loading="lazy" alt="" class="shape shape-3">
    </section>
    


    <!-- 
        TESTIMONIALS
    -->
    <section class="testi padding-2" id="contact">
        <h2 class="section-title"><span>"</span>Saya ingin berterima kasih atas jamuan yang hangat.
            Rasa masakannya benar-benar mengingatkan pada rumah.</h2>
        <div class="testi__separator">
            <span></span><span></span><span></span>
        </div>
        <div class="avatar">
            <img src="/img/testi-avatar.jpg" alt="Foto pelanggan">
            <h3 class="subtitle">Majdi</h3>
        </div>
    </section>
</x-guest-layout>
