<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    protected $table = 'umkm';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'nama_usaha',
        'bidang_usaha',
        'alamat_usaha',
        'tahun_berdiri',
        'foto_profil',
        'kategori_usaha',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    // Relasi ke peserta pembinaan
    public function pesertaPembinaan()
    {
        return $this->hasMany(PesertaPembinaan::class, 'umkm_id');
    }
}

