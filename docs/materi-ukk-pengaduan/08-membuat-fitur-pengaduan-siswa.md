# Modul 8: Membuat Fitur Pengaduan dari Sisi Siswa

## Tujuan modul

Pada modul ini, kamu membuat fitur utama yang dipakai siswa untuk mengirim laporan kerusakan.

## Urutan kerja yang benar

Setelah modul login siswa selesai, kerjakan fitur pengaduan siswa dengan urutan berikut:

1. Buat `PengaduanResource` untuk panel siswa.
2. Buat `PengaduanForm`.
3. Buat `PengaduansTable`.
4. Buat page `ListPengaduans`.
5. Buat page `CreatePengaduan`.
6. Buat page `EditPengaduan`.
7. Baru lakukan pengujian create, edit, dan pemantauan status.

Urutan ini penting karena page create dan edit bergantung pada resource, form, dan table.

## Resource pengaduan siswa

Panel siswa memiliki resource sendiri untuk pengaduan.

Kenapa dipisah dari admin?

Karena kebutuhan tampilannya berbeda:

- siswa perlu form tambah dan edit
- admin perlu review dan monitoring

## Kode lengkap `PengaduanResource` siswa

Berikut isi file `app/Filament/Siswa/Resources/Pengaduans/PengaduanResource.php`:

```php
<?php

namespace App\Filament\Siswa\Resources\Pengaduans;

use App\Filament\Siswa\Resources\Pengaduans\Pages\CreatePengaduan;
use App\Filament\Siswa\Resources\Pengaduans\Pages\EditPengaduan;
use App\Filament\Siswa\Resources\Pengaduans\Pages\ListPengaduans;
use App\Filament\Siswa\Resources\Pengaduans\Schemas\PengaduanForm;
use App\Filament\Siswa\Resources\Pengaduans\Tables\PengaduansTable;
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

    public static function form(Schema $schema): Schema
    {
        return PengaduanForm::configure($schema);
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

    public static function getPages(): array
    {
        return [
            'index' => ListPengaduans::route('/'),
            'create' => CreatePengaduan::route('/create'),
            'edit' => EditPengaduan::route('/{record}/edit'),
        ];
    }
}
```

Penjelasan:

- resource ini adalah pusat fitur pengaduan siswa
- `form()` menghubungkan ke schema form siswa
- `table()` menghubungkan ke table siswa
- `getPages()` mengatur halaman list, create, dan edit

## Form pengaduan siswa

Di proyek ini, form siswa dibuat sederhana agar mudah dipakai.

Field yang diisi siswa:

- kategori
- lokasi
- keterangan

Siswa tidak perlu mengisi:

- tanggal pengaduan
- status
- admin penangan
- id siswa

Semua itu diatur otomatis oleh sistem.

## Kode lengkap `PengaduanForm` siswa

Berikut isi file `app/Filament/Siswa/Resources/Pengaduans/Schemas/PengaduanForm.php`:

```php
<?php

namespace App\Filament\Siswa\Resources\Pengaduans\Schemas;

use App\StatusPengaduan;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PengaduanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('id_kategori')
                    ->relationship('kategori', 'nama_kategori')
                    ->required()
                    ->label('Nama Kategori'),
                TextInput::make('lokasi')
                    ->required(),
                Textarea::make('keterangan')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
```

Penjelasan:

- siswa hanya mengisi kategori, lokasi, dan keterangan
- `relationship('kategori', 'nama_kategori')` membuat daftar kategori diambil otomatis dari tabel `kategoris`
- form dibuat sederhana supaya siswa fokus pada isi laporan

## Kenapa form dibuat sederhana?

Karena siswa adalah pengguna umum. Semakin sedikit field, semakin kecil kemungkinan salah input.

## Mengisi data otomatis saat create

Pada page `CreatePengaduan`, proyek ini memakai method:

```php
mutateFormDataBeforeCreate()
```

Method ini dipakai untuk menambahkan data otomatis sebelum disimpan.

Data yang diisi otomatis:

- `id_siswa` dari siswa yang sedang login
- `tanggal_pengaduan` dari tanggal hari ini
- `status` default `menunggu`

Ini adalah langkah yang sangat penting.

## Kode lengkap page `CreatePengaduan`

Berikut isi file `app/Filament/Siswa/Resources/Pengaduans/Pages/CreatePengaduan.php`:

```php
<?php

namespace App\Filament\Siswa\Resources\Pengaduans\Pages;

use App\Filament\Siswa\Resources\Pengaduans\PengaduanResource;
use App\StatusPengaduan;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CreatePengaduan extends CreateRecord
{
    protected static string $resource = PengaduanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data["id_siswa"] = Auth::user()->id;
        $data["tanggal_pengaduan"] = now()->toDateString();
        $data["status"] = StatusPengaduan::MENUNGGU;
        return $data;
    }
}
```

Penjelasan:

- page ini dipakai saat siswa membuat laporan baru
- `mutateFormDataBeforeCreate()` mengisi data otomatis sebelum disimpan
- `id_siswa` diambil dari akun siswa yang sedang login
- `tanggal_pengaduan` diambil dari tanggal hari ini
- `status` selalu dimulai dari `MENUNGGU`

## Kenapa `id_siswa` tidak boleh diisi manual?

Karena kalau siswa boleh memilih sendiri `id_siswa`, maka:

- data bisa tidak valid
- siswa bisa mengatasnamakan siswa lain

Jadi data itu harus diambil langsung dari akun yang sedang login.

## Tabel pengaduan siswa

Di panel siswa, tabel pengaduan menampilkan:

- tanggal pengaduan
- kategori
- lokasi
- status
- feedback
- admin yang menangani

Ini membuat siswa bisa memantau hasil laporannya.

## Kode lengkap `PengaduansTable` siswa

Berikut isi file `app/Filament/Siswa/Resources/Pengaduans/Tables/PengaduansTable.php`:

```php
<?php

namespace App\Filament\Siswa\Resources\Pengaduans\Tables;

use App\StatusPengaduan;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PengaduansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tanggal_pengaduan')
                    ->date()
                    ->sortable(),
                TextColumn::make('kategori.nama_kategori')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('lokasi')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('feedback')
                    ->label('Feedback')
                    ->placeholder('Menunggu balasan'),
                TextColumn::make('user.name')
                    ->label('Admin yang Menangani')
                    ->placeholder('Menunggu balasan'),
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
                EditAction::make()
                    ->disabled(fn($record) => $record->status !== StatusPengaduan::MENUNGGU),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                ]),
            ]);
    }
}
```

Penjelasan:

- siswa bisa melihat tanggal, kategori, lokasi, status, feedback, dan admin penangan
- `placeholder('Menunggu balasan')` dipakai jika feedback atau admin belum ada
- `EditAction` hanya aktif jika status masih `MENUNGGU`

## Aturan edit pengaduan

Di proyek ini, tombol edit hanya aktif jika status pengaduan masih `menunggu`.

Logikanya:

- jika admin belum menindaklanjuti, siswa masih boleh memperbaiki laporan
- jika sudah `proses` atau `selesai`, siswa tidak boleh mengubah isi laporan lagi

Aturan ini bagus untuk menjaga konsistensi data.

## Kode lengkap page daftar dan edit

Berikut isi file `app/Filament/Siswa/Resources/Pengaduans/Pages/ListPengaduans.php`:

```php
<?php

namespace App\Filament\Siswa\Resources\Pengaduans\Pages;

use App\Filament\Siswa\Resources\Pengaduans\PengaduanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPengaduans extends ListRecords
{
    protected static string $resource = PengaduanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
```

Berikut isi file `app/Filament/Siswa/Resources/Pengaduans/Pages/EditPengaduan.php`:

```php
<?php

namespace App\Filament\Siswa\Resources\Pengaduans\Pages;

use App\Filament\Siswa\Resources\Pengaduans\PengaduanResource;
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

- `ListPengaduans` menampilkan daftar laporan siswa
- `CreateAction::make()` menampilkan tombol tambah pengaduan
- `EditPengaduan` dipakai saat siswa memperbarui laporan
- `DeleteAction::make()` memberi opsi hapus dari halaman edit

## Apakah siswa bisa menghapus pengaduan?

Pada page edit, ada `DeleteAction`.

Artinya siswa bisa menghapus pengaduan dari halaman edit. Jika fitur ini dirasa terlalu bebas, kamu bisa mematikannya saat pengembangan lanjutan.

Untuk kebutuhan belajar, ini bisa dijelaskan sebagai fitur tambahan.

## Alur kerja siswa

Urutan penggunaan siswa:

1. Login ke panel siswa
2. Klik tambah pengaduan
3. Pilih kategori
4. Isi lokasi
5. Isi keterangan
6. Simpan
7. Pantau status dan feedback dari admin

## Ringkasan urutan implementasi

Supaya modul ini tidak membingungkan, ingat urutan pembuatannya:

1. Buat `PengaduanResource`.
2. Buat `PengaduanForm`.
3. Buat `PengaduansTable`.
4. Buat `ListPengaduans`.
5. Buat `CreatePengaduan`.
6. Tambahkan logika `mutateFormDataBeforeCreate()`.
7. Buat `EditPengaduan`.
8. Uji create, edit, dan tampilan status.

## Checkpoint

Pastikan:

- siswa bisa membuat pengaduan
- tanggal terisi otomatis
- status awal `menunggu`
- nama admin tampil jika sudah direview
- edit hanya aktif saat status masih `menunggu`

Setelah fitur siswa selesai, lanjut ke modul 9 untuk pengujian dan penyelesaian proyek.
