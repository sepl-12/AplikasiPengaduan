# Modul 7: Membangun Login dan Panel Siswa

## Tujuan modul

Pada modul ini, kamu membuat panel khusus siswa yang terpisah dari panel admin.

## Urutan kerja yang benar

Bagian siswa sebaiknya dikerjakan dengan urutan berikut:

1. Pastikan model `Siswa` sudah bisa dipakai login.
2. Tambahkan guard dan provider siswa di `config/auth.php`.
3. Buat dan atur `SiswaPanelProvider`.
4. Buat halaman login custom `LoginSiswa`.
5. Coba login ke panel siswa.

Jangan langsung membuat resource pengaduan siswa sebelum login siswa beres. Kalau login belum benar, fitur pengaduan nanti ikut bermasalah.

## Kenapa siswa butuh panel sendiri?

Karena kebutuhan siswa berbeda dengan admin.

Siswa hanya perlu:

- login
- membuat pengaduan
- melihat status pengaduan
- mengedit pengaduan tertentu

Siswa tidak perlu mengakses data master seperti kelas atau kategori.

## Membuat panel siswa

Di proyek ini ada provider:

- `app/Providers/Filament/SiswaPanelProvider.php`

Pengaturan pentingnya:

- id panel: `siswa`
- path URL: `/siswa`
- login memakai halaman custom
- guard yang dipakai: `siswa`

## Kenapa perlu guard `siswa`?

Karena aplikasi punya dua jenis login:

- admin login memakai guard `web`
- siswa login memakai guard `siswa`

Kalau hanya memakai satu guard, sistem akan sulit membedakan akun admin dan siswa.

## Konfigurasi guard di `config/auth.php`

Pada proyek ini dibuat:

- guard `siswa`
- provider `siswas`

Provider `siswas` diarahkan ke model:

```php
App\Models\Siswa
```

Artinya, saat siswa login, Laravel akan mengecek data pada tabel `siswas`.

## Kode lengkap `config/auth.php`

Bagian yang paling penting untuk login siswa ada pada file `config/auth.php`.

Berikut isi file tersebut:

```php
<?php

use App\Models\Siswa;
use App\Models\User;

return [

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'siswa' => [
            'driver' => 'session',
            'provider' => 'siswas',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', User::class),
        ],

        'siswas' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', Siswa::class),
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
```

Penjelasan:

- `guards.web` dipakai untuk admin
- `guards.siswa` dipakai untuk siswa
- `providers.siswas` diarahkan ke model `Siswa`
- inilah yang membuat Laravel tahu bahwa login siswa harus mengecek tabel `siswas`

## Membuat model siswa agar bisa login

Supaya siswa bisa login, model `Siswa` harus:

- extends `Authenticatable`
- implements `FilamentUser`

Lalu dibuat method:

```php
public function canAccessPanel(Panel $panel): bool
{
    return true;
}
```

Method ini memberi izin agar siswa bisa masuk ke panelnya.

Bagian ini sudah dibahas pada modul model, jadi di tahap ini pastikan model `Siswa` memang sudah siap.

## Membuat halaman login siswa

Proyek ini memakai class login custom:

- `app/Filament/Siswa/Pages/LoginSiswa.php`

Hal yang diubah:

- field login memakai `nis`
- bukan email
- password tetap dipakai

## Kode lengkap `SiswaPanelProvider`

Command generator file ini:

```bash
php artisan filament:make-panel siswa
```

Berikut isi file `app/Providers/Filament/SiswaPanelProvider.php`:

```php
<?php

namespace App\Providers\Filament;

use App\Filament\Siswa\Pages\LoginSiswa;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class SiswaPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('siswa')
            ->path('siswa')
            ->login(LoginSiswa::class)
            ->authGuard('siswa')
            ->colors([
                'primary' => Color::Blue,
            ])
            ->discoverResources(in: app_path('Filament/Siswa/Resources'), for: 'App\Filament\Siswa\Resources')
            ->discoverPages(in: app_path('Filament/Siswa/Pages'), for: 'App\Filament\Siswa\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Siswa/Widgets'), for: 'App\Filament\Siswa\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
```

Penjelasan:

- `->id('siswa')` memberi identitas panel siswa
- `->path('siswa')` membuat URL panel menjadi `/siswa`
- `->login(LoginSiswa::class)` memerintahkan Filament memakai halaman login custom
- `->authGuard('siswa')` sangat penting karena panel ini harus memakai guard siswa, bukan guard admin
- resource siswa akan dibaca dari folder `app/Filament/Siswa/Resources`

## Kode lengkap `LoginSiswa`

Command generator file ini:

```bash
php artisan filament:make-page LoginSiswa --panel=siswa
```

Catatan:

- command di atas membuat file page dasar
- setelah itu class perlu disesuaikan manual agar mewarisi `Filament\Auth\Pages\Login`
- field login juga perlu diubah agar memakai `nis`

Berikut isi file `app/Filament/Siswa/Pages/LoginSiswa.php`:

```php
<?php

namespace App\Filament\Siswa\Pages;

use Filament\Auth\Pages\Login;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Validation\ValidationException;

class LoginSiswa extends Login
{
    public function form(Schema $schema): Schema
    {
        return $schema->components([
            $this->getNisFormComponent(),
            $this->getPasswordFormComponent(),
            $this->getRememberFormComponent()
        ]);
    }

    protected function getNisFormComponent()
    {
        return TextInput::make('nis')
            ->label('NIS (Nomor Induk Siswa)')
            ->required()
            ->autocomplete('nis')
            ->autofocus()
            ->placeholder('Masukkan NIS Anda, contoh: 2023001')
            ->extraInputAttributes(['tabindex' => 1]);
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'nis'      => $data['nis'],
            'password' => $data['password'],
        ];
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.login' => __('filament-panels::auth/pages/login.messages.failed'),
        ]);
    }
}
```

Penjelasan:

- class ini mewarisi login bawaan Filament
- form login diganti agar memakai input `nis`
- `getCredentialsFromFormData()` menentukan bahwa login siswa memakai `nis` dan `password`
- kalau login gagal, method `throwFailureValidationException()` akan menampilkan pesan error

## Kenapa login siswa memakai NIS?

Karena untuk data sekolah, NIS lebih cocok daripada email.

Manfaatnya:

- lebih mudah diingat siswa
- sesuai data sekolah
- lebih realistis untuk aplikasi akademik

## Cara kerja login siswa

Pada halaman login custom, data login dibaca seperti ini:

- `nis`
- `password`

Kemudian sistem membuat credential:

```php
[
    'nis' => $data['nis'],
    'password' => $data['password'],
]
```

Dengan begitu, autentikasi siswa berjalan berdasarkan NIS.

## Ringkasan urutan implementasi

Supaya tidak tertukar, ingat urutan ini:

1. Siapkan model `Siswa` agar bisa login.
2. Tambahkan guard `siswa` dan provider `siswas` di `config/auth.php`.
3. Buat `SiswaPanelProvider`.
4. Hubungkan panel siswa ke `LoginSiswa`.
5. Uji login di `/siswa`.
6. Setelah login berhasil, baru lanjut membuat fitur pengaduan siswa di modul berikutnya.

## Checkpoint

Pastikan:

- URL `/siswa` bisa dibuka
- form login siswa muncul
- siswa bisa login memakai NIS
- panel admin dan panel siswa sudah terpisah

Setelah login siswa berhasil, lanjut ke modul 8 untuk membuat fitur pengaduan dari sisi siswa.

## Navigasi Modul

[⬅ Modul Sebelumnya: Pengaduan Admin](./06-mengelola-pengaduan-admin.md) | [Daftar Modul](./README.md) | [Modul Berikutnya: Fitur Pengaduan Siswa ➜](./08-membuat-fitur-pengaduan-siswa.md)
