<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();

            $table->foreignId('umkm_id')
                  ->constrained('umkm')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('target_id');
            $table->enum('target_type', ['konsultan', 'pembinaan']); // untuk morph

            $table->unsignedTinyInteger('rating'); // 1–5
            $table->text('komentar')->nullable();

            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
