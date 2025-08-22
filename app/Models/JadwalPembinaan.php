<?php

namespace App\Models;

use App\Models\User;
use App\Models\Feedback;
use App\Models\JenisPembinaan;
use App\Models\TopikPembinaan;
use App\Models\PesertaPembinaan;
use Illuminate\Database\Eloquent\Model;

class JadwalPembinaan extends Model
{
    protected $table = 'jadwal_pembinaan';

    protected $fillable = [
        'jenis_id',
        'topik_pembinaan_id',
        'judul',
        'deskripsi',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi',
        'kuota',
        'metode',
        'thumbnail',
        'created_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktu_mulai' => 'datetime:H:i',
        'waktu_selesai' => 'datetime:H:i',
    ];

    // Relasi ke jenis pembinaan
    public function jenis()
    {
        return $this->belongsTo(JenisPembinaan::class, 'jenis_id');
    }

    // Relasi ke topik pembinaan
    public function topik()
    {
        return $this->belongsTo(TopikPembinaan::class, 'topik_pembinaan_id');
    }

    // Relasi ke admin (user yang membuat jadwal)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relasi ke peserta pembinaan
    public function pesertaPembinaan()
    {
        return $this->hasMany(PesertaPembinaan::class, 'pembinaan_id');
    }

    public function feedbacks()
    {
        return $this->morphMany(Feedback::class, 'target', 'target_type', 'target_id');
    }
}

