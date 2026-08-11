<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController; // Sesuaikan namespace jika ada di subfolder

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

    // --------------------------------------
    // PANEL ADMIN
    // --------------------------------------
    Route::prefix('admin')->name('admin.')->group(function () {
        // Mengarahkan ke controller (yang memanggil view 'admin.dashboard_admin')
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Route Tambahan Admin (Sesuai tautan Sidebar)
        Route::get('/users', [AdminDashboardController::class, 'users'])->name('users.index');
        Route::get('/kk', [AdminDashboardController::class, 'kk'])->name('kk.index');
        Route::get('/warga', [AdminDashboardController::class, 'warga'])->name('warga.index');
    });

    // --------------------------------------
    // PANEL BENDAHARA
    // --------------------------------------
    Route::prefix('bendahara')->name('bendahara.')->group(function () {
        // Render langsung view dashboard_admin.blade.php jika controller khusus bendahara belum ada
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
