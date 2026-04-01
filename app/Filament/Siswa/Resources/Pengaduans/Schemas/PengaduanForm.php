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
