<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController; // TAMBAHKAN INI DI ATAS
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Welcome (Landing Page)
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Grup Route yang Memerlukan Login (Auth) & Verifikasi Email
Route::middleware(['auth', 'verified'])->group(function () {
    
    // ----------------------------------------------------------------
    // 1. TRAFFIC COP (Sistem Redirect Otomatis Berdasarkan Role)
    // ----------------------------------------------------------------
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;

        return match($role) {
            'super_admin' => redirect()->route('superadmin.dashboard'),
            'owner'       => redirect()->route('owner.dashboard'),
            'manager'     => redirect()->route('manager.dashboard'),
            'warehouse'   => redirect()->route('products.index'), // Khusus Gudang, langsung lempar ke halaman Produk
            'marketing'   => redirect()->route('marketing.dashboard'),
            'finance'     => redirect()->route('finance.dashboard'), // BARIS BARU DITAMBAHKAN
            default       => abort(403, 'Role tidak dikenali atau tidak memiliki akses.'),
        };
    })->name('dashboard');

    // ----------------------------------------------------------------
    // 2. HALAMAN DASHBOARD SPESIFIK UNTUK MASING-MASING ROLE
    // ----------------------------------------------------------------
    Route::get('/super-admin/dashboard', function () {
        return Inertia::render('SuperAdmin/Dashboard');
    })->name('superadmin.dashboard');

    Route::get('/owner/dashboard', function () {
        return Inertia::render('Owner/Dashboard');
    })->name('owner.dashboard');

    Route::get('/manager/dashboard', function () {
        return Inertia::render('Manager/Dashboard');
    })->name('manager.dashboard');

    Route::get('/marketing/dashboard', function () {
        return Inertia::render('Marketing/Dashboard');
    })->name('marketing.dashboard');

    // BARIS BARU DITAMBAHKAN UNTUK FINANCE
    Route::get('/finance/dashboard', function () {
        return Inertia::render('Finance/Dashboard');
    })->name('finance.dashboard');

    // ----------------------------------------------------------------
    // 3. MASTER DATA PRODUK (WMS Core)
    // ----------------------------------------------------------------
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');

    // ----------------------------------------------------------------
    // 4. MANAJEMEN STAF (KHUSUS OWNER & MANAGER)
    // ----------------------------------------------------------------
    Route::get('/owner/staff', [StaffController::class, 'index'])->name('owner.staff.index');
    Route::post('/owner/staff', [StaffController::class, 'store'])->name('owner.staff.store');
    
});

// Grup Route Profile (Hanya Perlu Login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Load Route Autentikasi Bawaan Laravel Breeze
require __DIR__.'/auth.php';