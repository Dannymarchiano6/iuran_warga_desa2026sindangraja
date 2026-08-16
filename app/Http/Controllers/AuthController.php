<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman Form Login
     */
    public function showLoginForm()
    {
        // Jika user sudah login, langsung arahkan ke halaman sesuai role
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return view('auth.login');
    }

    /**
     * Proses Autentikasi Login
     */
    public function login(Request $request)
    {
        // Validasi input dari form login
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Tangkap status "remember me" dari checkbox
        $remember = $request->boolean('remember');

        // Coba lakukan login via Auth Laravel
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect berdasarkan Role
            return $this->redirectBasedOnRole($user)
                ->with('status', 'Berhasil masuk ke sistem.');
        }

        // Jika login gagal
        return back()->withErrors([
            'username' => 'Username atau password yang Anda masukkan salah.',
        ])->onlyInput('username');
    }

    /**
     * Helper Method: Redirect Berdasarkan Role User
     */
    protected function redirectBasedOnRole($user)
    {
        if ($user->role === 'admin') {
            // Arahkan admin langsung ke Portal Menu Utama
            return redirect()->intended(route('admin.menu'));
        }

        if ($user->role === 'bendahara') {
            return redirect()->intended(route('bendahara.dashboard'));
        }

        // Fallback default jika role warga/lainnya
        return redirect()->intended(route('home'));
    }

    /**
     * Tampilkan halaman Form Registrasi
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Proses Registrasi Warga Baru (Tanpa Pilihan Role)
     */
    public function register(Request $request)
    {
        // Validasi input dari form registrasi (Role di-set otomatis)
        $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'username'     => ['required', 'string', 'max:255', 'unique:users,username'],
            'password'     => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'username.required'     => 'Username wajib diisi.',
            'username.unique'       => 'Username ini sudah digunakan, silakan pilih username lain.',
            'password.required'     => 'Password wajib diisi.',
            'password.min'          => 'Password minimal harus 6 karakter.',
            'password.confirmed'    => 'Konfirmasi password tidak cocok.',
        ]);

        // Simpan ke Database (Role default otomatis = 'warga')
        DB::table('users')->insert([
            'nama_lengkap' => $request->nama_lengkap,
            'username'     => $request->username,
            'role'         => 'warga', // Role otomatis diset sebagai warga
            'password'     => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran akun berhasil! Silakan login.');
    }

    /**
     * Proses Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Anda telah berhasil keluar.');
    }
}
