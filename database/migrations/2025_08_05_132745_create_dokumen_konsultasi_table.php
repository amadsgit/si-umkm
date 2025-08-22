<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dokumen_konsultasi', function (Blueprint $table) {
            $table->id();

            $table->foreignId('hasil_id')
                ->constrained('hasil_konsultasi')
                ->onDelete('cascade');

            $table->string('nama_file');
            $table->string('path_file');
            $table->string('tipe_file');
            $table->unsignedBigInteger('size');
            $table->timestamp('uploaded_at');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_konsultasi');
    }
};
