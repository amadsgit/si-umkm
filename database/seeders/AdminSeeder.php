<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'username' => 'admin',
            'email' => 'adminsimpku@gmail.com',
            'phone' => '081286208542',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'last_login' => null,
            'email_verified_at' => Carbon::now(),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
