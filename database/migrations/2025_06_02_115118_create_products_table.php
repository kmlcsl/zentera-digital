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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('category'); // websites, wedding, documents, software
            $table->decimal('price', 10, 0)->nullable(); // Harga dalam rupiah
            $table->decimal('original_price', 10, 0)->nullable(); // Harga coret
            $table->json('features')->nullable(); // Array fitur
            $table->string('icon'); // Font Awesome icon class
            $table->string('color'); // Tailwind gradient class
            $table->text('whatsapp_text'); // Template pesan WhatsApp
            $table->boolean('show_price')->default(true); // Tampilkan harga atau tidak
            $table->string('price_label')->nullable(); // Label khusus harga (e.g., "Mulai Rp")
            $table->text('service_note')->nullable(); // Catatan khusus layanan
            $table->boolean('is_active')->default(true); // Status aktif/nonaktif
            $table->boolean('is_featured')->default(true); // Status aktif/nonaktif
            $table->integer('sort_order')->default(0); // Urutan tampil
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
