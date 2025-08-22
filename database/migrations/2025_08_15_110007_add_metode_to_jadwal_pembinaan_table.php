<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('jadwal_pembinaan', function (Blueprint $table) {
            $table->enum('metode', ['offline', 'online'])
                  ->default('offline')
                  ->after('kuota');
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_pembinaan', function (Blueprint $table) {
            $table->dropColumn('metode');
        });
    }
};
