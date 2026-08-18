@extends('layouts.app')

@section('title', 'Menu Utama Bendahara - Portal Keuangan')

@section('content')
<!-- Topbar Navigation -->
<nav class="fixed top-0 z-30 w-full border-b border-blue-600 bg-blue-600 px-4 py-3 text-white transition-all duration-300 sm:pl-64">
    <div class="flex items-center justify-between">
        <!-- Mobile Sidebar Toggle -->
        <div class="flex items-center justify-start">
            <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center rounded-lg p-2 text-sm text-blue-100 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 sm:hidden">
                <span class="sr-only">Open sidebar</span>
                <i class="bi bi-list text-2xl"></i>
            </button>
            <span class="ml-2 text-base font-semibold text-white sm:text-lg">Portal Keuangan & Kas</span>
        </div>

        <!-- User Info & Logout -->
        <div class="flex items-center gap-3 sm:gap-4">
            <span class="flex items-center text-xs font-medium text-white sm:text-sm">
                <i class="bi bi-person-circle me-1.5 text-base"></i>
                Bendahara: {{ Auth::user()->nama_lengkap ?? Auth::user()->username ?? session('nama', 'Bendahara') }}
            </span>
            <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Keluar dari sistem?')">
                @csrf
                <button type="submit" class="rounded-lg bg-amber-400 px-3 py-1.5 text-xs font-bold text-gray-900 transition-all duration-200 hover:bg-amber-300 hover:shadow-md focus:ring-2 focus:ring-amber-200 active:scale-95">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>

<!-- Sidebar Navigation Bendahara -->
<aside id="logo-sidebar" class="fixed left-0 top-0 z-40 h-screen w-64 -translate-x-full border-r border-gray-800 bg-[#1a1c23] transition-transform duration-300 ease-in-out sm:translate-x-0" aria-label="Sidebar">
    <div class="flex h-full flex-col overflow-y-auto px-0 py-0">
        <!-- Brand -->
        <div class="flex h-[60px] items-center border-b border-white/5 px-6 font-semibold text-white text-lg">
            <i class="bi bi-wallet2 me-2.5 text-blue-500"></i> Master Data Iuran
        </div>

        <!-- Navigation Links -->
        <div class="flex-1 space-y-1 py-4">
            <div class="px-6 pb-2 text-[0.65rem] font-bold uppercase tracking-wider text-[#4e5d78]">
                Menu Utama
            </div>

            <a href="{{ route('bendahara.menu') }}" class="flex items-center px-6 py-3 text-sm font-medium transition-colors duration-200 {{ request()->routeIs('bendahara.menu') ? 'bg-blue-600 text-white' : 'text-[#9ea4b0] hover:bg-white/5 hover:text-white' }}">
                <i class="bi bi-grid-fill me-3.5 text-lg"></i> Menu Utama
            </a>

            <a href="{{ route('bendahara.dashboard') }}" class="flex items-center px-6 py-3 text-sm font-medium text-[#9ea4b0] transition-colors duration-200 hover:bg-white/5 hover:text-white">
                <i class="bi bi-house-door me-3.5 text-lg"></i> Dashboard Stats
            </a>

            <a href="{{ route('bendahara.jenis_iuran.index') }}" class="flex items-center px-6 py-3 text-sm font-medium text-[#9ea4b0] transition-colors duration-200 hover:bg-white/5 hover:text-white">
                <i class="bi bi-tags me-3.5 text-lg"></i> Jenis Iuran
            </a>

            <a href="{{ route('bendahara.pembayaran.index') }}" class="flex items-center px-6 py-3 text-sm font-medium text-[#9ea4b0] transition-colors duration-200 hover:bg-white/5 hover:text-white">
                <i class="bi bi-credit-card-2-front me-3.5 text-lg"></i> Pembayaran
            </a>

            <a href="{{ route('bendahara.tagihan.index') }}" class="flex items-center px-6 py-3 text-sm font-medium text-[#9ea4b0] transition-colors duration-200 hover:bg-white/5 hover:text-white">
                <i class="bi bi-cash-stack me-3.5 text-lg"></i> Tagihan
            </a>

            <a href="{{ route('bendahara.laporan.index') }}" class="flex items-center px-6 py-3 text-sm font-medium text-[#9ea4b0] transition-colors duration-200 hover:bg-white/5 hover:text-white">
                <i class="bi bi-bar-chart-line me-3.5 text-lg"></i> Laporan
            </a>

            <a href="{{ route('bendahara.pengeluaran.index') }}" class="flex items-center px-6 py-3 text-sm font-medium text-[#9ea4b0] transition-colors duration-200 hover:bg-white/5 hover:text-white">
                <i class="bi bi-graph-down-arrow me-3.5 text-lg"></i> Pengeluaran
            </a>

            <a href="{{ route('bendahara.pemasukan.index') }}" class="flex items-center px-6 py-3 text-sm font-medium text-[#9ea4b0] transition-colors duration-200 hover:bg-white/5 hover:text-white">
                <i class="bi bi-graph-up-arrow me-3.5 text-lg"></i> Pemasukan
            </a>
        </div>
    </div>
</aside>

<!-- Main Body Area -->
<div class="min-h-screen bg-[#f4f7f6] pt-[60px] transition-all duration-300 sm:ml-64">
    <!-- Header Page Banner -->
    <div class="p-6 sm:px-8 sm:py-7">
        <h2 class="text-2xl font-bold text-gray-800">Selamat Datang, Bendahara</h2>
        <p class="mt-1 text-sm text-gray-500">Pusat pengelolaan pencatatan transaksi iuran, tagihan warga, dan rekapitulasi kas desa.</p>
    </div>

    <!-- Main Content Area -->
    <div class="px-6 pb-8 sm:px-8">

        <!-- Modul Operasional Keuangan Grid (6 Modul Utama) -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">

            <!-- Card 1: Jenis Iuran -->
            <div class="group transform rounded-2xl bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md border border-gray-100 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-purple-100 text-purple-700 text-2xl mb-4 transition-transform duration-300 group-hover:scale-110">
                        <i class="bi bi-tags"></i>
                    </div>
                    <div class="text-xs font-bold uppercase tracking-wider text-gray-400">PENGATURAN KATEGORI</div>
                    <h3 class="mt-1 text-xl font-bold text-gray-900">Jenis Iuran</h3>
                    <p class="mt-2 text-xs text-gray-500 leading-relaxed">
                        Kelola master data jenis iuran bulanan warga, iuran kebersihan, keamanan, dan kegiatan PHBN.
                    </p>
                </div>
                <div class="mt-6 border-t border-gray-100 pt-4">
                    <a href="{{ route('bendahara.jenis_iuran.index') }}" class="inline-flex items-center text-xs font-bold text-purple-600 transition-colors duration-200 hover:text-purple-800">
                        Kelola Jenis Iuran <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <!-- Card 2: Pembayaran -->
            <div class="group transform rounded-2xl bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md border border-gray-100 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 text-2xl mb-4 transition-transform duration-300 group-hover:scale-110">
                        <i class="bi bi-credit-card-2-front"></i>
                    </div>
                    <div class="text-xs font-bold uppercase tracking-wider text-gray-400">TRANSAKSI WARGA</div>
                    <h3 class="mt-1 text-xl font-bold text-gray-900">Pembayaran</h3>
                    <p class="mt-2 text-xs text-gray-500 leading-relaxed">
                        Input transaksi pembayaran iuran warga, verifikasi bukti pembayaran, dan cetak kwitansi lunas.
                    </p>
                </div>
                <div class="mt-6 border-t border-gray-100 pt-4">
                    <a href="{{ route('bendahara.pembayaran.index') }}" class="inline-flex items-center text-xs font-bold text-emerald-600 transition-colors duration-200 hover:text-emerald-800">
                        Kelola Pembayaran <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <!-- Card 3: Tagihan -->
            <div class="group transform rounded-2xl bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md border border-gray-100 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-amber-100 text-amber-700 text-2xl mb-4 transition-transform duration-300 group-hover:scale-110">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div class="text-xs font-bold uppercase tracking-wider text-gray-400">DAFTAR KEWAJIBAN</div>
                    <h3 class="mt-1 text-xl font-bold text-gray-900">Tagihan Iuran</h3>
                    <p class="mt-2 text-xs text-gray-500 leading-relaxed">
                        Pantau daftar tagihan berjalan setiap Kepala Keluarga (KK) serta rincian tunggakan iuran.
                    </p>
                </div>
                <div class="mt-6 border-t border-gray-100 pt-4">
                    <a href="{{ route('bendahara.tagihan.index') }}" class="inline-flex items-center text-xs font-bold text-amber-600 transition-colors duration-200 hover:text-amber-800">
                        Lihat Data Tagihan <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <!-- Card 4: Laporan Kas -->
            <div class="group transform rounded-2xl bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md border border-gray-100 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-sky-100 text-sky-700 text-2xl mb-4 transition-transform duration-300 group-hover:scale-110">
                        <i class="bi bi-bar-chart-line"></i>
                    </div>
                    <div class="text-xs font-bold uppercase tracking-wider text-gray-400">REKAPITULASI DANA</div>
                    <h3 class="mt-1 text-xl font-bold text-gray-900">Laporan Kas</h3>
                    <p class="mt-2 text-xs text-gray-500 leading-relaxed">
                        Cetak rekapitulasi laporan kas bulanan dan tahunan iuran warga ke format file PDF atau Excel.
                    </p>
                </div>
                <div class="mt-6 border-t border-gray-100 pt-4">
                    <a href="{{ route('bendahara.laporan.index') }}" class="inline-flex items-center text-xs font-bold text-sky-600 transition-colors duration-200 hover:text-sky-800">
                        Buka Laporan <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <!-- Card 5: Pengeluaran Kas -->
            <div class="group transform rounded-2xl bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md border border-gray-100 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-rose-100 text-rose-700 text-2xl mb-4 transition-transform duration-300 group-hover:scale-110">
                        <i class="bi bi-graph-down-arrow"></i>
                    </div>
                    <div class="text-xs font-bold uppercase tracking-wider text-gray-400">BEBAN OPERASIONAL</div>
                    <h3 class="mt-1 text-xl font-bold text-gray-900">Pengeluaran</h3>
                    <p class="mt-2 text-xs text-gray-500 leading-relaxed">
                        Pencatatan beban pengeluaran kas desa untuk pemeliharaan fasilitas, acara warga, dan belanja operasional.
                    </p>
                </div>
                <div class="mt-6 border-t border-gray-100 pt-4">
                    <a href="{{ route('bendahara.pengeluaran.index') }}" class="inline-flex items-center text-xs font-bold text-rose-600 transition-colors duration-200 hover:text-rose-800">
                        Data Pengeluaran <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <!-- Card 6: Pemasukan Kas -->
            <div class="group transform rounded-2xl bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md border border-gray-100 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-cyan-100 text-cyan-700 text-2xl mb-4 transition-transform duration-300 group-hover:scale-110">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <div class="text-xs font-bold uppercase tracking-wider text-gray-400">DANA MASUK LAINNYA</div>
                    <h3 class="mt-1 text-xl font-bold text-gray-900">Pemasukan</h3>
                    <p class="mt-2 text-xs text-gray-500 leading-relaxed">
                        Catat pemasukan dana di luar iuran bulanan warga seperti donasi, bantuan pemerintah, atau sponsorship.
                    </p>
                </div>
                <div class="mt-6 border-t border-gray-100 pt-4">
                    <a href="{{ route('bendahara.pemasukan.index') }}" class="inline-flex items-center text-xs font-bold text-cyan-600 transition-colors duration-200 hover:text-cyan-800">
                        Data Pemasukan <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
