<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jadwal_pembinaan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('jenis_id')
                  ->constrained('jenis_pembinaan')
                  ->onDelete('cascade');

            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->date('tanggal');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->string('lokasi');
            $table->integer('kuota')->unsigned();

            $table->foreignId('created_by')
                  ->constrained('users')
                  ->onDelete('cascade'); // khusus admin (bisa difilter di level model/logic)

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_pembinaan');
    }
};
