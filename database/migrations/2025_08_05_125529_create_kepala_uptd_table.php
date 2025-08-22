<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kepala_uptd', function (Blueprint $table) {
            $table->foreignId('id')
                ->constrained('users')
                ->onDelete('cascade')
                ->primary(); // FK + PK
            $table->string('nip');
            $table->string('jabatan');
            $table->string('foto_profil')->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kepala_uptd');
    }
};
