<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KepalaUPTD extends Model
{
    protected $table = 'kepala_uptd';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'nip',
        'jabatan',
        'foto_profil',
        'status_aktif',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}