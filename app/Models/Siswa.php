<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Console\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


#[Fillable(['nis', 'nama_siswa', 'id_kelas', 'password'])]
#[Hidden(['password', 'remember_token'])]
class Siswa extends Authenticatable implements FilamentUser
{

    protected function casts()
    {
        return [
            'password' => 'hashed',
        ];
    }


    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
