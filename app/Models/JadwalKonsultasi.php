<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalKonsultasi extends Model
{
    protected $table = 'jadwal_konsultasi';

    protected $fillable = [
        'permintaan_id',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'metode',
        'lokasi_link',
        'status',
    ];

    // Relasi ke permintaan konsultasi
    public function permintaan()
    {
        return $this->belongsTo(PermintaanKonsultasi::class, 'permintaan_id');
    }

    // Relasi ke hasil konsultasi
    public function hasilKonsultasi()
    {
        return $this->hasOne(HasilKonsultasi::class, 'jadwal_id');
    }
}

