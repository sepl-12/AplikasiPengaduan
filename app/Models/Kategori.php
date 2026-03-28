<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;


#[Fillable(['nama_kategori'])]
class Kategori extends Model
{
    
    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class);
    }
}
