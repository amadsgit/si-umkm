<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    public $timestamps = false;

    protected $table = 'feedback';

    protected $fillable = [
        'umkm_id',
        'target_id',
        'target_type',
        'rating',
        'komentar',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'rating' => 'integer',
    ];

    // Relasi ke UMKM pemberi feedback
    public function umkm()
    {
        return $this->belongsTo(Umkm::class, 'umkm_id');
    }

    // Polymorphic relasi ke konsultan atau pembinaan
    public function target()
    {
        return $this->morphTo(__FUNCTION__, 'target_type', 'target_id');
    }
}
