<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use BelongsToTenant; // Otomatis filter per tenant

    protected $fillable = [
        'tenant_id', 'product_id', 'type',
        'quantity', 'stock_before', 'stock_after',
        'notes', 'created_by',
    ];

    // Relasi ke produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi ke user yang melakukan perubahan
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}