# Modul 10: Struktur Project dan Cheatsheet Command Laravel + Filament

## Tujuan modul

Pada modul ini, kamu akan melihat isi project secara menyeluruh dari root sampai file-file fitur utamanya. Modul ini juga berisi cheatsheet command yang paling sering dipakai saat mengerjakan project Laravel dan Filament.

## Stack project ini

Berdasarkan isi `composer.json` dan `package.json`, project ini memakai:

- PHP 8.3+
- Laravel 13
- Filament 5
- Tailwind CSS 4
- Vite 8
- Axios

## Cara membaca struktur project ini

Secara sederhana, alurnya seperti ini:

1. Request masuk lewat `public/index.php`.
2. Laravel di-boot melalui `bootstrap/app.php`.
3. Provider didaftarkan di `bootstrap/providers.php`.
4. Filament memuat panel admin dan panel siswa dari provider masing-masing.
5. Konfigurasi auth dibaca dari `config/auth.php`.
6. Data inti dibangun oleh migration di folder `database/migrations`.
7. Model di folder `app/Models` menghubungkan tabel dan relasi.
8. Resource Filament di folder `app/Filament` membuat form, tabel, dan halaman admin maupun siswa.
9. View Blade, CSS, dan JavaScript berada di `resources`.
10. Asset hasil publish/build muncul di `public`.

## Struktur project dari awal sampai akhir

Berikut struktur project yang penting untuk dipahami. Folder dependency dan runtime tetap disebutkan, tetapi tidak diuraikan satu per satu karena isinya otomatis dibuat framework.

```text
AplikasiPengaduan/
|-- app/
|   |-- Filament/
|   |   |-- Resources/
|   |   |   |-- Kategoris/
|   |   |   |   |-- Pages/
|   |   |   |   |   |-- CreateKategori.php
|   |   |   |   |   |-- EditKategori.php
|   |   |   |   |   `-- ListKategoris.php
|   |   |   |   |-- Schemas/
|   |   |   |   |   `-- KategoriForm.php
|   |   |   |   |-- Tables/
|   |   |   |   |   `-- KategorisTable.php
|   |   |   |   `-- KategoriResource.php
|   |   |   |-- Kelas/
|   |   |   |   |-- Pages/
|   |   |   |   |   |-- CreateKelas.php
|   |   |   |   |   |-- EditKelas.php
|   |   |   |   |   `-- ListKelas.php
|   |   |   |   |-- Schemas/
|   |   |   |   |   `-- KelasForm.php
|   |   |   |   |-- Tables/
|   |   |   |   |   `-- KelasTable.php
|   |   |   |   `-- KelasResource.php
|   |   |   |-- Pengaduans/
|   |   |   |   |-- Pages/
|   |   |   |   |   |-- CreatePengaduan.php
|   |   |   |   |   |-- EditPengaduan.php
|   |   |   |   |   `-- ListPengaduans.php
|   |   |   |   |-- Tables/
|   |   |   |   |   `-- PengaduansTable.php
|   |   |   |   `-- PengaduanResource.php
|   |   |   `-- Siswas/
|   |   |       |-- Pages/
|   |   |       |   |-- CreateSiswa.php
|   |   |       |   |-- EditSiswa.php
|   |   |       |   `-- ListSiswas.php
|   |   |       |-- Schemas/
|   |   |       |   `-- SiswaForm.php
|   |   |       |-- Tables/
|   |   |       |   `-- SiswasTable.php
|   |   |       `-- SiswaResource.php
|   |   `-- Siswa/
|   |       |-- Pages/
|   |       |   `-- LoginSiswa.php
|   |       `-- Resources/
|   |           `-- Pengaduans/
|   |               |-- Pages/
|   |               |   |-- CreatePengaduan.php
|   |               |   |-- EditPengaduan.php
|   |               |   `-- ListPengaduans.php
|   |               |-- Schemas/
|   |               |   `-- PengaduanForm.php
|   |               |-- Tables/
|   |               |   `-- PengaduansTable.php
|   |               `-- PengaduanResource.php
|   |-- Http/
|   |   `-- Controllers/
|   |       `-- Controller.php
|   |-- Models/
|   |   |-- Kategori.php
|   |   |-- Kelas.php
|   |   |-- Pengaduan.php
|   |   |-- Siswa.php
|   |   `-- User.php
|   |-- Providers/
|   |   |-- Filament/
|   |   |   |-- AdminPanelProvider.php
|   |   |   `-- SiswaPanelProvider.php
|   |   `-- AppServiceProvider.php
|   `-- StatusPengaduan.php
|-- bootstrap/
|   |-- app.php
|   |-- providers.php
|   `-- cache/
|       `-- .gitignore
|-- config/
|   |-- app.php
|   |-- auth.php
|   |-- cache.php
|   |-- database.php
|   |-- filesystems.php
|   |-- logging.php
|   |-- mail.php
|   |-- queue.php
|   `-- session.php
|-- database/
|   |-- factories/
|   |   `-- UserFactory.php
|   |-- migrations/
|   |   |-- 0001_01_01_000000_create_users_table.php
|   |   |-- 0001_01_01_000001_create_cache_table.php
|   |   |-- 0001_01_01_000002_create_jobs_table.php
|   |   |-- 2026_03_28_013504_create_kategoris_table.php
|   |   |-- 2026_03_28_014150_create_kelas_table.php
|   |   |-- 2026_03_28_014239_create_siswas_table.php
|   |   |-- 2026_03_28_014244_create_pengaduans_table.php
|   |   `-- 2026_03_28_033742_set_user_id_to_nullable_in_pengaduan.php
|   `-- seeders/
|       `-- DatabaseSeeder.php
|-- docs/
|   `-- materi-ukk-pengaduan/
|       |-- 01-gambaran-proyek.md
|       |-- 02-persiapan-lingkungan.md
|       |-- 03-merancang-database.md
|       |-- 04-membuat-model-dan-relasi.md
|       |-- 05-membangun-panel-admin.md
|       |-- 06-mengelola-pengaduan-admin.md
|       |-- 07-membangun-login-dan-panel-siswa.md
|       |-- 08-membuat-fitur-pengaduan-siswa.md
|       |-- 09-pengujian-dan-penyelesaian.md
|       |-- 10-struktur-project-dan-cheatsheet-command.md
|       `-- README.md
|-- public/
|   |-- css/
|   |   `-- filament/...
|   |-- fonts/
|   |   `-- filament/...
|   |-- js/
|   |   `-- filament/...
|   |-- favicon.ico
|   |-- index.php
|   `-- robots.txt
|-- resources/
|   |-- css/
|   |   `-- app.css
|   |-- js/
|   |   |-- app.js
|   |   `-- bootstrap.js
|   `-- views/
|       |-- filament/
|       |   `-- siswa/
|       |       `-- pages/
|       |           `-- login-siswa.blade.php
|       `-- welcome.blade.php
|-- routes/
|   |-- console.php
|   `-- web.php
|-- storage/
|   `-- ...
|-- tests/
|   |-- Feature/
|   |   `-- ExampleTest.php
|   |-- Unit/
|   |   `-- ExampleTest.php
|   `-- TestCase.php
|-- vendor/
|   `-- ...
|-- .editorconfig
|-- .env
|-- .env.example
|-- .gitattributes
|-- .gitignore
|-- README.md
|-- artisan
|-- composer.json
|-- composer.lock
|-- package-lock.json
|-- package.json
|-- phpunit.xml
`-- vite.config.js
```

## Penjelasan fungsi folder dan file utama

### 1. Root project

- `artisan`: pintu masuk command Laravel, misalnya `php artisan migrate`.
- `composer.json`: daftar dependency PHP, autoload, dan script seperti `setup`, `dev`, dan `test`.
- `package.json`: dependency frontend dan script `npm run dev` serta `npm run build`.
- `.env`: konfigurasi environment project.
- `vite.config.js`: pengaturan bundler Vite untuk CSS dan JavaScript.
- `phpunit.xml`: konfigurasi pengujian.

### 2. Folder `bootstrap`

- `bootstrap/app.php`: pusat bootstrapping aplikasi Laravel 13.
- `bootstrap/providers.php`: daftar service provider yang dimuat, termasuk provider panel Filament admin dan siswa.
- `bootstrap/cache/`: file cache bootstrap.

### 3. Folder `config`

- `config/app.php`: konfigurasi umum aplikasi.
- `config/auth.php`: sangat penting di project ini karena ada 2 guard, yaitu `web` untuk admin dan `siswa` untuk panel siswa.
- `config/database.php`: koneksi database.
- `config/cache.php`, `queue.php`, `session.php`, `mail.php`, `logging.php`, `filesystems.php`: konfigurasi standar Laravel untuk cache, queue, session, email, log, dan storage.

### 4. Folder `database`

Folder ini menyusun bentuk data project.

- `create_kategoris_table`: membuat tabel kategori pengaduan.
- `create_kelas_table`: membuat tabel kelas.
- `create_siswas_table`: membuat tabel siswa dengan `nis`, `nama_siswa`, `id_kelas`, `password`, dan `remember_token`.
- `create_pengaduans_table`: membuat tabel pengaduan yang terhubung ke siswa, kategori, dan user admin.
- `set_user_id_to_nullable_in_pengaduan`: membuat `user_id` pada pengaduan boleh kosong, karena pengaduan baru belum tentu langsung ditangani admin.
- `DatabaseSeeder.php`: seed default untuk user admin contoh.
- `UserFactory.php`: factory untuk model user.

### 5. Folder `app/Models`

Folder ini mewakili tabel database dalam bentuk class Eloquent.

- `Kategori.php`: model kategori, punya relasi satu ke banyak ke pengaduan.
- `Kelas.php`: model kelas, punya relasi satu ke banyak ke siswa.
- `Siswa.php`: model akun siswa, memakai autentikasi sendiri dan bisa masuk panel Filament siswa.
- `Pengaduan.php`: model inti pengaduan, menyimpan tanggal, kategori, lokasi, keterangan, status, feedback, dan admin penangannya.
- `User.php`: model admin bawaan Laravel.

### 6. File enum `app/StatusPengaduan.php`

File ini menyimpan 3 status pengaduan:

- `menunggu`
- `proses`
- `selesai`

Enum ini juga memberi label, warna badge, dan icon untuk tampilan Filament.

### 7. Folder `app/Providers/Filament`

Folder ini sangat penting karena menentukan panel mana yang tersedia.

- `AdminPanelProvider.php`
  - path panel: `/admin`
  - login: bawaan Filament
  - resource yang dipakai: `app/Filament/Resources`

- `SiswaPanelProvider.php`
  - path panel: `/siswa`
  - login: `LoginSiswa`
  - auth guard: `siswa`
  - resource yang dipakai: `app/Filament/Siswa/Resources`

### 8. Folder `app/Filament/Resources`

Ini adalah panel admin.

- `Kategoris/`
  - `KategoriResource.php`: menghubungkan model kategori ke form, table, dan page.
  - `Schemas/KategoriForm.php`: form input kategori.
  - `Tables/KategorisTable.php`: tabel daftar kategori.
  - `Pages/`: halaman list, create, edit.

- `Kelas/`
  - `KelasResource.php`: resource untuk data kelas.
  - `Schemas/KelasForm.php`: form input kelas.
  - `Tables/KelasTable.php`: tabel daftar kelas.
  - `Pages/`: halaman list, create, edit.

- `Siswas/`
  - `SiswaResource.php`: resource untuk manajemen siswa.
  - `Schemas/SiswaForm.php`: form input NIS, nama siswa, kelas, password.
  - `Tables/SiswasTable.php`: tabel daftar siswa.
  - `Pages/`: halaman list, create, edit.

- `Pengaduans/`
  - `PengaduanResource.php`: resource admin untuk melihat pengaduan.
  - `Tables/PengaduansTable.php`: tabel pengaduan dan action `Review`.
  - `Pages/`: file create/edit/list ada, tetapi resource saat ini hanya mempublikasikan halaman `index` dan `canCreate()` dibuat `false`.

### 9. Folder `app/Filament/Siswa`

Ini adalah panel siswa.

- `Pages/LoginSiswa.php`: form login siswa memakai `nis` dan `password`.
- `Resources/Pengaduans/PengaduanResource.php`: resource siswa untuk membuat dan melihat pengaduan miliknya.
- `Resources/Pengaduans/Schemas/PengaduanForm.php`: form siswa untuk memilih kategori, mengisi lokasi, dan keterangan.
- `Resources/Pengaduans/Tables/PengaduansTable.php`: tabel riwayat pengaduan siswa.
- `Resources/Pengaduans/Pages/CreatePengaduan.php`: menambahkan `id_siswa`, `tanggal_pengaduan`, dan status awal `menunggu` secara otomatis.
- `Resources/Pengaduans/Pages/EditPengaduan.php`: halaman edit pengaduan.
- `Resources/Pengaduans/Pages/ListPengaduans.php`: daftar pengaduan siswa.

### 10. Folder `resources`

Ini adalah sumber frontend yang akan dibuild oleh Vite.

- `resources/css/app.css`: import Tailwind dan sumber scan class.
- `resources/js/app.js`: entry JavaScript.
- `resources/js/bootstrap.js`: setup Axios.
- `resources/views/welcome.blade.php`: halaman root `/`.
- `resources/views/filament/siswa/pages/login-siswa.blade.php`: view untuk halaman login siswa.

### 11. Folder `public`

Folder ini berisi file yang langsung diakses browser.

- `public/index.php`: front controller Laravel.
- `public/favicon.ico`, `public/robots.txt`: file publik standar.
- `public/css/filament`, `public/js/filament`, `public/fonts/filament`: asset hasil publish/build dari Filament.

### 12. Folder `routes`

- `routes/web.php`: route web utama. Saat ini root `/` menampilkan `welcome`.
- `routes/console.php`: contoh command console sederhana bawaan Laravel.

### 13. Folder `tests`

- `tests/TestCase.php`: base test case.
- `tests/Feature/ExampleTest.php`: contoh test fitur.
- `tests/Unit/ExampleTest.php`: contoh test unit.

### 14. Folder `docs`

Folder ini berisi materi belajar bertahap dari analisis sampai penyelesaian project. Modul ini ditambahkan sebagai panduan membaca codebase dan command sehari-hari.

## Ringkasan hubungan antar file inti

Supaya tidak bingung, lihat rantai hubungan file berikut:

1. `database/migrations` membuat tabel.
2. `app/Models` mewakili tabel dan relasi.
3. `config/auth.php` menentukan siapa yang login sebagai admin dan siapa yang login sebagai siswa.
4. `app/Providers/Filament/AdminPanelProvider.php` dan `SiswaPanelProvider.php` membuka panel Filament.
5. `app/Filament/...Resource.php` menghubungkan model ke form, table, dan page.
6. `Schemas/*.php` mengatur field form.
7. `Tables/*.php` mengatur kolom tabel dan action.
8. `Pages/*.php` mengatur perilaku halaman seperti create, edit, atau login.

## Cheatsheet command Laravel

Berikut command yang paling berguna untuk project seperti ini.

### Setup dan menjalankan project

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm run build
php artisan serve
```

Untuk repo ini, ada script yang lebih cepat:

```bash
composer setup
composer dev
composer test
```

Penjelasan singkat:

- `composer setup`: install dependency, membuat `.env` jika belum ada, generate key, migrate, install npm, lalu build asset.
- `composer dev`: menjalankan server Laravel, queue listener, log tail, dan Vite sekaligus.
- `composer test`: clear config lalu menjalankan test.

### Command harian Laravel

```bash
php artisan about
php artisan serve
php artisan route:list
php artisan migrate
php artisan migrate:status
php artisan migrate:rollback
php artisan migrate:refresh
php artisan migrate:fresh --seed
php artisan db:seed
php artisan db:show
php artisan db:table pengaduans
php artisan tinker
php artisan test
php artisan pail
php artisan optimize
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan storage:link
php artisan queue:listen
php artisan queue:work
```

### Command generator Laravel

```bash
php artisan make:model Kategori
php artisan make:model Pengaduan -m
php artisan make:controller PengaduanController
php artisan make:migration create_pengaduans_table
php artisan make:seeder PengaduanSeeder
php artisan make:factory PengaduanFactory
php artisan make:request StorePengaduanRequest
php artisan make:policy PengaduanPolicy
php artisan make:test PengaduanTest
php artisan make:middleware CheckRole
php artisan make:command SyncPengaduan
php artisan make:enum StatusPengaduan
```

## Cheatsheet command Filament

Command berikut memang tersedia di project ini berdasarkan `php artisan list --raw`.

### Install dan maintenance Filament

```bash
php artisan filament:install
php artisan filament:assets
php artisan filament:upgrade
php artisan filament:about
php artisan filament:optimize
php artisan filament:optimize-clear
php artisan filament:cache-components
php artisan filament:clear-cached-components
```

### Generator panel dan user Filament

```bash
php artisan make:filament-panel
php artisan make:filament-user
php artisan make:filament-theme
```

Biasanya dipakai untuk:

- membuat panel admin baru
- membuat panel siswa baru
- membuat user admin yang bisa login ke panel Filament
- menyiapkan theme panel

### Generator resource, page, form, dan table Filament

```bash
php artisan make:filament-resource Kategori
php artisan make:filament-page Laporan
php artisan make:filament-widget StatistikPengaduan
php artisan make:filament-form PengaduanForm
php artisan make:filament-table PengaduansTable
php artisan make:filament-schema PengaduanSchema
php artisan make:filament-livewire-table PengaduanTable
php artisan make:filament-livewire-form PengaduanForm
php artisan make:filament-relation-manager
php artisan make:filament-cluster
```

Contoh pemakaian di project ini:

- data master seperti kategori, kelas, dan siswa cocok dibuat dengan `make:filament-resource`
- halaman dashboard atau laporan cocok dibuat dengan `make:filament-page`
- statistik pengaduan cocok dibuat dengan `make:filament-widget`
- form dan tabel terpisah seperti pada project ini cocok dibuat dengan `make:filament-form` dan `make:filament-table`

### Generator komponen Filament lanjutan

```bash
php artisan make:filament-table-column
php artisan make:filament-form-field
php artisan make:filament-schema-component
php artisan make:filament-infolist-entry
php artisan make:filament-exporter
php artisan make:filament-importer
```

Ini dipakai saat project mulai lebih kompleks, misalnya:

- butuh kolom tabel custom
- butuh field form custom
- butuh export data pengaduan
- butuh import data siswa dari file

## Command yang paling relevan untuk project pengaduan ini

Kalau fokusmu hanya pada pengembangan project pengaduan sekolah ini, command yang paling sering dipakai biasanya:

```bash
composer dev
php artisan migrate
php artisan make:model Pengaduan -m
php artisan make:filament-resource Kategori
php artisan make:filament-resource Kelas
php artisan make:filament-resource Siswa
php artisan make:filament-resource Pengaduan
php artisan make:filament-panel
php artisan make:filament-user
php artisan test
```

## Tips membaca project ini dengan cepat

Kalau baru pertama kali membuka codebase ini, urutan terbaik membacanya adalah:

1. `composer.json`
2. `config/auth.php`
3. `database/migrations`
4. `app/Models`
5. `app/Providers/Filament`
6. `app/Filament/Resources`
7. `app/Filament/Siswa`
8. `resources/views`

Urutan ini akan membuatmu paham:

- siapa user-nya
- data apa saja yang disimpan
- panel mana yang tersedia
- fitur mana yang dikerjakan admin
- fitur mana yang dikerjakan siswa

## Ringkasan modul

Inti modul ini:

- struktur project Laravel harus dibaca dari root, lalu `bootstrap`, `config`, `database`, `app`, `resources`, dan `routes`
- project ini memakai dua panel Filament: admin dan siswa
- folder paling penting untuk fitur aplikasi ada di `app/Models`, `app/Providers/Filament`, dan `app/Filament`
- command harian paling penting ada di `php artisan`, `composer`, dan generator Filament

Setelah modul ini, kamu seharusnya lebih cepat mencari file, memahami alur project, dan tahu command mana yang perlu dijalankan saat mengembangkan aplikasi.

## Navigasi Modul

[⬅ Modul Sebelumnya: Pengujian dan Penyelesaian](./09-pengujian-dan-penyelesaian.md) | [Daftar Modul](./README.md)
