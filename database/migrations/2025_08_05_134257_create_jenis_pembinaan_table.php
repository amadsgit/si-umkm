<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jenis_pembinaan', function (Blueprint $table) {
            $table->id();

            $table->enum('nama_pembinaan', ['pelatihan', 'workshop', 'seminar', 'bimbingan']);
            $table->text('deskripsi')->nullable();

            $table->foreignId('created_by')
                ->constrained('users')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_pembinaan');
    }
};
