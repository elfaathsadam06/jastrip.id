<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('revisi_transkripsi', function (Blueprint $table) {
            $table->id();

            // RELASI KE PESANAN
            $table->foreignId('pesanan_id')
                ->constrained('pesanan')
                ->cascadeOnDelete();

            // RELASI KE TRANSKRIPSI (INI YANG SEBELUMNYA BIKIN ERROR)
            $table->foreignId('transkripsi_id')
                ->constrained('transkripsi')
                ->cascadeOnDelete();

            // TRANSKRIPTOR YANG MEREVISI
            $table->foreignId('transkriptor_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->longText('hasil_revisi');
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        // PENTING: revisi_transkripsi HARUS di-drop lebih dulu
        Schema::dropIfExists('revisi_transkripsi');
    }
};
