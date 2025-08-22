<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('umkm', function (Blueprint $table) {
            $table->foreignId('id')
                ->constrained('users')
                ->onDelete('cascade')
                ->primary(); // FK + PK
            $table->string('nama_usaha');
            $table->string('bidang_usaha');
            $table->text('alamat_usaha');
            $table->integer('tahun_berdiri');
            $table->string('foto_profil')->nullable();
            $table->enum('kategori_usaha', ['mikro', 'kecil', 'menengah']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('umkm');
    }
};
