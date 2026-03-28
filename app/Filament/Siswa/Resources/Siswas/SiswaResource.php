<?php

namespace App\Filament\Siswa\Resources\Siswas;

use App\Filament\Siswa\Resources\Siswas\Pages\CreateSiswa;
use App\Filament\Siswa\Resources\Siswas\Pages\EditSiswa;
use App\Filament\Siswa\Resources\Siswas\Pages\ListSiswas;
use App\Filament\Siswa\Resources\Siswas\Schemas\SiswaForm;
use App\Filament\Siswa\Resources\Siswas\Tables\SiswasTable;
use App\Models\Siswa;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SiswaResource extends Resource
{
    protected static ?string $model = Siswa::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Pengaduan';

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
