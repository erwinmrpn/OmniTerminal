<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class StaffController extends Controller
{
    /**
     * Menampilkan daftar staf dan form tambah staf
     */
    public function index()
    {
        // Ambil ID toko (tenant) dari Owner yang sedang login
        $tenantId = auth()->user()->tenant_id;

        // Ambil semua user di toko ini, KECUALI si Owner itu sendiri
        $staffs = User::where('tenant_id', $tenantId)
                      ->where('id', '!=', auth()->id())
                      ->latest()
                      ->get();

        return Inertia::render('Owner/Staff/Index', [
            'staffs' => $staffs
        ]);
    }

    /**
     * Menyimpan data staf baru ke database
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'password' => ['required', Rules\Password::defaults()],
            'role' => 'required|in:manager,warehouse,marketing,finance',
        ]);

    // 2. Simpan User Baru (Otomatis masuk ke tenant_id yang sama dengan Owner)
    User::create([
        'tenant_id' => auth()->user()->tenant_id,
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        'email_verified_at' => now(), // Langsung verified — staff dibuat oleh owner, bukan self-register
    ]);

        // 3. Kembalikan ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Staf berhasil ditambahkan ke dalam sistem!');
    }
}