<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriFasilitas extends Model
{
    protected $table = 'kategori_fasilitas';

    protected $fillable = ['nama_kategori'];

    public function laporan()
    {
        return $this->hasMany(Laporan::class);
    }
}