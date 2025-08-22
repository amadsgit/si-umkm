<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jadwal_konsultasi', function (Blueprint $table) {
            $table->id();

            $table->foreignId('permintaan_id')
                ->constrained('permintaan_konsultasi')
                ->onDelete('cascade');

            $table->date('tanggal');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->enum('metode', ['online', 'offline']);
            $table->text('lokasi_link');
            $table->enum('status', ['dijadwalkan', 'selesai', 'dibatalkan'])->default('dijadwalkan');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_konsultasi');
    }
};
