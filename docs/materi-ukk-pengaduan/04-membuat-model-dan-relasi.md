# Modul 4: Membuat Model, Relasi, dan Enum Status

## Tujuan modul

Pada modul ini, kamu akan menghubungkan tabel database dengan kode Laravel melalui model.

## Apa itu model?

Model adalah representasi tabel database di Laravel.

Contoh:

- model `Kategori` mewakili tabel `kategoris`
- model `Kelas` mewakili tabel `kelas`
- model `Siswa` mewakili tabel `siswas`
- model `Pengaduan` mewakili tabel `pengaduans`

## Model yang dibuat dalam proyek ini

Model utama:

- `App\Models\Kategori`
- `App\Models\Kelas`
- `App\Models\Siswa`
- `App\Models\Pengaduan`
- `App\Models\User`

## Mengisi field yang boleh disimpan

Di proyek ini, model memakai atribut `Fillable`.

Tujuannya agar Laravel tahu field mana yang boleh diisi melalui mass assignment.

Contohnya:

- `Kategori` mengizinkan `nama_kategori`
- `Kelas` mengizinkan `nama_kelas`
- `Siswa` mengizinkan `nis`, `nama_siswa`, `id_kelas`, `password`
- `Pengaduan` mengizinkan field laporan seperti tanggal, kategori, lokasi, status, feedback, dan admin

## Kode lengkap model `Kategori`

Berikut isi file `app/Models/Kategori.php`:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama_kategori'])]
class Kategori extends Model
{
    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class);
    }
}
```

Penjelasan:

- model ini mewakili tabel `kategoris`
- field yang boleh diisi adalah `nama_kategori`
- satu kategori bisa dipakai oleh banyak data pengaduan

## Kode lengkap model `Kelas`

Berikut isi file `app/Models/Kelas.php`:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama_kelas'])]
class Kelas extends Model
{
    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }
}
```

Penjelasan:

- model ini mewakili tabel `kelas`
- field yang boleh diisi adalah `nama_kelas`
- satu kelas bisa memiliki banyak siswa

## Kode lengkap model `Siswa`

Berikut isi file `app/Models/Siswa.php`:

```php
<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Console\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

#[Fillable(['nis', 'nama_siswa', 'id_kelas', 'password'])]
#[Hidden(['password', 'remember_token'])]
class Siswa extends Authenticatable implements FilamentUser
{
    protected function casts()
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function getNameAttribute()
    {
        return $this->nama_siswa;
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id');
    }

    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
```

Penjelasan:

- belongs to kelas
- has many pengaduan
- extends `Authenticatable` karena siswa harus bisa login
- implements `FilamentUser` karena siswa akan masuk ke panel Filament
- `casts()` dipakai agar password otomatis di-hash
- `getNameAttribute()` dipakai agar Filament mengenali nama siswa
- `canAccessPanel()` memberi izin siswa masuk ke panel

## Kode lengkap model `Pengaduan`

Berikut isi file `app/Models/Pengaduan.php`:

```php
<?php

namespace App\Models;

use App\StatusPengaduan;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['tanggal_pengaduan', 'id_siswa', 'id_kategori', 'lokasi', 'keterangan', 'status', 'feedback', 'user_id'])]
class Pengaduan extends Model
{
    protected function casts()
    {
        return [
            'tanggal_pengaduan' => 'date',
            'status' => StatusPengaduan::class,
        ];
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
```

Penjelasan:

- siapa siswa yang melapor
- masuk kategori apa
- ditangani admin siapa
- field `tanggal_pengaduan` di-cast sebagai `date`
- field `status` di-cast ke enum `StatusPengaduan`

## Kode lengkap model `User`

Berikut isi file `app/Models/User.php`:

```php
<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class);
    }
}
```

Penjelasan:

- model `User` dipakai untuk admin
- admin bisa menangani banyak pengaduan
- password admin juga otomatis di-hash

## Mengapa model `Siswa` tidak memakai `Model` biasa?

Karena siswa harus bisa login ke panel Filament. Oleh sebab itu model `Siswa` memakai:

```php
extends Authenticatable
```

Selain itu, model ini juga mengimplementasikan:

```php
implements FilamentUser
```

Tujuannya agar siswa bisa masuk ke panel Filament miliknya.

## Membuat enum status pengaduan

Proyek ini memakai enum `StatusPengaduan`.

Nilainya:

- `menunggu`
- `proses`
- `selesai`

Kenapa enum bagus?

- nilai status jadi konsisten
- lebih aman daripada string biasa
- mudah ditampilkan sebagai badge di Filament

Enum ini juga mengatur:

- label status
- warna badge
- ikon

## Kode lengkap enum `StatusPengaduan`

Berikut isi file `app/StatusPengaduan.php`:

```php
<?php

namespace App;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum StatusPengaduan: string implements HasLabel, HasColor, HasIcon
{
    case MENUNGGU = 'menunggu';
    case PROSES = 'proses';
    case SELESAI = 'selesai';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::MENUNGGU => 'Menunggu',
            self::PROSES => 'Proses',
            self::SELESAI => 'Selesai',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::MENUNGGU => 'warning',
            self::PROSES => 'info',
            self::SELESAI => 'success',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::MENUNGGU => 'heroicon-o-clock',
            self::PROSES => 'heroicon-o-clock',
            self::SELESAI => 'heroicon-o-check-circle',
        };
    }
}
```

Penjelasan:

- `MENUNGGU`, `PROSES`, dan `SELESAI` adalah nilai status yang sah
- `getLabel()` menentukan teks yang tampil
- `getColor()` menentukan warna badge di Filament
- `getIcon()` menentukan ikon status

## Cast enum pada model `Pengaduan`

Pada model `Pengaduan`, field `status` di-cast ke enum:

```php
'status' => StatusPengaduan::class
```

Artinya, saat mengambil data dari database, Laravel langsung menganggap `status` sebagai enum, bukan sekadar teks.

## Checkpoint

Setelah modul ini, kamu harus paham:

- fungsi model
- cara membuat relasi `hasMany` dan `belongsTo`
- kenapa model `Siswa` bisa dipakai login
- kenapa enum dipakai untuk status pengaduan
- bentuk kode lengkap setiap model di proyek ini

Setelah model siap, lanjut ke modul 5 untuk membuat panel admin dan data master.

## Navigasi Modul

[⬅ Modul Sebelumnya: Merancang Database](./03-merancang-database.md) | [Daftar Modul](./README.md) | [Modul Berikutnya: Panel Admin ➜](./05-membangun-panel-admin.md)
