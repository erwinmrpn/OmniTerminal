<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable = ['code', 'name', 'is_active'];

    // Relasi ke produk melalui product_channels
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_channels')
                    ->withPivot('channel_sku', 'is_active')
                    ->withTimestamps();
    }
}