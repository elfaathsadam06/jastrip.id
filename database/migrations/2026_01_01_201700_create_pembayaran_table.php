<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
    Schema::create('pembayaran', function (Blueprint $table) {
        $table->id();

        $table->foreignId('pesanan_id')
            ->constrained('pesanan') // 🔥 PENTING
            ->cascadeOnDelete();

        $table->string('method'); // bca, mandiri, qris
        $table->string('bukti')->nullable();
        $table->decimal('amount', 12, 0);

        $table->enum('status', [
            'pending',
            'approved',
            'rejected'
        ])->default('pending');

        $table->timestamp('paid_at')->nullable();

        $table->timestamps();
    });

    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};

