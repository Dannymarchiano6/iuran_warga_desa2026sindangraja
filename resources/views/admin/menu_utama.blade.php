<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Pengelola - Sistem Iuran Desa Sindangraja</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
        .hover-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .hover-card:hover { transform: translateY(-8px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.04); }
    </style>
</head>
<body class="bg-slate-50 font-sans text-slate-900 flex flex-col min-h-screen">

    <!-- 1. TOP NAVBAR ADMIN -->
    <nav class="sticky top-0 z-50 bg-slate-900 border-b border-slate-800 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Brand Logo & Title -->
                <div class="flex items-center space-x-3">
                    <div class="bg-indigo-600 text-white p-2 rounded-xl flex items-center justify-center shadow-md shadow-indigo-500/30">
                        <i class="bi bi-shield-lock-fill text-xl"></i>
                    </div>
                    <span class="text-lg font-bold tracking-tight">SI-IURAN <span class="text-indigo-400">ADMIN</span></span>
                </div>

                <!-- Topbar Navigation Links -->
                <div class="hidden md:flex items-center space-x-6 text-sm font-medium">
                    <a href="{{ route('admin.dashboard') }}" class="text-slate-300 hover:text-white transition-colors flex items-center gap-1.5">
                        <i class="bi bi-speedometer2 text-indigo-400"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.kk.index') }}" class="text-slate-300 hover:text-white transition-colors flex items-center gap-1.5">
                        <i class="bi bi-journal-bookmark text-indigo-400"></i> Data KK
                    </a>
                    <a href="{{ route('admin.warga.index') }}" class="text-slate-300 hover:text-white transition-colors flex items-center gap-1.5">
                        <i class="bi bi-people text-indigo-400"></i> Data Warga
                    </a>
                    <a href="#lokasi-kantor" class="text-slate-300 hover:text-white transition-colors flex items-center gap-1.5">
                        <i class="bi bi-geo-alt text-indigo-400"></i> Info Desa
                    </a>
                </div>

                <!-- User Profile & Logout -->
                <div class="flex items-center space-x-4">
                    <div class="hidden sm:flex items-center space-x-3 text-right">
                        <div>
                            <div class="text-xs font-bold text-white leading-none">{{ Auth::user()->nama_lengkap ?? 'Administrator' }}</div>
                            <div class="text-[0.65rem] text-indigo-300 font-semibold uppercase mt-0.5">Admin Pengelola</div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Keluar dari portal pengelola?')">
                        @csrf
                        <button type="submit" class="bg-red-500/20 text-red-400 hover:bg-red-500 hover:text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-all border border-red-500/30 flex items-center gap-1.5">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- 2. HERO BANNER SECTION (Theme: Admin Control Panel) -->
    <header class="relative bg-slate-900 py-12 lg:py-16 overflow-hidden border-b border-slate-800">
        <!-- Accent Glow Spheres -->
        <div class="absolute -top-24 -left-20 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-20 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="text-center md:text-left">
                    <span class="inline-block bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 text-xs font-bold px-3.5 py-1 rounded-full mb-3 tracking-wide uppercase">
                        Selamat Datang, Admin
                    </span>
                    <h1 class="text-2xl sm:text-4xl font-extrabold text-white tracking-tight">Portal Navigasi Administrator</h1>
                    <p class="text-slate-400 text-sm sm:text-base mt-2 max-w-xl">
                        Pusat kendali data kependudukan, pengolahan transaksi kas iuran desa, serta pengaturan akses pengguna sistem Sindangraja.
                    </p>
                </div>
                <!-- Quick Metric Badge -->
                <div class="flex gap-3 bg-slate-800/80 backdrop-blur-md p-3.5 rounded-2xl border border-slate-700/60 shadow-xl">
                    <div class="px-4 py-2 text-center border-r border-slate-700">
                        <div class="text-xs text-slate-400 font-medium">Status Sistem</div>
                        <div class="text-sm font-bold text-emerald-400 flex items-center justify-center gap-1 mt-0.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Aktif
                        </div>
                    </div>
                    <div class="px-4 py-2 text-center">
                        <div class="text-xs text-slate-400 font-medium">Hak Akses</div>
                        <div class="text-sm font-bold text-indigo-400 mt-0.5">Full Administrator</div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- 3. MAIN CONTENT AREA (GRID MENU UTAMA) -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 flex-1">

        <div class="mb-8">
            <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                <i class="bi bi-grid-3x3-gap-fill text-indigo-600"></i> Modul Navigasi Utama
            </h2>
            <p class="text-xs text-slate-500 mt-0.5">Pilih salah satu layanan di bawah ini untuk mengelola operasional desa.</p>
        </div>

        <!-- Service / Feature Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">

            <!-- Card 1: Dashboard Stats -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover-card flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mb-4 text-2xl border border-indigo-100">
                        <i class="bi bi-speedometer2"></i>
                    </div>
                    <h3 class="font-bold text-lg text-slate-800 mb-1">Dashboard Statistik</h3>
                    <p class="text-slate-500 text-xs leading-relaxed mb-6">Pantau grafik kependudukan, statistik total KK, jumlah warga terdaftar, dan ringkasan kas.</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 rounded-xl font-semibold text-xs transition text-center flex items-center justify-center gap-2 shadow-md shadow-indigo-600/20">
                    Buka Dashboard <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <!-- Card 2: Data KK -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover-card flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center mb-4 text-2xl border border-emerald-100">
                        <i class="bi bi-journal-bookmark"></i>
                    </div>
                    <h3 class="font-bold text-lg text-slate-800 mb-1">Data Kartu Keluarga</h3>
                    <p class="text-slate-500 text-xs leading-relaxed mb-6">Kelola nomor KK, entri alamat rumah tangga, pengeditan data keluarga, dan hapus berkas KK.</p>
                </div>
                <a href="{{ route('admin.kk.index') }}" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-2.5 rounded-xl font-semibold text-xs transition text-center flex items-center justify-center gap-2 shadow-md shadow-emerald-600/20">
                    Kelola Data KK <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <!-- Card 3: Data Warga -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover-card flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 bg-sky-50 text-sky-600 rounded-xl flex items-center justify-center mb-4 text-2xl border border-sky-100">
                        <i class="bi bi-people"></i>
                    </div>
                    <h3 class="font-bold text-lg text-slate-800 mb-1">Data Kependudukan</h3>
                    <p class="text-slate-500 text-xs leading-relaxed mb-6">Manajemen NIK warga, status dalam keluarga, nomor telepon, dan pencarian cepat data warga.</p>
                </div>
                <a href="{{ route('admin.warga.index') }}" class="w-full bg-sky-600 hover:bg-sky-700 text-white py-2.5 rounded-xl font-semibold text-xs transition text-center flex items-center justify-center gap-2 shadow-md shadow-sky-600/20">
                    Kelola Warga <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <!-- Card 4: Pembayaran & Kas -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover-card flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center mb-4 text-2xl border border-amber-100">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <h3 class="font-bold text-lg text-slate-800 mb-1">Transaksi Pembayaran</h3>
                    <p class="text-slate-500 text-xs leading-relaxed mb-6">Catat iuran bulanan warga, validasi bukti transfer, serta pencetakan kwitansi digital.</p>
                </div>
                <a href="{{ route('admin.pembayaran.index') }}" class="w-full bg-amber-500 hover:bg-amber-600 text-white py-2.5 rounded-xl font-semibold text-xs transition text-center flex items-center justify-center gap-2 shadow-md shadow-amber-500/20">
                    Kelola Pembayaran <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <!-- Card 5: Laporan & Kas -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover-card flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center mb-4 text-2xl border border-purple-100">
                        <i class="bi bi-file-earmark-bar-graph"></i>
                    </div>
                    <h3 class="font-bold text-lg text-slate-800 mb-1">Laporan & Kas Desa</h3>
                    <p class="text-slate-500 text-xs leading-relaxed mb-6">Rekapitulasi tahunan kas desa, laporan tunggakan iuran warga, dan ekspor laporan ke PDF/Excel.</p>
                </div>
                <a href="{{ route('admin.laporan.index') }}" class="w-full bg-purple-600 hover:bg-purple-700 text-white py-2.5 rounded-xl font-semibold text-xs transition text-center flex items-center justify-center gap-2 shadow-md shadow-purple-600/20">
                    Buka Laporan <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <!-- Card 6: Manajemen User -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover-card flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center mb-4 text-2xl border border-rose-100">
                        <i class="bi bi-person-gear"></i>
                    </div>
                    <h3 class="font-bold text-lg text-slate-800 mb-1">Manajemen User</h3>
                    <p class="text-slate-500 text-xs leading-relaxed mb-6">Kelola hak akses akun login untuk Administrator, Bendahara desa, maupun Ketua RT/RW.</p>
                </div>
                <a href="{{ route('admin.users.index') }}" class="w-full bg-rose-600 hover:bg-rose-700 text-white py-2.5 rounded-xl font-semibold text-xs transition text-center flex items-center justify-center gap-2 shadow-md shadow-rose-600/20">
                    Kelola User Sistem <i class="bi bi-arrow-right"></i>
                </a>
            </div>

        </div>

        <!-- 4. SECTION INFO KANTOR & MAPS EMBED -->
        <div id="lokasi-kantor" class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/80 shadow-sm">
            <div>
                <span class="text-xs font-bold text-indigo-600 uppercase tracking-wider">Pusat Informasi</span>
                <h2 class="text-2xl font-bold text-slate-800 mt-1 mb-4">Lokasi Sekretariat & Kantor Desa</h2>
                <p class="text-slate-600 text-xs sm:text-sm mb-6 leading-relaxed">
                    Pengelolaan data administrasi dan rekonsiliasi kas iuran warga berpusat di Kantor Desa Sindangraja. Untuk kendala teknis sistem atau verifikasi dokumen fisik, silakan kunjungi kantor operasional.
                </p>
                <div class="space-y-3 mb-6 text-xs sm:text-sm">
                    <div class="flex items-center text-slate-700"><i class="bi bi-geo-alt-fill text-indigo-600 me-3 text-lg"></i> <span>Desa Sindangraja, Kec. Sukaluyu, Kab. Cianjur, Jawa Barat</span></div>
                    <div class="flex items-center text-slate-700"><i class="bi bi-clock-fill text-indigo-600 me-3 text-lg"></i> <span>Jam Operasional: Senin - Jumat (08.00 - 15.30 WIB)</span></div>
                    <div class="flex items-center text-slate-700"><i class="bi bi-telephone-fill text-indigo-600 me-3 text-lg"></i> <span>(0263) 12345678 / Support IT Desa</span></div>
                </div>
                <a href="https://maps.google.com/?q=Sindangraja+Sukaluyu+Cianjur" target="_blank" class="inline-flex items-center gap-2 bg-slate-900 text-white font-semibold text-xs px-4 py-2.5 rounded-xl hover:bg-slate-800 transition shadow-md">
                    <i class="bi bi-box-arrow-up-right"></i> Petunjuk Arah Google Maps
                </a>
            </div>

            <!-- Google Maps Interactive iFrame -->
            <div class="relative w-full h-72 rounded-2xl overflow-hidden shadow-inner border border-slate-200">
                <iframe
                    class="w-full h-full border-0"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.571431057497!2d107.1953!3d-6.8219!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68525e98544c01%3A0x501e8f1fc9717e0!2sSindangraja%2C%20Kec.%20Sukaluyu%2C%20Kabupaten%20Cianjur%2C%20Jawa%20Barat!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>

    </main>

    <!-- 5. FOOTER ADMIN PORTAL -->
    <footer class="bg-slate-900 text-slate-400 py-8 border-t border-slate-800 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs">
            <div class="flex items-center space-x-2">
                <div class="w-6 h-6 rounded-md bg-indigo-600 text-white flex items-center justify-center font-bold text-xs">S</div>
                <span class="font-semibold text-white">Sistem Informasi Iuran Desa Sindangraja</span>
            </div>
            <div>
                &copy; 2026 Admin Panel Desa Sindangraja. All rights reserved.
            </div>
            <div class="flex space-x-4 text-slate-400">
                <a href="#" class="hover:text-white transition">Panduan Sistem</a>
                <span>&middot;</span>
                <a href="#" class="hover:text-white transition">Bantuan IT</a>
            </div>
        </div>
    </footer>

</body>
</html>
