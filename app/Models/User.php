<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Umkm;
use App\Models\Admin;
use App\Models\Konsultan;
use App\Models\KepalaUPTD;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'phone',
        'password',
        'role',
        'last_login',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function umkm()
    {
        return $this->hasOne(Umkm::class, 'id', 'id');
    }
    public function konsultan()
    {
        return $this->hasOne(Konsultan::class, 'id', 'id');
    }
    public function admin()
    {
        return $this->hasOne(Admin::class, 'id', 'id');
    }
    public function kepalaUPTD()
    {
        return $this->hasOne(KepalaUPTD::class, 'id', 'id');
    }

}
