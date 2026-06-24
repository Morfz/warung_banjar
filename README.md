# Warung Banjar

Aplikasi reservasi dan katalog menu restoran berbasis Laravel 12, Blade, Tailwind, dan Vite 8.

## Fitur utama

- Halaman publik untuk beranda, menu, tentang, kontak, dan reservasi meja.
- Admin panel untuk mengelola kategori, menu, meja, dan reservasi.
- Validasi reservasi agar meja tidak bentrok dalam slot satu jam.
- Seeder admin default untuk akses awal.

## Setup lokal

Kebutuhan minimum:

- PHP 8.2 atau lebih baru
- Composer
- Node.js 20.19 atau lebih baru
- MySQL/MariaDB atau SQLite untuk pengembangan lokal

1. Install dependency PHP dan JavaScript.

```bash
composer install
npm install
```

2. Salin env dan buat app key.

```bash
cp .env.example .env
php artisan key:generate
```

3. Atur koneksi database di `.env`, lalu jalankan migration dan seeder.

```bash
php artisan migrate --seed
php artisan storage:link
```

4. Jalankan server Laravel dan Vite.

```bash
php artisan serve
npm run dev
```

Admin default:

- Email: `admin@gmail.com`
- Password: `password`

## Data lama

File `warung_banjar.sql` disimpan sebagai backup database lama. Untuk setup baru, disarankan memakai migration dan seeder terlebih dahulu. Jika ingin memakai data lama, import SQL tersebut ke database yang sudah dikonfigurasi di `.env`.
