<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilKonsultasi extends Model
{
    protected $table = 'hasil_konsultasi';

    protected $fillable = [
        'jadwal_id',
        'ringkasan',
        'solusi',
        'dokumen',
        'created_by',
    ];

    // Relasi ke jadwal konsultasi
    public function jadwal()
    {
        return $this->belongsTo(JadwalKonsultasi::class, 'jadwal_id');
    }

    // Relasi ke user (konsultan yang membuat hasil)
    public function konsultan()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // app/Models/HasilKonsultasi.php
    public function permintaan()
    {
        return $this->belongsTo(PermintaanKonsultasi::class, 'permintaan_konsultasi_id', 'id');
    }

}