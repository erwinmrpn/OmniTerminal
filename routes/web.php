<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\SuperAdminController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
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
Route::middleware(['auth'])->group(function () {
    
    // ----------------------------------------------------------------
    // 1. TRAFFIC COP (Sistem Redirect Otomatis Berdasarkan Role)
    // ----------------------------------------------------------------
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;

        return match($role) {
            'super_admin' => redirect()->route('superadmin.dashboard'),
            'owner'       => redirect()->route('owner.dashboard'),
            'manager'     => redirect()->route('manager.dashboard'),
            'warehouse'   => redirect()->route('warehouse.dashboard'),
            'marketing'   => redirect()->route('marketing.dashboard'),
            'finance'     => redirect()->route('finance.dashboard'),
            default       => abort(403, 'Role tidak dikenali atau tidak memiliki akses.'),
        };
    })->name('dashboard');

    // ----------------------------------------------------------------
    // 2. HALAMAN DASHBOARD & MANAJEMEN SUPER ADMIN
    // ----------------------------------------------------------------
    Route::get('/super-admin/dashboard', [SuperAdminController::class, 'dashboard'])->name('superadmin.dashboard');
    Route::get('/super-admin/tenants', [SuperAdminController::class, 'tenants'])->name('superadmin.tenants.index');
    Route::get('/super-admin/users', [SuperAdminController::class, 'users'])->name('superadmin.users.index');
    Route::put('/super-admin/tenants/{id}', [SuperAdminController::class, 'updateTenant'])->name('superadmin.tenants.update');
    Route::put('/super-admin/users/{id}', [SuperAdminController::class, 'updateUser'])->name('superadmin.users.update');

    // ----------------------------------------------------------------
    // 3. HALAMAN DASHBOARD SPESIFIK UNTUK MASING-MASING ROLE
    // ----------------------------------------------------------------
    Route::get('/owner/dashboard', function () {
        return Inertia::render('Owner/Dashboard');
    })->name('owner.dashboard');

    Route::get('/manager/dashboard', function () {
        return Inertia::render('Manager/Dashboard');
    })->name('manager.dashboard');

    Route::get('/marketing/dashboard', function () {
        return Inertia::render('Marketing/Dashboard');
    })->name('marketing.dashboard');

    Route::get('/finance/dashboard', function () {
        return Inertia::render('Finance/Dashboard');
    })->name('finance.dashboard');

    Route::get('/warehouse/dashboard', function () {
        return Inertia::render('Warehouse/Dashboard');
    })->name('warehouse.dashboard');

    // ----------------------------------------------------------------
    // 4. MANAJEMEN STAF (KHUSUS OWNER & MANAGER)
    // ----------------------------------------------------------------
   Route::get('/owner/staff', [StaffController::class, 'index'])->name('owner.staff.index');
   Route::post('/owner/staff', [StaffController::class, 'store'])->name('owner.staff.store');
   Route::delete('/owner/staff/{id}', [StaffController::class, 'destroy'])->name('owner.staff.destroy');
   Route::put('/owner/staff/{id}', [StaffController::class, 'update'])->name('owner.staff.update');
   Route::get('/owner/integrations', function () {return Inertia::render('Owner/Partials/Integrations/Index');})->name('owner.integrations');

    // ----------------------------------------------------------------
    // 5. FITUR OPERASIONAL GUDANG (WMS Core)
    // ----------------------------------------------------------------
    // Produk — data read-only dari API e-commerce, hanya threshold yang bisa diubah
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::patch('/products/{id}/threshold', [ProductController::class, 'updateThreshold'])->name('products.threshold');
    
    // [BARU] Rute Placeholder untuk Menu Tambahan WMS (Akan dibuat Controller-nya nanti)
    Route::get('/warehouse/orders', function () { return "Halaman Daftar Orders"; })->name('warehouse.orders');
    Route::get('/warehouse/stock', function () { return "Halaman Stok Gudang"; })->name('warehouse.stock');
    Route::get('/warehouse/history', function () { return "Halaman History Order"; })->name('warehouse.history');
    
});

// Grup Route Profile (Hanya Perlu Login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Load Route Autentikasi Bawaan Laravel Breeze
require __DIR__.'/auth.php';