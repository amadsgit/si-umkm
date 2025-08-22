<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class JenisPembinaan extends Model
{
    protected $table = 'jenis_pembinaan';

    protected $fillable = [
        'nama_pembinaan',
        'deskripsi',
        'created_by',
    ];

    // Relasi ke user (admin yang membuat)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relasi ke jadwal pembinaan
    public function jadwalPembinaan()
    {
        return $this->hasMany(JadwalPembinaan::class, 'jenis_id');
    }
}


