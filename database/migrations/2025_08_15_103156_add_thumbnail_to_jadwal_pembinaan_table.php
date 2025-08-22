<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_pembinaan', function (Blueprint $table) {
            // Thumbnail gambar
            $table->string('thumbnail')
                  ->after('kuota')
                  ->nullable(); // default null
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_pembinaan', function (Blueprint $table) {
            $table->dropColumn('thumbnail');
        });
    }
};
