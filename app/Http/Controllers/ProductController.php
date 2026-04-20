<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar produk milik tenant yang sedang login
     */
    public function index()
    {
        // Jalur sudah disesuaikan ke dalam folder Warehouse
        // TenantScope otomatis filter produk berdasarkan tenant
        return Inertia::render('Warehouse/Products/Index', [
            'products' => Product::with('channels')->latest()->get()
        ]);
    }

    /**
     * Menyimpan produk baru + catat stock movement awal jika stok > 0
     */
    public function store(Request $request)
    {
        $request->validate([
            'sku'           => 'required|unique:products,sku',
            'name'          => 'required|string|max:255',
            'price'         => 'required|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'threshold_min' => 'required|integer|min:0',
            'description'   => 'nullable|string',
        ]);

        // tenant_id otomatis terisi oleh Trait BelongsToTenant
        $product = Product::create([
            'sku'           => $request->sku,
            'name'          => $request->name,
            'price'         => $request->price,
            'stock'         => $request->stock,
            'threshold_min' => $request->threshold_min,
            'description'   => $request->description,
            'is_active'     => true,
        ]);

        // Catat stock movement awal jika stok yang diinput > 0
        if ($request->stock > 0) {
            StockMovement::create([
                'tenant_id'    => auth()->user()->tenant_id,
                'product_id'   => $product->id,
                'type'         => 'in',
                'quantity'     => $request->stock,
                'stock_before' => 0,
                'stock_after'  => $request->stock,
                'notes'        => 'Stok awal saat produk dibuat',
                'created_by'   => auth()->id(),
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Mengupdate data produk + catat stock movement jika stok berubah
     */
    public function update(Request $request, $id)
    {
        // Cari produk — TenantScope otomatis pastikan produk milik tenant ini
        $product = Product::findOrFail($id);

        $request->validate([
            'sku'           => 'required|unique:products,sku,' . $product->id,
            'name'          => 'required|string|max:255',
            'price'         => 'required|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'threshold_min' => 'required|integer|min:0',
            'description'   => 'nullable|string',
        ]);

        $stockLama = $product->stock;
        $stockBaru = $request->stock;

        $product->update([
            'sku'           => $request->sku,
            'name'          => $request->name,
            'price'         => $request->price,
            'stock'         => $stockBaru,
            'threshold_min' => $request->threshold_min,
            'description'   => $request->description,
        ]);

        // Catat stock movement hanya jika stok berubah
        if ($stockLama !== $stockBaru) {
            StockMovement::create([
                'tenant_id'    => auth()->user()->tenant_id,
                'product_id'   => $product->id,
                'type'         => 'adjustment', // Perubahan manual oleh admin
                'quantity'     => abs($stockBaru - $stockLama),
                'stock_before' => $stockLama,
                'stock_after'  => $stockBaru,
                'notes'        => 'Penyesuaian stok manual via edit produk',
                'created_by'   => auth()->id(),
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Menghapus produk (stock movements ikut terhapus via cascade)
     */
    public function destroy($id)
    {
        // TenantScope otomatis pastikan produk milik tenant ini
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus!');
    }
}