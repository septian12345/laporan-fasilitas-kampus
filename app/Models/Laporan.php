<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';

    protected $fillable = [
        'user_id', 'kategori_fasilitas_id', 'judul', 'lokasi', 'deskripsi', 'foto', 'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriFasilitas::class, 'kategori_fasilitas_id');
    }

    public function progres()
    {
        return $this->hasMany(ProgresLaporan::class)->latest();
    }

    // Helper label status (dipakai di Blade, setara statusLabel() di versi Node)
    public function statusLabel(): string
    {
        return match ($this->status) {
            'menunggu' => 'Menunggu',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
            default => $this->status,
        };
    }
}