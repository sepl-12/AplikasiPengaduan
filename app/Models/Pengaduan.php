<?php

namespace App\Models;

use App\StatusPengaduan;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['tanggal_pengaduan', 'id_siswa', 'id_kategori', 'lokasi', 'keterangan', 'status', 'feedback', 'user_id'])]
class Pengaduan extends Model
{

    protected function casts()
    {
        return [
            'tanggal_pengaduan' => 'date',
            'status' => StatusPengaduan::class,
        ];
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
