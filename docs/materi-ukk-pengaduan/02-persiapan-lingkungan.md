# Modul 2: Persiapan Lingkungan dan Pembuatan Proyek

## Tujuan modul

Pada modul ini, kamu menyiapkan semua kebutuhan supaya proyek bisa dibuat dan dijalankan.

## Perangkat yang dibutuhkan

Siapkan:

- PHP 8.3 atau lebih baru
- Composer
- Node.js dan npm
- MySQL
- code editor, misalnya VS Code

## Membuat proyek Laravel baru

Jika ingin membuat proyek dari nol, jalankan:

```bash
composer create-project laravel/laravel aplikasi-pengaduan
cd aplikasi-pengaduan
```

## Menginstal Filament

Proyek ini memakai Filament 5. Instal dengan:

```bash
composer require filament/filament
php artisan filament:install --panels
```

Penjelasan:

- `composer require filament/filament` untuk memasang package Filament
- `php artisan filament:install --panels` untuk menyiapkan sistem panel

## Menginstal dependensi frontend

Jalankan:

```bash
npm install
```

<!-- Proyek ini memakai Vite untuk asset frontend.

## Mengatur file environment

Salin file `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

Lalu generate key aplikasi:

```bash
php artisan key:generate
``` -->

## Mengatur koneksi database

Di proyek ini, contoh `.env` menggunakan MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=aplikasipengaduan
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan dengan database di komputermu.

## Menjalankan migrasi awal

Jalankan:

```bash
php artisan migrate
```

Perintah ini akan membuat tabel bawaan Laravel seperti:

- users
- jobs
- cache

## Menjalankan server

```bash
php artisan serve
```


## Struktur folder penting yang harus kamu kenal

Beberapa folder utama dalam proyek ini:

- `app/Models` untuk model
- `app/Providers/Filament` untuk konfigurasi panel
- `app/Filament` untuk resource, form, table, dan page Filament
- `database/migrations` untuk struktur tabel
- `routes` untuk route
- `resources/views` untuk tampilan Blade

## Kenapa modul ini penting?

Banyak pemula gagal bukan karena logika programnya salah, tetapi karena:

- PHP belum terpasang
- Composer belum jalan
- database belum dibuat
- `.env` belum benar
- migrasi belum dijalankan

Jadi pastikan tahap ini benar dulu.

## Checkpoint

Sebelum lanjut ke modul berikutnya, pastikan:

- Laravel bisa dijalankan
- MySQL aktif
- file `.env` sudah benar
- migrasi berhasil
- halaman awal Laravel bisa dibuka

Jika semua sudah siap, lanjut ke modul 3 untuk merancang database.

## Navigasi Modul

[⬅ Modul Sebelumnya: Gambaran Proyek](./01-gambaran-proyek.md) | [Daftar Modul](./README.md) | [Modul Berikutnya: Merancang Database ➜](./03-merancang-database.md)
