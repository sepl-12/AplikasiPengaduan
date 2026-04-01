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
