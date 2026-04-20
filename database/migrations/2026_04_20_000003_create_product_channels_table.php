<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_channels', function (Blueprint $table) {
            $table->id();
            // Relasi ke produk internal
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            // Relasi ke platform e-commerce
            $table->foreignId('channel_id')->constrained('channels')->onDelete('cascade');
            // SKU dari platform (format berbeda tiap platform)
            $table->string('channel_sku', 128);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Satu produk hanya boleh punya satu SKU per channel
            $table->unique(['product_id', 'channel_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_channels');
    }
};