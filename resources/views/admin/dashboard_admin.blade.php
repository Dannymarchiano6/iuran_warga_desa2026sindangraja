@extends('layouts.app')

@section('title', 'Dashboard Admin - Panel Utama')

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
            <span class="ml-2 text-base font-semibold text-white sm:text-lg">Ringkasan Sistem</span>
        </div>

        <!-- User Info & Logout -->
        <div class="flex items-center gap-3 sm:gap-4">
            <span class="flex items-center text-xs font-medium text-white sm:text-sm">
                <i class="bi bi-person-circle me-1.5 text-base"></i>
                Admin: {{ Auth::user()->nama ?? session('nama', 'Admin') }}
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

<!-- Sidebar Navigation -->
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

            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 text-sm font-medium transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-[#9ea4b0] hover:bg-white/5 hover:text-white' }}">
                <i class="bi bi-grid me-3.5 text-lg"></i> Dashboard
            </a>

            <a href="{{ route('admin.users.index') }}" class="flex items-center px-6 py-3 text-sm font-medium text-[#9ea4b0] transition-colors duration-200 hover:bg-white/5 hover:text-white">
                <i class="bi bi-people me-3.5 text-lg"></i> Manajemen User
            </a>

            <a href="{{ route('admin.kk.index') }}" class="flex items-center px-6 py-3 text-sm font-medium text-[#9ea4b0] transition-colors duration-200 hover:bg-white/5 hover:text-white">
                <i class="bi bi-journal-bookmark me-3.5 text-lg"></i> Data KK
            </a>
        </div>
    </div>
</aside>

<!-- Main Body Area -->
<div class="min-h-screen bg-[#f4f7f6] pt-[60px] transition-all duration-300 sm:ml-64">
    <!-- Header Page -->
    <div class="p-6 sm:px-8 sm:py-7">
        <h2 class="text-2xl font-bold text-gray-800">Selamat Datang, Admin</h2>
        <p class="mt-1 text-sm text-gray-500">Pantau statistik dan data terbaru warga hari ini.</p>
    </div>

    <!-- Main Content Area -->
    <div class="px-6 pb-8 sm:px-8">
        <!-- Metric Cards Grid -->
        <div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-3">

            <!-- Card 1: Total KK -->
            <div class="group transform rounded-2xl bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md border border-gray-100">
                <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-sky-100 text-sky-700 text-2xl mb-4 transition-transform duration-300 group-hover:scale-110">
                    <i class="bi bi-house-door"></i>
                </div>
                <div class="text-xs font-bold uppercase tracking-wider text-gray-400">TOTAL KARTU KELUARGA</div>
                <h2 class="mt-1 text-3xl font-extrabold text-gray-900">{{ $totalKK ?? 0 }}</h2>
                <div class="mt-3">
                    <a href="{{ route('admin.kk.index') }}" class="inline-flex items-center text-xs font-medium text-sky-600 transition-colors duration-200 hover:text-sky-800">
                        Detail KK <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <!-- Card 2: Total Warga -->
            <div class="group transform rounded-2xl bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md border border-gray-100">
                <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 text-2xl mb-4 transition-transform duration-300 group-hover:scale-110">
                    <i class="bi bi-people"></i>
                </div>
                <div class="text-xs font-bold uppercase tracking-wider text-gray-400">TOTAL WARGA TERDAFTAR</div>
                <h2 class="mt-1 text-3xl font-extrabold text-gray-900">{{ $totalWarga ?? 0 }}</h2>
                <div class="mt-3">
                    <a href="{{ route('admin.warga.index') }}" class="inline-flex items-center text-xs font-medium text-emerald-600 transition-colors duration-200 hover:text-emerald-800">
                        Detail Warga <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <!-- Card 3: Total User -->
            <div class="group transform rounded-2xl bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md border border-gray-100">
                <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-purple-100 text-purple-700 text-2xl mb-4 transition-transform duration-300 group-hover:scale-110">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div class="text-xs font-bold uppercase tracking-wider text-gray-400">TOTAL USER SISTEM</div>
                <h2 class="mt-1 text-3xl font-extrabold text-gray-900">{{ $totalUser ?? 0 }}</h2>
                <div class="mt-3">
                    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center text-xs font-medium text-purple-600 transition-colors duration-200 hover:text-purple-800">
                        Kelola Akses <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

        </div>

        <!-- Recent Warga Table Card -->
        <div class="overflow-hidden rounded-2xl bg-white shadow-sm border border-gray-100">
            <!-- Table Header -->
            <div class="flex flex-col gap-3 border-b border-gray-100 bg-white p-5 sm:flex-row sm:items-center sm:justify-between">
                <h6 class="flex items-center text-sm font-bold text-gray-800">
                    <i class="bi bi-clock-history me-2 text-lg text-blue-600"></i> Warga Terbaru yang Ditambahkan
                </h6>
                <a href="{{ route('admin.warga.index') }}" class="inline-flex items-center justify-center rounded-lg border border-gray-200 bg-gray-50 px-3 py-1.5 text-xs font-semibold text-gray-600 transition-colors duration-200 hover:bg-gray-100 hover:text-gray-900">
                    Lihat Semua
                </a>
            </div>

            <!-- Table Responsive Wrapper -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-slate-50 text-[0.7rem] font-bold uppercase tracking-wider text-slate-400">
                        <tr>
                            <th scope="col" class="px-6 py-4">NIK</th>
                            <th scope="col" class="px-6 py-4">NAMA LENGKAP</th>
                            <th scope="col" class="px-6 py-4">NOMOR KK</th>
                            <th scope="col" class="px-6 py-4 text-center">HUBUNGAN</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($wargaBaru as $w)
                            <tr class="transition-colors duration-150 hover:bg-slate-50/70">
                                <td class="whitespace-nowrap px-6 py-4">
                                    <code class="rounded bg-slate-100 px-2 py-1 font-mono text-xs text-slate-700 border border-slate-200">{{ $w->nik }}</code>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 font-semibold text-gray-900">
                                    {{ $w->nama }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-gray-600">
                                    {{ $w->no_kk }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center">
                                    <span class="inline-block rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-xs font-semibold uppercase text-blue-600">
                                        {{ $w->status_keluarga }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-sm text-gray-400">
                                    <i class="bi bi-inbox text-3xl block mb-2 opacity-50"></i>
                                    Belum ada data warga terbaru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
