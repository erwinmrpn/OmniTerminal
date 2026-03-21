<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar produk
     */
    public function index()
    {
        // Jalur sudah disesuaikan ke dalam folder Warehouse
        return Inertia::render('Warehouse/Products/Index', [
            'products' => Product::latest()->get()
        ]);
    }

    /**
     * Menyimpan produk baru
     * (Fitur ini wajib ada karena di web.php ada Route::post('/products'))
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sku' => 'required|unique:products,sku',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        // tenant_id otomatis terisi oleh Trait BelongsToTenant yang kita buat sebelumnya
        Product::create($validated);

        return redirect()->back()->with('message', 'Produk berhasil ditambahkan!');
    }
}