<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_active',
    ];

    // Relasi: Satu Tenant (Toko) memiliki banyak User (Staf/Owner)
    public function users()
    {
        return $this->hasMany(User::class);
    }
}