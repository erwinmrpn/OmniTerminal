<?php

namespace App\Models;

use App\Traits\BelongsToTenant; // Import Trait sakti kita
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use BelongsToTenant; // Pasang di sini

    protected $fillable = [
        'tenant_id', 'sku', 'name', 'description',
        'price', 'stock', 'threshold_min', 'is_active',
    ];

    // Relasi ke tabel product_channels (mapping ke platform e-commerce)
    public function productChannels()
    {
        return $this->hasMany(ProductChannel::class);
    }

    // Relasi ke tabel channels melalui product_channels
    public function channels()
    {
        return $this->belongsToMany(Channel::class, 'product_channels')
                    ->withPivot('channel_sku', 'is_active')
                    ->withTimestamps();
    }
}