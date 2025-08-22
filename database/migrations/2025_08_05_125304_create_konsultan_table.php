<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('konsultan', function (Blueprint $table) {
            $table->foreignId('id')
                ->constrained('users')
                ->onDelete('cascade')
                ->primary(); // FK + PK
            $table->string('keahlian');
            $table->string('sertifikasi')->nullable();
            $table->string('foto_profil')->nullable();
            $table->text('bio')->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konsultan');
    }
};
