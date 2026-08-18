<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KartuKeluargaController;
use App\Http\Middleware\PreventBackHistory;

/*
|--------------------------------------------------------------------------
| 1. ROUTE PUBLIC / GUEST (Belum Login)
|--------------------------------------------------------------------------
*/

// Halaman Utama / Landing Page Warga (Target utama jika tombol Back ditekan setelah Logout)
Route::get('/', function () {
    return view('warga.home');
})->name('public.home');

Route::middleware('guest')->group(function () {
    // Auth Routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});


/*
|--------------------------------------------------------------------------
| 2. ROUTE AUTHENTICATED (Sudah Login + Proteksi Anti Back-Cache)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', PreventBackHistory::class])->group(function () {

    // Action Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Route Fallback / Dashboard Umum (Otomatis redirect sesuai role ke Menu Utama masing-masing)
    Route::get('/dashboard', function () {
        $role = strtolower(auth()->user()->role ?? '');

        if ($role === 'admin') {
            return redirect()->route('admin.menu');
        }
        if ($role === 'bendahara') {
            return redirect()->route('bendahara.menu');
        }

        return redirect()->route('home');
    })->name('dashboard');

    // Home Warga Terautentikasi
    Route::get('/home', function () {
        return view('warga.home');
    })->name('home');

    /*
    |--------------------------------------------------------------------------
    | A. PANEL ADMIN (Prefix: /admin, Name: admin.*)
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->group(function () {
        // Portal Menu Utama Admin (Views: resources/views/admin/menu_utama.blade.php)
        Route::get('/menu-utama', function () {
            return view('admin.menu_utama');
        })->name('menu');

        // Dashboard Stats Admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // CRUD Manajemen User (UserController)
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

        // CRUD Data KK & Anggota Warga (KartuKeluargaController)
        Route::get('/kk', [KartuKeluargaController::class, 'index'])->name('kk.index');
        Route::post('/kk', [KartuKeluargaController::class, 'store'])->name('kk.store');
        Route::put('/kk/{id}', [KartuKeluargaController::class, 'update'])->name('kk.update');
        Route::delete('/kk/{id}', [KartuKeluargaController::class, 'destroy'])->name('kk.destroy');
        Route::post('/kk/anggota', [KartuKeluargaController::class, 'storeAnggota'])->name('kk.store_anggota');

        // Route Menu Tambahan Admin
        Route::get('/warga', [AdminDashboardController::class, 'warga'])->name('warga.index');
        Route::get('/jenis-iuran', function() { return "Halaman Jenis Iuran"; })->name('jenis_iuran.index');
        Route::get('/pembayaran', function() { return "Halaman Pembayaran"; })->name('pembayaran.index');
        Route::get('/laporan', function() { return "Halaman Laporan"; })->name('laporan.index');
        Route::get('/tagihan', function() { return "Halaman Tagihan"; })->name('tagihan.index');
    });

    /*
    |--------------------------------------------------------------------------
    | B. PANEL BENDAHARA (Prefix: /bendahara, Name: bendahara.*)
    |--------------------------------------------------------------------------
    */
    Route::prefix('bendahara')->name('bendahara.')->group(function () {

        // Portal Menu Utama Bendahara (Views: resources/views/bendahara/menu_utama_bendahara.blade.php)
        Route::get('/menu-utama', function () {
            return view('bendahara.menu_utama_bendahara');
        })->name('menu');

        // Dashboard Stats Bendahara
        Route::get('/dashboard', function () {
            return view('bendahara.dashboard_bendahara', [
                'totalKK'    => 0,
                'totalWarga' => 0,
                'totalMasuk' => 0,
                'sisaSaldo'  => 0,
                'pembayaran' => collect([])
            ]);
        })->name('dashboard');

        // Rute Modul Keuangan Bendahara
        Route::get('/jenis-iuran', function() { return "Halaman Jenis Iuran"; })->name('jenis_iuran.index');
        Route::get('/pembayaran', function() { return "Halaman Pembayaran"; })->name('pembayaran.index');
        Route::get('/tagihan', function() { return "Halaman Tagihan"; })->name('tagihan.index');
        Route::get('/laporan', function() { return "Halaman Laporan"; })->name('laporan.index');
        Route::get('/pengeluaran', function() { return "Halaman Pengeluaran"; })->name('pengeluaran.index');
        Route::get('/pemasukan', function() { return "Halaman Pemasukan"; })->name('pemasukan.index');
    });

});
