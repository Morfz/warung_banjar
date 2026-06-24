# 🍽️ Warung Banjar - Sistem Reservasi Restoran & Katalog Menu

Aplikasi sistem informasi restoran berbasis web yang dirancang khusus untuk mengelola **katalog menu**, **pemesanan meja (reservasi) interaktif**, dan **tata letak denah meja (floor plan layout manager)**. Dibuat menggunakan framework Laravel 12 modern, sistem ini mempermudah pelanggan memilih meja secara visual dan membantu pengelola restoran mengatur tata letak secara dinamis.

---

## 🌟 Fitur Lengkap Aplikasi

### 1. Halaman Publik & Pelanggan (Frontend)
- **Beranda Dinamis**: Menampilkan slider menu rekomendasi, testimoni pelanggan, dan keunggulan restoran.
- **Katalog Menu Makanan & Minuman**: Filter menu berdasarkan kategori secara rapi dengan gambar dan harga.
- **Form Reservasi Interaktif**:
  - **Sistem Cek Ketersediaan**: Pengguna memilih tanggal, jam, dan jumlah tamu terlebih dahulu untuk menyaring meja yang pas.
  - **Denah Lantai Restoran (Interactive Floor Plan)**: Peta tata letak meja restoran interaktif. Pelanggan dapat mengklik meja yang diinginkan secara langsung pada denah.
  - **Status Meja Real-time**: Meja yang sudah dipesan oleh orang lain pada waktu yang berdekatan akan otomatis diarsir redup (*disabled*) dan tidak dapat dipilih.

### 2. Aturan Reservasi Pintar (Validation Engine)
- **Interval Waktu**: Reservasi diatur berdasarkan interval **30 menit** (contoh: 10:30, 11:00, 11:30, 12:00, dst.).
- **Durasi Pemakaian Meja**: Setiap reservasi memiliki durasi pemakaian meja minimum **1 jam**.
- **Pencegahan Tumpang Tindih (Double Booking Prevention)**: Sistem otomatis memblokir meja jika terdapat reservasi aktif lain yang jadwalnya bertubrukan (rentang 1 jam sebelum hingga 1 jam sesudah waktu yang dipilih).

### 3. Admin Panel (Backend Management)
- **Dashboard Overview**: Ringkasan jumlah menu, kategori, meja, dan total reservasi aktif.
- **Manajemen Kategori**: Menambah, mengubah, dan menghapus kategori menu (disertai upload ikon/gambar).
- **Manajemen Menu**: Kelola hidangan makanan/minuman, deskripsi, harga, dan foto menu.
- **Manajemen Reservasi**: Admin dapat melihat, menambah baru, mengubah jadwal, atau membatalkan reservasi pelanggan.
- **Manajemen Meja**: Kelola daftarnya dan sesuaikan kapasitas meja.
- **Visual Table Layout Designer (Desainer Denah Meja)**: Fitur premium di mana admin dapat mengatur posisi X/Y koordinat meja, menentukan bentuk meja (vertikal/horizontal), serta kapasitas kursi secara visual pada grid peta restoran.

---

## 💻 Teknologi yang Digunakan

Sistem ini dibangun dengan stack teknologi modern berkinerja tinggi:

- **Backend (Server-side)**:
  - **Laravel 12.x** (Framework PHP modern terpopuler)
  - **PHP 8.2+** (Dengan performa eksekusi cepat)
  - **Eloquent ORM** (Manajemen database relasional yang kuat)
- **Frontend (Client-side)**:
  - **HTML5 & CSS3** (Custom style layout modern)
  - **TailwindCSS 3.x** (Utility-first CSS framework untuk tampilan admin)
  - **Alpine.js** (Framework JS minimalis untuk interaktivitas komponen)
  - **Vite 8.x** (Frontend tooling & asset bundler super cepat)
- **Database & Storage**:
  - **MySQL / MariaDB** (Untuk menyimpan relasi data)
  - **Laravel Local Filesystem Storage** (Untuk penyimpanan file gambar menu dan kategori)

---

## 🛠️ Panduan Lengkap Setup Proyek

Ikuti langkah-langkah di bawah ini untuk menjalankan aplikasi Warung Banjar di lingkungan lokal (*localhost*):

### Prerequisites (Prasyarat Sistem)
Sebelum memulai, pastikan perangkat Anda sudah terinstal:
- **PHP >= 8.2** (pastikan ekstensi `pdo_mysql`, `mbstring`, `openssl`, `xml`, dan `gd` aktif)
- **Composer** (Dependency manager PHP)
- **MySQL Server** (XAMPP, Laragon, atau MySQL installer)

---

### Langkah-Langkah Install:

#### 1. Persiapan Folder Proyek
Ekstrak atau buka direktori proyek `warungbanjar` pada terminal/command prompt Anda.

#### 2. Install Dependensi PHP
Jalankan Composer untuk menginstal semua package dan library Laravel yang diperlukan:
```bash
composer install
```

#### 3. Konfigurasi Environment File
Salin file konfigurasi `.env.example` menjadi `.env`:
```bash
# Untuk Linux / macOS
cp .env.example .env

# Untuk Windows (Command Prompt / PowerShell)
copy .env.example .env
```

#### 4. Generate Application Key
Jalankan perintah ini untuk membuat key enkripsi keamanan aplikasi Laravel:
```bash
php artisan key:generate
```

#### 5. Konfigurasi Database `.env`
Buka file `.env` yang baru dibuat menggunakan kode editor (VS Code, Notepad, dll.), lalu sesuaikan pengaturan database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=warung_banjar
DB_USERNAME=root
DB_PASSWORD=
```
*Catatan: Pastikan Anda sudah membuat database kosong bernama `warung_banjar` di phpMyAdmin / MySQL client sebelum lanjut.*

#### 6. Jalankan Migrasi & Database Seeder
Jalankan migrasi tabel beserta pengisian data dummy awal (seperti daftar admin default, kategori, menu, serta layout posisi meja restoran):
```bash
php artisan migrate --seed
```

#### 7. Buat Symbolic Link Storage
Agar file gambar menu dan kategori yang diupload lewat admin panel bisa diakses secara publik di browser, jalankan perintah:
```bash
php artisan storage:link
```

#### 8. Jalankan Server Pengembangan
Nyalakan server Laravel lokal dengan menjalankan perintah:
```bash
php artisan serve
```
Aplikasi kini dapat diakses melalui browser Anda di alamat: **`http://127.0.0.1:8000`**

---

## 🔑 Informasi Akun Akses Default

### Panel Admin
Untuk masuk ke panel pengelolaan admin, buka **`http://127.0.0.1:8000/login`** atau akses menu login, dan masukkan kredensial berikut:
- **Email:** `admin@gmail.com`
- **Password:** `password`

---

## 💾 Opsi Impor Data Lama (Opsional)
Jika Anda ingin menggunakan data persis seperti database sebelumnya, Anda bisa mengimpor file backup SQL yang sudah disediakan:
1. Buat database bernama `warung_banjar`.
2. Impor file **`warung_banjar.sql`** menggunakan phpMyAdmin atau MySQL command line.
3. Sesuaikan akun `.env` Anda ke database tersebut.


