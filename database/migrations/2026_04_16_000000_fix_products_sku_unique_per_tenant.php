<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    // Ambil daftar semua index yang ada di tabel products
    $existingIndexes = array_column(Schema::getIndexes('products'), 'name');

    Schema::table('products', function (Blueprint $table) use ($existingIndexes) {
        // Hapus index lama hanya jika masih ada (aman jika sudah dihapus manual)
        if (in_array('products_sku_unique', $existingIndexes)) {
            $table->dropUnique('products_sku_unique');
        }

        // Tambah index baru hanya jika belum ada
        if (!in_array('products_tenant_sku_unique', $existingIndexes)) {
            $table->unique(['tenant_id', 'sku'], 'products_tenant_sku_unique');
        }
    });
}

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Rollback: kembalikan ke unique global
            $table->dropUnique('products_tenant_sku_unique');
            $table->unique('sku', 'products_sku_unique');
        });
    }
};