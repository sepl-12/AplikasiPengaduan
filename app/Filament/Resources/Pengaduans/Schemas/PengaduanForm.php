<?php

namespace App\Filament\Resources\Pengaduans\Schemas;

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
                    ->required(),
                TextInput::make('id_siswa')
                    ->required()
                    ->numeric(),
                TextInput::make('id_kategori')
                    ->required()
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
