<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique(); // ORD-001, ORD-002, etc
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();
            $table->string('service_name'); // Nama layanan yang dipilih
            $table->string('service_category'); // website, wedding, documents, software
            $table->decimal('price', 12, 0); // Harga dalam rupiah
            $table->decimal('discount', 12, 0)->default(0); // Diskon jika ada
            $table->decimal('total_amount', 12, 0); // Total setelah diskon
            $table->enum('status', ['pending', 'confirmed', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->enum('payment_status', ['unpaid', 'partial', 'paid', 'refunded'])->default('unpaid');
            $table->decimal('paid_amount', 12, 0)->default(0); // Jumlah yang sudah dibayar
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->text('requirements')->nullable(); // Requirement khusus customer
            $table->date('deadline')->nullable(); // Target selesai
            $table->datetime('started_at')->nullable(); // Kapan mulai dikerjakan
            $table->datetime('completed_at')->nullable(); // Kapan selesai
            $table->string('assigned_to')->nullable(); // Siapa yang mengerjakan
            $table->json('files')->nullable(); // File-file terkait (upload/download)
            $table->timestamps();

            // Indexes
            $table->index(['status', 'payment_status']);
            $table->index('customer_phone');
            $table->index('service_category');
            $table->index('deadline');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
