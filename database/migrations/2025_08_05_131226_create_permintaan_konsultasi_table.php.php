<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('permintaan_konsultasi', function (Blueprint $table) {
            $table->id();

            $table->foreignId('umkm_id')
                ->constrained('umkm')
                ->onDelete('cascade');

            $table->foreignId('topik_id')
                ->constrained('topik_konsultasi')
                ->onDelete('cascade');

            $table->foreignId('konsultan_id')
                ->nullable()
                ->constrained('konsultan')
                ->onDelete('set null');

            $table->dateTime('preferensi_tanggal');
            $table->text('deskripsi_masalah')->nullable();
            $table->enum('status', ['pending', 'disetujui', 'ditolak', 'selesai'])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permintaan_konsultasi');
    }
};
