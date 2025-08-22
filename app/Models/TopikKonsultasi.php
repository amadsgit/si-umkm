<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopikKonsultasi extends Model
{
    protected $table = 'topik_konsultasi';

    protected $fillable = [
        'nama_topik',
        'deskripsi',
        'is_aktif',
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    // Relasi: topik_konsultasi memiliki banyak permintaan konsultasi
    public function permintaanKonsultasi()
    {
        return $this->hasMany(PermintaanKonsultasi::class, 'topik_id');
    }
}


