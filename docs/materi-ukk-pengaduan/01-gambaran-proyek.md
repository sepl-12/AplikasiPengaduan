# Modul 1: Gambaran Proyek

## Tujuan modul

Pada modul ini, kamu akan memahami dulu aplikasi apa yang akan dibuat. Jangan langsung menulis kode sebelum tahu alur sistemnya.

## Masalah yang ingin diselesaikan

Di sekolah, sering ada kerusakan atau masalah pada sarana prasarana, misalnya:

- kursi rusak
- lampu kelas mati
- kipas angin tidak berfungsi
- papan tulis rusak
- pintu toilet bermasalah

Kalau laporan dilakukan secara lisan, biasanya:

- mudah lupa
- tidak terdokumentasi
- sulit dipantau progresnya

Karena itu kita membuat aplikasi pengaduan berbasis web.

## Aktor dalam aplikasi

Proyek ini punya 2 aktor utama:

### 1. Admin

Admin bertugas:

- login ke panel admin
- mengelola data kategori
- mengelola data kelas
- mengelola data siswa
- melihat semua pengaduan
- memberi status pengaduan
- memberi feedback atau tanggapan

### 2. Siswa

Siswa bertugas:

- login memakai NIS dan password
- membuat pengaduan
- mengubah pengaduan selama masih menunggu
- melihat status pengaduan
- melihat feedback dari admin

## Fitur utama aplikasi

Berdasarkan proyek ini, fitur utamanya adalah:

1. Manajemen kategori pengaduan
2. Manajemen kelas
3. Manajemen siswa
4. Login admin
5. Login siswa
6. Form pengaduan siswa
7. Review pengaduan oleh admin
8. Status pengaduan: `menunggu`, `proses`, `selesai`

## Struktur besar proyek

Proyek ini dibangun dengan pola berikut:

- database menyimpan semua data
- model Laravel mewakili tabel database
- Filament dipakai untuk membuat panel admin dan panel siswa
- resource Filament dipakai untuk membuat form dan tabel secara cepat

## Gambaran alur sistem

Berikut alurnya dalam bahasa sederhana:

1. Admin menyiapkan data master terlebih dahulu.
2. Admin memasukkan data kelas.
3. Admin memasukkan data kategori pengaduan.
4. Admin membuat akun siswa.
5. Siswa login ke panel khusus siswa.
6. Siswa mengirim pengaduan.
7. Pengaduan masuk ke panel admin.
8. Admin memberi status dan feedback.
9. Siswa membuka kembali panel siswa untuk melihat tanggapan.

## Data apa saja yang dibutuhkan?

Dari proyek ini, data yang dipakai adalah:

- kategori
- kelas
- siswa
- admin
- pengaduan

## Kenapa analisis ini penting?

Kalau kamu paham alurnya dari awal, maka saat membuat:

- tabel database
- model
- relasi
- form input
- login

kamu tidak akan bingung.

## Ringkasan modul

Inti modul ini:

- kita membuat aplikasi pengaduan sarana prasarana sekolah
- ada dua pengguna: admin dan siswa
- admin mengelola data dan menindaklanjuti pengaduan
- siswa mengirim pengaduan dan melihat hasil penanganannya

Setelah paham gambaran besarnya, lanjut ke modul 2 untuk menyiapkan lingkungan kerja.
