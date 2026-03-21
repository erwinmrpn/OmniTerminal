<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Super Admin (Anda sendiri) - Tanpa Tenant
        User::create([
            'name' => 'Erwin Super Admin',
            'email' => 'erwin.admin@omniterminal.com',
            'password' => Hash::make('admin123'),
            'role' => 'super_admin',
            'tenant_id' => null, // Bebas akses ke semua
        ]);

        // 2. Buat Data Toko Pertama (Klien)
        $tenant = Tenant::create([
            'name' => 'Tradyn Store Official',
            'is_active' => true,
        ]);

        // 3. Buat Akun Owner untuk Toko Tersebut
        User::create([
            'tenant_id' => $tenant->id,
            'name' => 'Bos Tradyn',
            'email' => 'owner@tradyn.com',
            'password' => Hash::make('admin123'),
            'role' => 'owner',
        ]);
    }
}