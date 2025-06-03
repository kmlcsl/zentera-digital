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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // setting key
            $table->text('value')->nullable(); // setting value
            $table->string('type')->default('text'); // text, boolean, json, etc
            $table->string('group')->default('general'); // business, social, website, etc
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index(['key', 'group']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
