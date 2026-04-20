<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar produk dari channel yang dipilih
     * Data produk adalah hasil sync dari API e-commerce (read-only)
     */
    public function index(Request $request)
    {
        // Ambil semua channel aktif untuk ditampilkan sebagai filter/tab
        $channels = Channel::where('is_active', true)->get();

        // Ambil channel yang dipilih dari query param (?channel_id=1)
        $channelId = $request->channel_id;

        // Jika ada filter channel, tampilkan produk dari channel tersebut
        // Jika tidak, tampilkan semua produk milik tenant ini
        $products = Product::with(['productChannels' => function ($q) use ($channelId) {
                        if ($channelId) {
                            // Hanya load channel_sku dari channel yang dipilih
                            $q->where('channel_id', $channelId)->with('channel');
                        } else {
                            $q->with('channel');
                        }
                    }])
                    ->when($channelId, function ($q) use ($channelId) {
                        // Filter: hanya produk yang terdaftar di channel ini
                        $q->whereHas('productChannels', function ($q) use ($channelId) {
                            $q->where('channel_id', $channelId);
                        });
                    })
                    ->latest()
                    ->get();

        return Inertia::render('Warehouse/Products/Index', [
            'products'          => $products,
            'channels'          => $channels,
            'selectedChannelId' => $channelId ? (int) $channelId : null,
        ]);
    }

    /**
     * Update threshold minimum stok produk
     * Ini satu-satunya data yang boleh diubah dari sistem (bukan dari platform)
     */
    public function updateThreshold(Request $request, $id)
    {
        $request->validate([
            // Threshold tidak boleh negatif
            'threshold_min' => 'required|integer|min:0',
        ]);

        // TenantScope otomatis pastikan produk milik tenant yang sedang login
        $product = Product::findOrFail($id);
        $product->update(['threshold_min' => $request->threshold_min]);

        return redirect()->back()->with('success', 'Batas minimum stok berhasil diperbarui.');
    }
}