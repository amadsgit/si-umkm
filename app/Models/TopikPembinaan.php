<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopikPembinaan extends Model
{
    use HasFactory;
    protected $table = 'topik_pembinaan';

    protected $fillable = [
        'nama_topik_pembinaan',
        'deskripsi',
    ];
}
