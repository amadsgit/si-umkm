<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class PesertaPembinaan extends Model
{
    public $timestamps = false;

    protected $table = 'peserta_pembinaan';

    protected $fillable = [
        'pembinaan_id',
        'umkm_id',
        'status_kehadiran',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // Relasi ke jadwal pembinaan
    public function pembinaan()
    {
        return $this->belongsTo(JadwalPembinaan::class, 'pembinaan_id');
    }

    // Relasi ke UMKM
    public function umkm()
    {
        return $this->belongsTo(Umkm::class, 'umkm_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'umkm_id', 'id');
    }
}
