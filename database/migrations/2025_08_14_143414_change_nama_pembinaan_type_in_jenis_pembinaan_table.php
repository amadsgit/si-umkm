<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     public function up(): void
    {
        // Ubah kolom enum menjadi text
        Schema::table('jenis_pembinaan', function (Blueprint $table) {
            $table->text('nama_pembinaan')->change();
        });
    }

    public function down(): void
    {
        // Kembalikan lagi ke enum (sesuaikan dengan value enum lama)
        Schema::table('jenis_pembinaan', function (Blueprint $table) {
            $table->enum('nama_pembinaan', ['pelatihan', 'workshop', 'seminar', 'bimbingan', 'pendampingan'])
                  ->change();
        });
    }
};
