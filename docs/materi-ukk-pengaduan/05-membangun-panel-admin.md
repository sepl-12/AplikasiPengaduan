# Modul 5: Membangun Panel Admin dan Data Master

## Tujuan modul

Pada modul ini, kamu membuat panel admin untuk mengelola data dasar aplikasi.

## Apa itu panel admin?

Panel admin adalah halaman khusus untuk petugas atau admin. Dalam proyek ini, panel admin dipakai untuk:

- login admin
- membuka dashboard
- mengelola kategori
- mengelola kelas
- mengelola siswa
- melihat pengaduan

## Konfigurasi panel admin

Proyek ini memiliki provider:

- `app/Providers/Filament/AdminPanelProvider.php`

Hal penting yang diatur di sana:

- id panel: `admin`
- path URL: `/admin`
- login admin aktif
- resource admin diambil dari folder `app/Filament/Resources`

Artinya, panel admin dibuka lewat URL:

```text
/admin
```

## Membuat panel admin

Jika membuat dari nol, panel bisa dibuat dengan:

```bash
php artisan filament:make-panel admin
```

Lalu sesuaikan provider yang dihasilkan.

## Kode lengkap `AdminPanelProvider`

Command generator file ini:

```bash
php artisan filament:make-panel admin
```

Berikut isi file `app/Providers/Filament/AdminPanelProvider.php`:

```php
<?php

namespace App\Providers\Filament;

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

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
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

- `->default()` menjadikan panel admin sebagai panel utama
- `->id('admin')` memberi identitas panel
- `->path('admin')` membuat URL panel menjadi `/admin`
- `->login()` mengaktifkan halaman login admin bawaan Filament
- `->discoverResources(...)` membuat Filament membaca resource admin secara otomatis
- `->pages([...])` memuat dashboard
- `->widgets([...])` memuat widget bawaan
- `->authMiddleware([...])` memastikan hanya user login yang bisa masuk

## Struktur file panel admin

Pada proyek ini, panel admin terutama memakai file berikut:

- `app/Providers/Filament/AdminPanelProvider.php`
- `app/Filament/Resources/Kategoris/KategoriResource.php`
- `app/Filament/Resources/Kategoris/Schemas/KategoriForm.php`
- `app/Filament/Resources/Kategoris/Tables/KategorisTable.php`
- `app/Filament/Resources/Kelas/KelasResource.php`
- `app/Filament/Resources/Kelas/Schemas/KelasForm.php`
- `app/Filament/Resources/Kelas/Tables/KelasTable.php`
- `app/Filament/Resources/Siswas/SiswaResource.php`
- `app/Filament/Resources/Siswas/Schemas/SiswaForm.php`
- `app/Filament/Resources/Siswas/Tables/SiswasTable.php`

## Membuat resource kategori

Resource kategori dipakai untuk CRUD data kategori.

Langkah umumnya:

```bash
php artisan filament:make-resource Kategori --panel=admin
```

Setelah itu, atur:

- form kategori
- tabel kategori
- label menu navigasi

### Kode lengkap `KategoriResource`

Command generator file ini:

```bash
php artisan filament:make-resource Kategori --panel=admin
```

Berikut isi file `app/Filament/Resources/Kategoris/KategoriResource.php`:

```php
<?php

namespace App\Filament\Resources\Kategoris;

use App\Filament\Resources\Kategoris\Pages\CreateKategori;
use App\Filament\Resources\Kategoris\Pages\EditKategori;
use App\Filament\Resources\Kategoris\Pages\ListKategoris;
use App\Filament\Resources\Kategoris\Schemas\KategoriForm;
use App\Filament\Resources\Kategoris\Tables\KategorisTable;
use App\Models\Kategori;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class KategoriResource extends Resource
{
    protected static ?string $model = Kategori::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Tag;

    protected static ?string $recordTitleAttribute = 'Kategori';

    protected static ?string $modelLabel = "Kategori";

    protected static ?string $pluralModelLabel = "Manajemen Kategori";

    public static function form(Schema $schema): Schema
    {
        return KategoriForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KategorisTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListKategoris::route('/'),
            'create' => CreateKategori::route('/create'),
            'edit' => EditKategori::route('/{record}/edit'),
        ];
    }
}
```

Penjelasan:

- resource ini menghubungkan model `Kategori` dengan tampilan Filament
- `navigationIcon` menentukan ikon menu
- `modelLabel` dan `pluralModelLabel` mengatur nama menu di admin
- method `form()` memanggil file schema form
- method `table()` memanggil file table
- `getPages()` mendefinisikan halaman list, create, dan edit

### Form kategori

Field yang dibutuhkan hanya:

- `nama_kategori`

Berikut isi file `app/Filament/Resources/Kategoris/Schemas/KategoriForm.php`:

```php
<?php

namespace App\Filament\Resources\Kategoris\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class KategoriForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_kategori')
                    ->required(),
            ]);
    }
}
```

Penjelasan:

- `TextInput::make('nama_kategori')` membuat input nama kategori
- `->required()` berarti field wajib diisi
- `KategoriForm.php` ikut dibuat saat command resource dijalankan, jadi tidak perlu command terpisah

### Tabel kategori

Di proyek ini tabel kategori menampilkan:

- nama kategori
- created at
- updated at

Berikut isi file `app/Filament/Resources/Kategoris/Tables/KategorisTable.php`:

```php
<?php

namespace App\Filament\Resources\Kategoris\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class KategorisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_kategori')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
```

Penjelasan:

- `TextColumn` dipakai untuk menampilkan data tabel
- `->searchable()` membuat data bisa dicari
- `EditAction::make()` menambahkan tombol edit
- `DeleteBulkAction::make()` menambahkan hapus massal
- `KategorisTable.php` juga ikut dibuat oleh command resource yang sama

## Membuat resource kelas

Langkah umumnya:

```bash
php artisan filament:make-resource Kelas --panel=admin
```

Field utama:

- `nama_kelas`

Tabel menampilkan:

- nama kelas
- created at
- updated at

### Kode lengkap `KelasResource`

Command generator file ini:

```bash
php artisan filament:make-resource Kelas --panel=admin
```

Berikut isi file `app/Filament/Resources/Kelas/KelasResource.php`:

```php
<?php

namespace App\Filament\Resources\Kelas;

use App\Filament\Resources\Kelas\Pages\CreateKelas;
use App\Filament\Resources\Kelas\Pages\EditKelas;
use App\Filament\Resources\Kelas\Pages\ListKelas;
use App\Filament\Resources\Kelas\Schemas\KelasForm;
use App\Filament\Resources\Kelas\Tables\KelasTable;
use App\Models\Kelas;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class KelasResource extends Resource
{
    protected static ?string $model = Kelas::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::AcademicCap;

    protected static ?string $recordTitleAttribute = 'Kelas';

    protected static ?string $modelLabel = "Kelas";

    protected static ?string $pluralModelLabel = "Manajemen Kelas";

    public static function form(Schema $schema): Schema
    {
        return KelasForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KelasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListKelas::route('/'),
            'create' => CreateKelas::route('/create'),
            'edit' => EditKelas::route('/{record}/edit'),
        ];
    }
}
```

Berikut isi file `app/Filament/Resources/Kelas/Schemas/KelasForm.php`:

```php
<?php

namespace App\Filament\Resources\Kelas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class KelasForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_kelas')
                    ->required(),
            ]);
    }
}
```

Berikut isi file `app/Filament/Resources/Kelas/Tables/KelasTable.php`:

```php
<?php

namespace App\Filament\Resources\Kelas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class KelasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_kelas')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
```

Penjelasan:

- struktur resource kelas hampir sama dengan kategori
- bedanya hanya model, label, ikon, dan field yang ditampilkan
- pola seperti ini umum di Filament, jadi siswa perlu membiasakan diri membacanya
- `KelasForm.php` dan `KelasTable.php` ikut dibuat saat command resource dijalankan

## Membuat resource siswa

Langkah umumnya:

```bash
php artisan filament:make-resource Siswa --panel=admin
```

Form siswa di proyek ini berisi:

- NIS
- nama siswa
- kelas
- password

Bagian penting:

- `id_kelas` dibuat dengan `Select`
- field tersebut memakai `relationship('kelas', 'nama_kelas')`

Artinya, daftar kelas langsung diambil dari tabel `kelas`.

### Kode lengkap `SiswaResource`

Command generator file ini:

```bash
php artisan filament:make-resource Siswa --panel=admin
```

Berikut isi file `app/Filament/Resources/Siswas/SiswaResource.php`:

```php
<?php

namespace App\Filament\Resources\Siswas;

use App\Filament\Resources\Siswas\Pages\CreateSiswa;
use App\Filament\Resources\Siswas\Pages\EditSiswa;
use App\Filament\Resources\Siswas\Pages\ListSiswas;
use App\Filament\Resources\Siswas\Schemas\SiswaForm;
use App\Filament\Resources\Siswas\Tables\SiswasTable;
use App\Models\Siswa;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SiswaResource extends Resource
{
    protected static ?string $model = Siswa::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Users;

    protected static ?string $recordTitleAttribute = 'Siswa';

    protected static ?string $modelLabel = "Siswa";

    protected static ?string $pluralModelLabel = "Manajemen Siswa";

    public static function form(Schema $schema): Schema
    {
        return SiswaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SiswasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSiswas::route('/'),
            'create' => CreateSiswa::route('/create'),
            'edit' => EditSiswa::route('/{record}/edit'),
        ];
    }
}
```

Berikut isi file `app/Filament/Resources/Siswas/Schemas/SiswaForm.php`:

```php
<?php

namespace App\Filament\Resources\Siswas\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SiswaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nis')
                    ->required()
                    ->numeric()
                    ->label('Nomor Induk Siswa'),
                TextInput::make('nama_siswa')
                    ->required()
                    ->label('Nama Siswa'),
                Select::make('id_kelas')
                    ->relationship('kelas', 'nama_kelas')
                    ->required()
                    ->label('Kelas'),
                TextInput::make('password')
                    ->password()
                    ->required(),
            ]);
    }
}
```

Berikut isi file `app/Filament/Resources/Siswas/Tables/SiswasTable.php`:

```php
<?php

namespace App\Filament\Resources\Siswas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SiswasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nis')
                    ->searchable(),
                TextColumn::make('nama_siswa')
                    ->searchable(),
                TextColumn::make('kelas.nama_kelas')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
```

Penjelasan:

- `nis` dibuat numeric agar input hanya angka
- `id_kelas` memakai `Select` dengan `relationship()` agar pilihan kelas otomatis diambil dari tabel `kelas`
- pada tabel siswa, `kelas.nama_kelas` dipakai untuk menampilkan nama kelas hasil relasi
- password dibuat dengan `->password()` agar input tidak terlihat
- `SiswaForm.php` dan `SiswasTable.php` tidak perlu command terpisah karena ikut dalam generator resource

## Pola yang harus siswa pahami dari resource admin

Setelah melihat tiga resource di atas, perhatikan pola berikut:

1. Setiap menu admin biasanya punya 3 file utama: `Resource`, `Form`, dan `Table`.
2. `Resource` adalah penghubung utama.
3. `Form` dipakai saat create dan edit.
4. `Table` dipakai saat list data.
5. Relasi seperti kelas siswa bisa ditampilkan dengan `relationship()` di form dan `kelas.nama_kelas` di table.

## Kenapa data master harus dibuat dulu?

Karena fitur pengaduan membutuhkan data pendukung:

- siswa harus punya kelas
- pengaduan harus punya kategori
- admin harus punya akun

Kalau data master belum ada, form pengaduan belum bisa berjalan dengan baik.

## Tips untuk ujian praktik

Saat presentasi atau ujian, jelaskan urutan berikut:

1. Buat panel admin
2. Buat resource kategori
3. Buat resource kelas
4. Buat resource siswa
5. Uji tambah data dari panel admin

Urutan ini menunjukkan bahwa kamu paham fondasi aplikasi.

## Checkpoint

Pastikan:

- admin bisa login ke `/admin`
- menu kategori muncul
- menu kelas muncul
- menu siswa muncul
- data master bisa ditambah dan diedit

Setelah panel admin siap, lanjut ke modul 6 untuk mengelola pengaduan dari sisi admin.
