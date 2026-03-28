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
