<?php

namespace App\Models;

use Illuminate\Console\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nis', 'nama_siswa', 'id_kelas', 'password'])]
#[Hidden(['password', 'remember_token'])]
class Siswa extends Model
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
}
