# Materi Belajar UKK: Aplikasi Pengaduan Sarana Prasarana Sekolah

Materi ini disusun berdasarkan proyek Laravel + Filament yang ada di repository ini. Tujuannya adalah membantu pemula memahami cara membuat aplikasi pengaduan sekolah dari nol sampai selesai dengan urutan yang rapi.

## Tujuan materi

Setelah mempelajari materi ini, pembaca diharapkan bisa:

- memahami alur pembuatan aplikasi pengaduan sarana prasarana sekolah
- mengetahui urutan kerja dari analisis sampai pengujian
- membaca kode asli proyek, bukan hanya teori
- membangun ulang aplikasi dengan langkah yang lebih terarah

## Untuk siapa materi ini?

Materi ini cocok untuk:

- siswa yang sedang menyiapkan ujian praktik
- pemula yang baru belajar Laravel
- pembaca yang ingin memahami proyek ini langkah demi langkah

## Teknologi yang digunakan proyek

Proyek ini memakai:

- PHP 8.3+
- Laravel 13
- Filament 5
- MySQL
- Vite

## Hasil akhir aplikasi

Aplikasi yang dibuat memiliki dua bagian utama:

- panel admin untuk mengelola data kelas, kategori, siswa, dan meninjau pengaduan
- panel siswa untuk login memakai NIS lalu mengirim pengaduan sarana prasarana

Alur kerjanya:

1. Admin mengisi data master seperti kelas, kategori, dan akun siswa.
2. Siswa login ke panel siswa memakai NIS dan password.
3. Siswa membuat pengaduan baru.
4. Admin meninjau pengaduan, mengubah status, lalu memberi feedback.
5. Siswa melihat hasil tanggapan dari admin.

## Urutan belajar yang disarankan

Baca modul secara berurutan:

1. [01-gambaran-proyek.md](./01-gambaran-proyek.md)
2. [02-persiapan-lingkungan.md](./02-persiapan-lingkungan.md)
3. [03-merancang-database.md](./03-merancang-database.md)
4. [04-membuat-model-dan-relasi.md](./04-membuat-model-dan-relasi.md)
5. [05-membangun-panel-admin.md](./05-membangun-panel-admin.md)
6. [06-mengelola-pengaduan-admin.md](./06-mengelola-pengaduan-admin.md)
7. [07-membangun-login-dan-panel-siswa.md](./07-membangun-login-dan-panel-siswa.md)
8. [08-membuat-fitur-pengaduan-siswa.md](./08-membuat-fitur-pengaduan-siswa.md)
9. [09-pengujian-dan-penyelesaian.md](./09-pengujian-dan-penyelesaian.md)
10. [10-struktur-project-dan-cheatsheet-command.md](./10-struktur-project-dan-cheatsheet-command.md)

## Urutan implementasi yang harus dikerjakan

Jika pembaca ingin langsung praktik membuat aplikasi, pakai urutan kerja ini:

1. Pahami dulu gambaran sistem dan fitur yang dibutuhkan.
2. Siapkan Laravel, database, Filament, dan environment proyek.
3. Buat migration tabel: kategori, kelas, siswa, dan pengaduan.
4. Buat model dan relasi Eloquent.
5. Buat enum status pengaduan.
6. Buat panel admin.
7. Buat resource admin untuk kategori, kelas, dan siswa.
8. Buat resource pengaduan admin dan aksi review.
9. Siapkan autentikasi siswa di `config/auth.php`.
10. Buat panel siswa dan login custom dengan NIS.
11. Buat resource pengaduan siswa.
12. Tambahkan logika otomatis saat siswa membuat pengaduan.
13. Uji alur siswa dan admin sampai selesai.

## Isi tiap modul

- Modul 1 menjelaskan masalah, aktor, fitur, dan alur sistem.
- Modul 2 berisi persiapan alat, instalasi, dan struktur folder penting.
- Modul 3 berisi rancangan tabel dan kode migration lengkap.
- Modul 4 berisi kode lengkap model dan enum status.
- Modul 5 berisi kode lengkap panel admin dan resource data master.
- Modul 6 berisi kode lengkap pengaduan admin dan aksi review.
- Modul 7 berisi konfigurasi login siswa, guard, panel siswa, dan login custom.
- Modul 8 berisi kode lengkap resource pengaduan siswa.
- Modul 9 berisi skenario pengujian, demo, dan penutupan proyek.
- Modul 10 berisi struktur project dan cheatsheet command Laravel + Filament.

## Cara menggunakan materi ini

- Ikuti satu modul sampai selesai sebelum pindah ke modul berikutnya.
- Jalankan aplikasi sambil praktik, jangan hanya dibaca.
- Jika ada istilah yang belum paham, fokus dulu pada tujuan langkahnya.
- Setelah semua modul selesai, ulangi sekali lagi tanpa melihat materi terlalu sering.

## Format materi

Materi ini disusun dalam beberapa file Markdown agar:

- lebih ringan dibaca
- mudah dibagi per pertemuan
- mudah direvisi per modul
- mudah digabung lagi jika ingin dijadikan dokumen cetak

## Catatan penting

Materi ini mengikuti struktur proyek saat ini. Beberapa bagian bisa dikembangkan lagi, tetapi untuk kebutuhan belajar dan ujian praktik, urutan ini sudah cukup aman dan realistis.
