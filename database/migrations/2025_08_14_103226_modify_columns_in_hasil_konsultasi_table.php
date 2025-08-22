<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('hasil_konsultasi', function (Blueprint $table) {
            $table->longText('ringkasan')->change();
            $table->longText('solusi')->change();
            $table->text('dokumen')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('hasil_konsultasi', function (Blueprint $table) {
            $table->text('ringkasan')->change();
            $table->text('solusi')->change();
            $table->text('dokumen')->nullable()->change();
        });
    }
};
