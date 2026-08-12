<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UserController; // Fixed: 'user' jadi 'use'

// Halaman utama (langsung redirect ke login)
Route::get('/', function () {
    return redirect()->route('login');
});

// ==========================================
// ROUTE GUEST (Belum Login)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// ==========================================
// ROUTE AUTHENTICATED (Sudah Login)
// ==========================================
Route::middleware('auth')->group(function () {

    // Action Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Route Fallback / Dashboard Umum (Otomatis redirect sesuai role)
    Route::get('/dashboard', function () {
        $role = strtolower(auth()->user()->role ?? '');

        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        if ($role === 'bendahara') {
            return redirect()->route('bendahara.dashboard');
        }

        // Default jika role warga/lainnya
        return redirect()->route('admin.dashboard');
    })->name('dashboard');
    Route::prefix('admin')->name('admin.')->group(function () {
        // Dashboard Admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // CRUD Manajemen User (UserController)
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

        // Route Menu Lainnya (Sesuai Sidebar)
        Route::get('/jenis-iuran', function() { return "Halaman Jenis Iuran"; })->name('jenis_iuran.index');
        Route::get('/kk', [AdminDashboardController::class, 'kk'])->name('kk.index');
        Route::get('/warga', [AdminDashboardController::class, 'warga'])->name('warga.index');
        Route::get('/pembayaran', function() { return "Halaman Pembayaran"; })->name('pembayaran.index');
        Route::get('/laporan', function() { return "Halaman Laporan"; })->name('laporan.index');
        Route::get('/tagihan', function() { return "Halaman Tagihan"; })->name('tagihan.index');
    });

    Route::prefix('bendahara')->name('bendahara.')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard_admin', [
                'totalKK'    => 0,
                'totalWarga' => 0,
                'totalUser'  => 0,
                'wargaBaru'  => collect([])
            ]);
        })->name('dashboard');
    });

});
