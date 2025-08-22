<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('konsultan', function (Blueprint $table) {
            $table->string('nomor_sertifikat')->nullable()->after('sertifikasi');
            $table->date('tanggal_sertifikat')->nullable()->after('nomor_sertifikat');
            $table->string('lembaga')->nullable()->after('tanggal_sertifikat');
            $table->string('file_sertifikat')->nullable()->after('lembaga'); // file path
        });
    }

    public function down(): void
    {
        Schema::table('konsultan', function (Blueprint $table) {
            $table->dropColumn([
                'nomor_sertifikat',
                'tanggal_sertifikat',
                'lembaga',
                'file_sertifikat',
            ]);
        });
    }
};
