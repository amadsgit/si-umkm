<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanKonsultasi extends Model
{
    use HasFactory;

    protected $table = 'permintaan_konsultasi';

    protected $fillable = [
        'umkm_id',
        'topik_id',
        'konsultan_id',
        'preferensi_tanggal',
        'deskripsi_masalah',
        'status',
        'alasan_ditolak',
    ];

    // Relasi ke UMKM
    public function umkm()
    {
        return $this->belongsTo(Umkm::class, 'umkm_id');
    }

    // Relasi ke Topik Konsultasi
    public function topik()
    {
        return $this->belongsTo(TopikKonsultasi::class, 'topik_id');
    }

    // Relasi ke Konsultan (nullable)
    public function konsultan()
    {
        return $this->belongsTo(Konsultan::class, 'konsultan_id');
    }

    // Relasi ke jadwal konsultasi
    public function jadwal()
    {
        return $this->hasOne(JadwalKonsultasi::class, 'permintaan_id');
    }

    // public function feedback()
    // {
    //     return $this->morphOne(Feedback::class, 'target');
    // }

    // Relasi ke hasil konsultasi lewat jadwal
    public function hasilKonsultasi()
    {
        return $this->hasOneThrough(
            HasilKonsultasi::class,
            JadwalKonsultasi::class,
            'permintaan_id', // FK di jadwal_konsultasi
            'jadwal_id',      // FK di hasil_konsultasi
            'id',             // PK di permintaan_konsultasi
            'id'              // PK di jadwal_konsultasi
        );
    }
}
