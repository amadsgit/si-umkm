<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}

