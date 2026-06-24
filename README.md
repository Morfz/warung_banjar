# Warung Banjar

Aplikasi reservasi meja dan katalog menu restoran berbasis Laravel 12, Blade, Tailwind, dan Vite 8.

## Fitur Utama

- **Halaman Publik**:
  - Beranda, katalog menu makanan/minuman, tentang kami, kontak, dan reservasi meja secara langsung.
- **Sistem Reservasi Meja Interaktif**:
  - Denah lantai restoran (Restaurant Floor Plan Map) interaktif untuk memilih meja yang diinginkan secara visual.
  - State meja real-time: Meja yang sudah dibooking dalam slot waktu tertentu akan otomatis terarsir redup (disabled).
- **Aturan Reservasi Pintar**:
  - Slot reservasi menggunakan interval per 30 menit (contoh: 10:30, 11:00, 11:30, dst.).
  - Durasi pemakaian meja minimum 1 jam. Sistem secara otomatis menonaktifkan meja yang bentrok dengan jadwal reservasi lain yang tumpang tindih.
- **Admin Panel**:
  - Pengelolaan Menu & Kategori makanan/minuman (beserta upload foto).
  - Pengelolaan Reservasi pelanggan.
  - Pengelolaan Meja & **Layout Desainer Meja** secara visual (bisa mengatur posisi X/Y, kapasitas, orientasi bentuk meja vertikal/horizontal langsung dari admin).
- **Seeder Admin Default** untuk akses cepat di lingkungan pengembangan.

## Setup Lokal

Kebutuhan minimum:
- PHP 8.2 atau lebih baru
- Composer
- Node.js 20.19 atau lebih baru
- MySQL/MariaDB

### Langkah Instalasi:

1. **Install Dependensi PHP & JavaScript**:
   ```bash
   composer install
   ```

2. **Salin Environment & Generate Key**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Konfigurasi Database & Jalankan Migrasi + Seeder**:
   Atur koneksi database di file `.env`, lalu jalankan:
   ```bash
   php artisan migrate --seed
   php artisan storage:link
   ```

4. **Jalankan Server Lokal**:
   ```bash
   php artisan serve
   ```

### Akun Admin Default:
- **Email:** `admin@gmail.com`
- **Password:** `password`

## Backup Data
File `warung_banjar.sql` disediakan sebagai backup database lama. Namun, disarankan menggunakan perintah `--seed` saat migrasi awal agar data dummy meja restoran dan layout denah default (`RestaurantDemoSeeder`) langsung terbuat dengan benar secara otomatis.

