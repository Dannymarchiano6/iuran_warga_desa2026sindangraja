<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KartuKeluargaController;

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
Route::middleware('auth')->group(function () {

    // PANEL ADMIN
    Route::prefix('admin')->name('admin.')->group(function () {
        // ...

        // CRUD Data KK
        Route::get('/kk', [KartuKeluargaController::class, 'index'])->name('kk.index');
        Route::post('/kk', [KartuKeluargaController::class, 'store'])->name('kk.store');
        Route::put('/kk/{id}', [KartuKeluargaController::class, 'update'])->name('kk.update');
        Route::delete('/kk/{id}', [KartuKeluargaController::class, 'destroy'])->name('kk.destroy');
        Route::post('/kk/anggota', [KartuKeluargaController::class, 'storeAnggota'])->name('kk.store_anggota');
    });

});

// Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
//     // Menu Utama Admin
//     Route::get('/menu-utama', function () {
//         return view('admin.menu_utama');
//     })->name('menu');

//     // Dashboard & Menu Lainnya
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
//     Route::get('/kk', [KartuKeluargaController::class, 'index'])->name('kk.index');
//     Route::get('/users', [UserController::class, 'index'])->name('users.index');
// });
