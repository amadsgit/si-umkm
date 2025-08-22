<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konsultan extends Model
{
    protected $table = 'konsultan';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'keahlian',
        'sertifikasi',
        'nomor_sertifikat',
        'tanggal_sertifikat',
        'lembaga',
        'file_sertifikat',
        'foto_profil',
        'bio',
        'status_aktif',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function feedbacks()
    {
        return $this->morphMany(Feedback::class, 'target', 'target_type', 'target_id');
    }
}
