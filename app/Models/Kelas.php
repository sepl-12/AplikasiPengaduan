<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama_kelas'])]
class Kelas extends Model
{
    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }
}
