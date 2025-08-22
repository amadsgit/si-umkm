<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hasil_konsultasi', function (Blueprint $table) {
            $table->id();

            $table->foreignId('jadwal_id')
                ->constrained('jadwal_konsultasi')
                ->onDelete('cascade');

            $table->text('ringkasan');
            $table->text('solusi');

            $table->foreignId('created_by')
                ->constrained('users')
                ->onDelete('cascade'); // hanya konsultan yang create

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_konsultasi');
    }
};
