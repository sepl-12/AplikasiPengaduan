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
