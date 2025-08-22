<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_pembinaan', function (Blueprint $table) {
            $table->foreignId('topik_pembinaan_id')
                  ->after('jenis_id')
                  ->constrained('topik_pembinaan')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_pembinaan', function (Blueprint $table) {
            $table->dropForeign(['topik_pembinaan_id']);
            $table->dropColumn('topik_pembinaan_id');
        });
    }
};
