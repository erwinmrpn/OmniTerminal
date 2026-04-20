<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductChannel extends Model
{
    protected $fillable = [
        'product_id', 'channel_id', 'channel_sku', 'is_active',
    ];

    // Relasi balik ke produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi balik ke channel
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}