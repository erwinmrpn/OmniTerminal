<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Batas minimum stok sebelum trigger low stock alert
            $table->integer('threshold_min')->default(10)->after('stock');
            // Status produk aktif/nonaktif
            $table->boolean('is_active')->default(true)->after('threshold_min');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['threshold_min', 'is_active']);
        });
    }
};