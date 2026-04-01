# Modul 9: Pengujian, Presentasi, dan Penyelesaian Proyek

## Tujuan modul

Pada modul ini, kamu memastikan aplikasi benar-benar siap dipakai dan siap dipresentasikan saat ujian praktik.

## Kenapa pengujian itu penting?

Karena aplikasi yang terlihat selesai belum tentu benar-benar berjalan dengan baik.

Contoh masalah yang sering muncul:

- relasi tidak tampil
- login siswa gagal
- data tidak tersimpan
- status tidak berubah
- feedback tidak muncul

## Data uji yang perlu disiapkan

Sebelum menguji, siapkan:

- 1 akun admin
- beberapa data kelas
- beberapa data kategori
- beberapa akun siswa
- beberapa contoh pengaduan

## Skenario pengujian wajib

### 1. Uji login admin

Pastikan:

- admin bisa masuk ke `/admin`
- dashboard admin tampil

### 2. Uji data master

Pastikan admin bisa:

- menambah kategori
- menambah kelas
- menambah siswa
- mengedit data yang sudah ada

### 3. Uji login siswa

Pastikan:

- siswa bisa login ke `/siswa`
- login menggunakan NIS dan password

### 4. Uji pembuatan pengaduan

Pastikan:

- siswa bisa membuat laporan
- kategori tampil di select
- data lokasi dan keterangan tersimpan
- tanggal dibuat otomatis

### 5. Uji review admin

Pastikan:

- admin melihat pengaduan yang dibuat siswa
- admin bisa mengubah status
- admin bisa memberi feedback

### 6. Uji tampilan hasil pada siswa

Pastikan:

- siswa bisa melihat status terbaru
- siswa bisa melihat feedback admin
- nama admin penangan tampil bila ada

### 7. Uji aturan edit

Pastikan:

- pengaduan dengan status `menunggu` masih bisa diedit
- pengaduan dengan status `proses` atau `selesai` tidak bisa diedit

## Urutan demo saat presentasi

Kalau kamu harus mendemokan aplikasi, urutan aman yang disarankan:

1. Jelaskan masalah yang diselesaikan aplikasi
2. Tunjukkan struktur database secara singkat
3. Login sebagai admin
4. Tunjukkan data kategori, kelas, dan siswa
5. Logout lalu login sebagai siswa
6. Buat pengaduan baru
7. Logout siswa lalu login admin lagi
8. Review pengaduan dan ubah status
9. Login siswa lagi untuk melihat hasilnya

Urutan ini membuat penguji mudah memahami alur aplikasi.

## Bagian yang bisa kamu jelaskan sebagai nilai tambah

Jika ingin terlihat lebih paham, jelaskan juga:

- mengapa memakai dua panel
- mengapa siswa login dengan NIS
- mengapa status dibuat memakai enum
- mengapa `user_id` pada pengaduan perlu menyimpan admin penangan
- mengapa siswa hanya boleh edit saat status masih menunggu

## Ide pengembangan lanjutan

Kalau nanti ingin dikembangkan lebih jauh, kamu bisa menambahkan:

- upload foto kerusakan
- notifikasi saat pengaduan direview
- dashboard statistik pengaduan
- filter berdasarkan kategori atau status
- cetak laporan pengaduan

## Penutup

Kalau kamu sudah mengikuti semua modul dari 1 sampai 9, berarti kamu sudah memahami alur besar pembuatan aplikasi pengaduan sarana prasarana sekolah:

- mulai dari analisis kebutuhan
- membuat database
- membuat model dan relasi
- membuat panel admin
- membuat panel siswa
- membuat fitur pengaduan
- menguji aplikasi sampai siap dipresentasikan

Saran terakhir: coba ulangi pembuatan proyek ini sekali lagi dari awal tanpa terlalu bergantung pada materi. Di situlah biasanya pemahaman mulai benar-benar kuat.
