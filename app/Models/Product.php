<?php

namespace App\Models;

use App\Traits\BelongsToTenant; // Import Trait sakti kita
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use BelongsToTenant; // Pasang di sini

    protected $fillable = ['tenant_id', 'sku', 'name', 'description', 'price', 'stock'];
}