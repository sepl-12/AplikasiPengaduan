<?php

namespace App\Filament\Siswa\Resources\Siswas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SiswaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nis')
                    ->required(),
                TextInput::make('nama_siswa')
                    ->required(),
                TextInput::make('id_kelas')
                    ->required()
                    ->numeric(),
                TextInput::make('password')
                    ->password()
                    ->required(),
            ]);
    }
}
