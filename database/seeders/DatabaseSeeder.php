<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tenant; // <--- INI JANGAN SAMPAI LOLOS
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan tabel kosong dulu sebelum isi agar tidak bentrok
        // (Optional tapi membantu kalau running berkali-kali)
        
        $tenant = Tenant::create([
            'name' => 'Tradyn Store',
            'is_active' => true,
        ]);

        User::create([
            'tenant_id' => $tenant->id,
            'name' => 'Erwin',
            'email' => 'erwinkho2@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'), 
        ]);
    }
}