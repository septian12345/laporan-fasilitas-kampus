<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgresLaporan extends Model
{
    protected $table = 'progres_laporan';

    protected $fillable = ['laporan_id', 'diubah_oleh', 'status_baru', 'catatan'];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'diubah_oleh');
    }

    public function statusLabel(): string
    {
        return match ($this->status_baru) {
            'menunggu' => 'Menunggu',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
            default => $this->status_baru,
        };
    }
}