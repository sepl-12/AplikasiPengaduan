# Modul 3: Merancang Database

## Tujuan modul

Pada modul ini, kamu akan belajar menentukan tabel, kolom, dan hubungan antar data.

## Kenapa database harus dirancang dulu?

Karena semua fitur aplikasi bergantung pada data. Jika rancangan tabel berantakan, maka:

- form jadi membingungkan
- relasi sulit dibuat
- query data jadi salah

## Tabel yang dipakai dalam proyek ini

Proyek ini memakai tabel utama berikut:

1. `users`
2. `kategoris`
3. `kelas`
4. `siswas`
5. `pengaduans`

## Fungsi masing-masing tabel

### 1. Tabel `users`

Dipakai untuk akun admin.

Kolom penting:

- `id`
- `name`
- `email`
- `password`

### 2. Tabel `kategoris`

Dipakai untuk jenis pengaduan.

Contoh isi:

- Meja dan Kursi
- Listrik
- Toilet
- Kipas Angin

Kolom penting:

- `id`
- `nama_kategori`

### 3. Tabel `kelas`

Dipakai untuk menyimpan daftar kelas siswa.

Contoh isi:

- X RPL 1
- XI TKJ 2
- XII AKL 1

Kolom penting:

- `id`
- `nama_kelas`

### 4. Tabel `siswas`

Dipakai untuk akun siswa.

Kolom penting:

- `id`
- `nis`
- `nama_siswa`
- `id_kelas`
- `password`
- `remember_token`

### 5. Tabel `pengaduans`

Ini tabel inti aplikasi.

Kolom penting:

- `id`
- `tanggal_pengaduan`
- `id_siswa`
- `id_kategori`
- `lokasi`
- `keterangan`
- `status`
- `feedback`
- `user_id`

## Arti kolom penting pada tabel pengaduan

- `tanggal_pengaduan` menyimpan tanggal laporan dibuat
- `id_siswa` menunjukkan siapa yang melapor
- `id_kategori` menunjukkan jenis laporan
- `lokasi` menunjukkan tempat kerusakan
- `keterangan` berisi penjelasan masalah
- `status` berisi tahap penanganan
- `feedback` berisi tanggapan admin
- `user_id` berisi admin yang menangani

## Relasi antar tabel

Relasi dalam proyek ini:

1. Satu kelas punya banyak siswa
2. Satu siswa hanya berada di satu kelas
3. Satu kategori punya banyak pengaduan
4. Satu siswa bisa membuat banyak pengaduan
5. Satu admin bisa menangani banyak pengaduan

## Bentuk relasi sederhana

Kalau ditulis sederhana:

- `kelas -> siswas` adalah one to many
- `kategoris -> pengaduans` adalah one to many
- `siswas -> pengaduans` adalah one to many
- `users -> pengaduans` adalah one to many

## Membuat migration

Contoh perintah:

```bash
php artisan make:model Kategori -m
php artisan make:model Kelas -m
php artisan make:model Siswa -m
php artisan make:model Pengaduan -m
```

Setelah itu isi file migration sesuai kebutuhan tabel.

## Contoh kode migration dari proyek ini

Supaya lebih jelas, berikut isi migration inti yang dipakai pada proyek ini.

### Migration tabel `kategoris`

```php
Schema::create('kategoris', function (Blueprint $table) {
    $table->id();
    $table->string('nama_kategori');
    $table->timestamps();
});
```

Penjelasan:

- `id()` untuk primary key
- `nama_kategori` untuk nama jenis pengaduan
- `timestamps()` untuk `created_at` dan `updated_at`

### Migration tabel `kelas`

```php
Schema::create('kelas', function (Blueprint $table) {
    $table->id();
    $table->string('nama_kelas');
    $table->timestamps();
});
```

Penjelasan:

- tabel ini sederhana karena hanya menyimpan nama kelas

### Migration tabel `siswas`

```php
Schema::create('siswas', function (Blueprint $table) {
    $table->id();
    $table->string('nis')->unique();
    $table->string('nama_siswa');
    $table->foreignId('id_kelas')->constrained('kelas')->cascadeOnDelete();
    $table->string('password');
    $table->rememberToken();
    $table->timestamps();
});
```

Penjelasan:

- `nis` dibuat `unique()` agar tidak ada NIS ganda
- `id_kelas` menjadi foreign key ke tabel `kelas`
- `cascadeOnDelete()` berarti jika data kelas dihapus, data siswa terkait ikut terhapus
- `rememberToken()` dipakai untuk fitur login

### Migration tabel `pengaduans`

```php
Schema::create('pengaduans', function (Blueprint $table) {
    $table->id();
    $table->date('tanggal_pengaduan');
    $table->foreignId('id_siswa')->constrained('siswas')->cascadeOnDelete();
    $table->foreignId('id_kategori')->constrained('kategoris')->cascadeOnDelete();
    $table->string('lokasi');
    $table->text('keterangan');
    $table->enum('status', ['menunggu', 'proses', 'selesai'])->default('menunggu');
    $table->text('feedback')->nullable();
    $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
    $table->timestamps();
});
```

Penjelasan:

- `tanggal_pengaduan` menyimpan tanggal laporan
- `id_siswa` menghubungkan laporan ke siswa
- `id_kategori` menghubungkan laporan ke kategori
- `status` diberi default `menunggu`
- `feedback` boleh kosong karena admin belum tentu langsung membalas
- `user_id` menghubungkan laporan ke admin yang menangani

### Migration tambahan untuk `user_id` nullable

Pada proyek ini, ada migration lanjutan karena pengaduan baru dibuat siswa lebih dulu, sementara admin belum langsung menangani. Karena itu `user_id` diubah menjadi nullable.

```php
Schema::table('pengaduans', function (Blueprint $table) {
    $table->unsignedBigInteger('user_id')->nullable()->change();
});
```

Penjelasan:

- saat pengaduan baru dibuat, kolom `user_id` masih boleh kosong
- setelah admin mereview pengaduan, barulah `user_id` diisi

## Urutan berpikir saat membuat migration

Supaya tidak bingung, gunakan urutan berpikir ini:

1. Tentukan dulu tabel apa saja yang dibutuhkan.
2. Isi kolom utama setiap tabel.
3. Tentukan tabel mana yang menjadi induk dan mana yang menjadi anak.
4. Tambahkan foreign key setelah hubungan datanya jelas.
5. Tentukan kolom mana yang wajib diisi dan mana yang boleh kosong.

## Hal penting saat membuat migration

Perhatikan:

- nama tabel
- tipe data kolom
- kolom unik seperti `nis`
- foreign key
- nullable atau tidak
- nilai default

## Contoh keputusan penting dalam proyek ini

Beberapa keputusan yang dipakai:

- `nis` dibuat unik agar tidak ada siswa dengan NIS sama
- `status` diberi nilai awal `menunggu`
- `feedback` boleh kosong karena admin belum tentu langsung membalas
- `user_id` akhirnya dibuat nullable karena pengaduan baru belum ditangani admin

## Checkpoint

Sebelum lanjut:

- kamu tahu fungsi setiap tabel
- kamu tahu relasi antar tabel
- kamu paham kenapa `pengaduans` menjadi tabel utama

Setelah struktur data siap, lanjut ke modul 4 untuk membuat model dan relasi Eloquent.
