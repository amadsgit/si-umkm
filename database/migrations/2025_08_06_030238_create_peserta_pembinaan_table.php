<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('peserta_pembinaan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pembinaan_id')
                  ->constrained('jadwal_pembinaan')
                  ->onDelete('cascade');

            $table->foreignId('umkm_id')
                  ->constrained('umkm')
                  ->onDelete('cascade');

            $table->enum('status_kehadiran', ['hadir', 'tidak_hadir', 'izin', 'belum_absensi'])->default('belum_absensi');

            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peserta_pembinaan');
    }
};
