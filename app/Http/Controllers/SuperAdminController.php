<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class SuperAdminController extends Controller
{
    /**
     * Menampilkan Dashboard Super Admin beserta data Tenant dan Users
     */
    public function dashboard()
    {
        // Ambil semua tenant beserta jumlah user di dalamnya
        $tenants = Tenant::withCount('users')->latest()->get();
        
        // Ambil semua user (kecuali Super Admin) beserta nama Tenant-nya
        $users = User::with('tenant')
                     ->where('role', '!=', 'super_admin')
                     ->latest()
                     ->get();

        return Inertia::render('SuperAdmin/Dashboard', [
            'tenants' => $tenants,
            'users' => $users,
        ]);
    }

    /**
     * Memperbarui data Tenant (Edit Nama & Status Aktif/Blokir)
     */
    public function updateTenant(Request $request, $id)
    {
        $tenant = Tenant::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'required|boolean', // true = aktif, false = diblokir
        ]);

        $tenant->update([
            'name' => $request->name,
            'is_active' => $request->is_active,
        ]);

        return redirect()->back()->with('success', 'Data Tenant berhasil diperbarui!');
    }

    /**
     * Memperbarui data Login User (Edit Nama, Email & Reset Password)
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            // Validasi email agar unik, tapi abaikan jika emailnya milik user ini sendiri
            'email' => 'required|email|max:255|unique:users,email,' . $id, 
            'password' => 'nullable|min:8', // Password opsional, diisi jika ingin reset
        ]);

        $dataToUpdate = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Jika form password diisi, maka hash dan masukkan ke data update
        if ($request->filled('password')) {
            $dataToUpdate['password'] = Hash::make($request->password);
        }

        $user->update($dataToUpdate);

        return redirect()->back()->with('success', 'Data Login User berhasil diperbarui!');
    }
}