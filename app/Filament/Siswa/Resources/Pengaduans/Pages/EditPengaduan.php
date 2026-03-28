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
