<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transkripsi', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pesanan_id')
                ->constrained('pesanan')
                ->cascadeOnDelete();

            $table->longText('hasil')->nullable();

            $table->enum('status', [
                'processing',
                'done',
                'failed'
            ])->default('processing');

            $table->text('error_message')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        // AMAN: tidak akan dijalankan sebelum revisi_transkripsi di-drop
        Schema::dropIfExists('transkripsi');
    }
};
