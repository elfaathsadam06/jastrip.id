<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
    Schema::create('pesanan', function (Blueprint $table) {
        $table->id(); // PK global

        // PEMILIK
        $table->foreignId('user_id')
            ->constrained('users')
            ->cascadeOnDelete();

        // ORDER NUMBER PER CUSTOMER
        $table->unsignedInteger('order_number');

        // DATA
        $table->string('file_audio');
        $table->integer('durasi');
        $table->decimal('total_biaya', 12, 0);

        // FLAG VERIFIKASI TRANSKRIPTOR
        $table->boolean('need_transkriptor_verification')
            ->default(false);

        // STATUS PESANAN
        $table->enum('status', [
            'waiting_payment',
            'waiting_verification',
            'processing',
            'completed',
            'rejected'
        ])->default('waiting_payment');

        // ADMIN ACTION (AUDIT)
        $table->foreignId('verified_by_admin_id')
            ->nullable()
            ->constrained('users')
            ->nullOnDelete();

        $table->enum('admin_action', [
            'approved',
            'rejected'
        ])->nullable();

        $table->timestamp('verified_at')->nullable();

        // TRANSKRIPTOR
        $table->foreignId('assigned_transkriptor_id')
            ->nullable()
            ->constrained('users')
            ->nullOnDelete();

        $table->enum('status_transkriptor', [
            'waiting',
            'working',
            'submitted',
            'approved'
        ])->nullable();

        $table->timestamps();

        // UNIQUE PER USER
        $table->unique(['user_id', 'order_number']);
    });
}

    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
