# Modul 6: Mengelola Pengaduan dari Sisi Admin

## Tujuan modul

Pada modul ini, kamu membuat fitur agar admin bisa melihat semua pengaduan dan menindaklanjutinya.

## Posisi fitur ini dalam aplikasi

Pengaduan adalah inti dari aplikasi. Tetapi di proyek ini, admin tidak membuat pengaduan. Admin hanya:

- melihat daftar pengaduan
- memeriksa isi laporan
- memberi status
- memberi feedback

## Resource pengaduan admin

Resource ini berada di panel admin dan terhubung ke model `Pengaduan`.

Resource pengaduan admin dibuat hanya untuk daftar data, bukan untuk form tambah dari admin.

Kenapa?

Karena pengaduan dibuat oleh siswa, bukan admin.

## Kode lengkap `PengaduanResource`

Command generator file ini:

```bash
php artisan filament:make-resource Pengaduan --panel=admin
```

Berikut isi file `app/Filament/Resources/Pengaduans/PengaduanResource.php`:

```php
<?php

namespace App\Filament\Resources\Pengaduans;

use App\Filament\Resources\Pengaduans\Pages\CreatePengaduan;
use App\Filament\Resources\Pengaduans\Pages\EditPengaduan;
use App\Filament\Resources\Pengaduans\Pages\ListPengaduans;
use App\Filament\Resources\Pengaduans\Schemas\PengaduanForm;
use App\Filament\Resources\Pengaduans\Tables\PengaduansTable;
use App\Models\Pengaduan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PengaduanResource extends Resource
{
    protected static ?string $model = Pengaduan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentText;

    protected static ?string $recordTitleAttribute = 'Pengaduan';

    protected static ?string $modelLabel = "Pengaduan";

    protected static ?string $pluralModelLabel = "Manajemen Pengaduan";

    public static function form(Schema $schema): Schema
    {
        return parent::form($schema);
    }

    public static function table(Table $table): Table
    {
        return PengaduansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPengaduans::route('/'),
        ];
    }
}
```

Penjelasan:

- resource ini memakai model `Pengaduan`
- ikon menu memakai `Heroicon::DocumentText`
- `canCreate()` mengembalikan `false`, jadi admin tidak bisa membuat pengaduan baru
- halaman yang dipakai hanya `index`, artinya fokus admin hanya melihat daftar dan mereview data
- `PengaduansTable.php` dan page default resource ikut dibuat bersama command ini

## Kode lengkap `PengaduansTable`

Berikut isi file `app/Filament/Resources/Pengaduans/Tables/PengaduansTable.php`:

```php
<?php

namespace App\Filament\Resources\Pengaduans\Tables;

use App\StatusPengaduan;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PengaduansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tanggal_pengaduan')
                    ->date()
                    ->sortable(),
                TextColumn::make('siswa.nama_siswa')
                    ->numeric()
                    ->label('Nama Siswa')
                    ->sortable(),
                TextColumn::make('kategori.nama_kategori')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('lokasi')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('feedback')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->sortable()
                    ->label('Admin'),
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
                Filter::make('tanggal_pengaduan')
                    ->schema([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->recordActions([
                Action::make('review')
                    ->label('Review')
                    ->icon('heroicon-o-eye')
                    ->color('primary')
                    ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->options(StatusPengaduan::class)
                            ->required(),
                        Textarea::make('feedback')
                            ->label('Feedback')
                            ->required(),
                    ])
                    ->action(function ($record, $data) {
                        $data['user_id'] = auth()->user()->id;
                        $record->update($data);
                    }),
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

- `TextColumn::make('siswa.nama_siswa')` menampilkan nama siswa dari relasi
- `TextColumn::make('kategori.nama_kategori')` menampilkan kategori dari relasi
- `TextColumn::make('status')->badge()` menampilkan status dalam bentuk badge
- `TextColumn::make('user.name')` menampilkan admin yang menangani
- filter tanggal dipakai agar admin bisa menyaring data pengaduan
- aksi utama adalah `review`, bukan edit form biasa

## Fokus pada aksi `review`

Bagian terpenting dari tabel admin ada di sini:

```php
Action::make('review')
    ->label('Review')
    ->icon('heroicon-o-eye')
    ->color('primary')
```

Penjelasan:

- tombol ini muncul pada setiap baris data pengaduan
- saat ditekan, admin akan membuka form kecil untuk memberi status dan feedback

Schema review yang dipakai:

```php
->schema([
    Select::make('status')
        ->label('Status')
        ->options(StatusPengaduan::class)
        ->required(),
    Textarea::make('feedback')
        ->label('Feedback')
        ->required(),
])
```

Penjelasan:

- `Select` dipakai untuk memilih status
- opsi status diambil langsung dari enum `StatusPengaduan`
- `Textarea` dipakai untuk menulis tanggapan admin

Saat form review disimpan, aksi berikut dijalankan:

```php
->action(function ($record, $data) {
    $data['user_id'] = auth()->user()->id;
    $record->update($data);
})
```

Penjelasan:

- `$record` adalah data pengaduan yang sedang direview
- `$data` berisi input dari form review
- `auth()->user()->id` mengambil id admin yang sedang login
- lalu data pengaduan diperbarui dengan status, feedback, dan `user_id`

## Tampilan tabel pengaduan admin

Di proyek ini, tabel admin menampilkan:

- tanggal pengaduan
- nama siswa
- kategori
- lokasi
- status
- feedback
- admin yang menangani

Ini sudah cukup untuk proses monitoring.

## Filter tanggal

Proyek ini juga menambahkan filter tanggal pada tabel pengaduan.

Tujuannya agar admin bisa menyaring data berdasarkan waktu tertentu.

Komponen yang dipakai:

- `DatePicker`
- `Filter`

Kode filternya:

```php
Filter::make('tanggal_pengaduan')
    ->schema([
        DatePicker::make('created_from'),
        DatePicker::make('created_until'),
    ])
```

Penjelasan:

- admin bisa memilih tanggal awal dan tanggal akhir
- data akan difilter sesuai rentang tersebut

## Aksi review

Fitur paling penting di sisi admin adalah aksi `review`.

Saat admin menekan tombol review, admin bisa mengisi:

- `status`
- `feedback`

Lalu sistem akan otomatis menyimpan:

- status terbaru
- feedback admin
- `user_id` admin yang sedang login

## Kode lengkap page daftar pengaduan admin

Command generator file ini:

```bash
php artisan filament:make-resource Pengaduan --panel=admin
```

Berikut isi file `app/Filament/Resources/Pengaduans/Pages/ListPengaduans.php`:

```php
<?php

namespace App\Filament\Resources\Pengaduans\Pages;

use App\Filament\Resources\Pengaduans\PengaduanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPengaduans extends ListRecords
{
    protected static string $resource = PengaduanResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
```

Penjelasan:

- page ini dipakai untuk menampilkan daftar semua pengaduan
- `getHeaderActions()` dikosongkan, jadi tidak ada tombol create di atas tabel
- file page ini biasanya ikut terbentuk saat generator resource dijalankan

## Kode page lain yang ada di proyek

Walaupun admin tidak memakai halaman create dan edit untuk alur utama, file class-nya tetap ada di proyek.

Berikut isi file `app/Filament/Resources/Pengaduans/Pages/CreatePengaduan.php`:

```php
<?php

namespace App\Filament\Resources\Pengaduans\Pages;

use App\Filament\Resources\Pengaduans\PengaduanResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePengaduan extends CreateRecord
{
    protected static string $resource = PengaduanResource::class;
}
```

Berikut isi file `app/Filament/Resources/Pengaduans/Pages/EditPengaduan.php`:

```php
<?php

namespace App\Filament\Resources\Pengaduans\Pages;

use App\Filament\Resources\Pengaduans\PengaduanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPengaduan extends EditRecord
{
    protected static string $resource = PengaduanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
```

Penjelasan:

- file ini ada karena biasanya dibuat otomatis oleh generator Filament
- tetapi dalam alur proyek ini, admin cukup memakai halaman list dan aksi review
- ini contoh penting untuk siswa: tidak semua file yang dibuat generator harus dipakai semua

## Kenapa `user_id` disimpan?

Supaya kita tahu pengaduan ini ditangani oleh siapa.

Ini penting untuk:

- pencatatan
- tanggung jawab admin
- tampilan informasi kepada siswa

## Status pengaduan

Status yang dipakai:

- `menunggu`
- `proses`
- `selesai`

Contoh alur:

1. Siswa mengirim pengaduan, status awal `menunggu`
2. Admin mulai menangani, ubah ke `proses`
3. Setelah selesai, ubah ke `selesai`

## Kenapa admin tidak boleh create pengaduan?

Di resource admin, pembuatan data baru dimatikan.

Logikanya sederhana:

- sumber pengaduan harus berasal dari siswa
- admin hanya memverifikasi dan memproses

Ini membuat alur sistem lebih rapi.

## Tips penjelasan saat ujian

Jika ditanya guru atau penguji, kamu bisa jelaskan:

- pengaduan dibuat siswa
- admin hanya meninjau
- status memakai enum agar konsisten
- feedback dipakai untuk memberi tanggapan resmi

## Checkpoint

Pastikan:

- admin bisa melihat semua pengaduan
- tombol review berjalan
- status bisa berubah
- feedback tersimpan
- admin penangan ditampilkan

Setelah sisi admin untuk pengaduan selesai, lanjut ke modul 7 untuk membuat login dan panel khusus siswa.
