<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('hasil_konsultasi', function (Blueprint $table) {
            // Ubah kolom dokumen menjadi longText nullable
            $table->longText('dokumen')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('hasil_konsultasi', function (Blueprint $table) {
            // Jika rollback, ubah lagi ke JSON nullable
            $table->json('dokumen')->nullable()->change();
        });
    }
};
