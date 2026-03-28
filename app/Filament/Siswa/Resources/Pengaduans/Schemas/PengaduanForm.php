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
                DatePicker::make('tanggal_pengaduan')
                    ->required()
                    ->date(),
                Select::make('id_siswa')
                    ->required()
                    ->relationship('siswa', 'nama_siswa')
                    ->numeric(),
                Select::make('id_kategori')
                    ->required()
                    ->relationship('kategori', 'nama_kategori')
                    ->numeric(),
                TextInput::make('lokasi')
                    ->required(),
                Textarea::make('keterangan')
                    ->required()
                    ->columnSpanFull(),
                Select::make('status')
                    ->options(StatusPengaduan::class)
                    ->default('menunggu')
                    ->required(),
                Textarea::make('feedback')
                    ->columnSpanFull(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
            ]);
    }
}
