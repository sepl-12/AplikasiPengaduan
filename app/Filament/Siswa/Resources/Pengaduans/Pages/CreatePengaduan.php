<?php

namespace App\Filament\Siswa\Resources\Pengaduans\Pages;

use App\Filament\Siswa\Resources\Pengaduans\PengaduanResource;
use App\StatusPengaduan;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CreatePengaduan extends CreateRecord
{
    protected static string $resource = PengaduanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data["id_siswa"] = Auth::user()->id;
        $data["tanggal_pengaduan"] = now()->toDateString();
        $data["status"] = StatusPengaduan::MENUNGGU;
        return $data;
    }
}
