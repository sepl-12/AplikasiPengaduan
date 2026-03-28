<?php

namespace App\Filament\Resources\Siswas\Schemas;

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
                    ->label('Nomor Induk Siswa'),
                TextInput::make('nama_siswa')
                    ->required()
                    ->label('Nama Siswa'),
                TextInput::make('id_kelas')
                    ->required()
                    ->numeric()
                    ->label('Kelas'),
                TextInput::make('password')
                    ->password()
                    ->required(),
            ]);
    }
}
