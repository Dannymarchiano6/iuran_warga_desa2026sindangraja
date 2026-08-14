@extends('layouts.app')

@section('title', 'Dashboard Bendahara - Master Data Iuran')

@section('content')
<!-- Topbar Navigation -->
<nav class="fixed top-0 z-30 w-full border-b border-blue-600 bg-blue-600 px-4 py-2.5 text-white transition-all duration-300 sm:pl-64">
    <div class="flex items-center justify-between">
        <!-- Brand & Mobile Toggle -->
        <div class="flex items-center justify-start">
            <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center rounded-lg p-2 text-sm text-blue-100 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 sm:hidden">
                <span class="sr-only">Open sidebar</span>
                <i class="bi bi-list text-2xl"></i>
            </button>
            <span class="ml-2 text-lg font-bold tracking-wide text-white flex items-center">
                <i class="bi bi-wallet2 me-2"></i> Master Data Iuran
            </span>
        </div>

        <!-- User Info & Logout -->
        <div class="flex items-center gap-3 text-sm">
            <span class="flex items-center text-xs font-medium text-blue-100 sm:text-sm">
                <i class="bi bi-person-circle me-1.5 text-base"></i>
                {{ Auth::user()->nama_lengkap ?? Auth::user()->username ?? 'Bendahara' }}
            </span>
            <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Keluar dari sistem?')">
                @csrf
                <button type="submit" class="rounded-lg bg-amber-400 px-3 py-1.5 text-xs font-bold text-gray-900 transition-all duration-200 hover:bg-amber-300 hover:shadow-md focus:ring-2 focus:ring-amber-200 active:scale-95">
                    Logout <i class="bi bi-box-arrow-right ms-1"></i>
                </button>
            </form>
        </div>
    </div>
</nav>

<!-- Sidebar Navigation -->
<aside id="logo-sidebar" class="fixed left-0 top-0 z-40 h-screen w-64 -translate-x-full border-r border-slate-800 bg-[#1a1d21] transition-transform duration-300 ease-in-out sm:translate-x-0" aria-label="Sidebar">
    <div class="flex h-full flex-col overflow-y-auto px-0 py-0">
        <!-- Menu Label -->
        <div class="flex h-[55px] items-center px-6 text-[0.7rem] font-bold uppercase tracking-wider text-slate-500 border-b border-slate-800/80 mt-[60px] sm:mt-[55px]">
            MENU UTAMA
        </div>

        <!-- Navigation Links -->
        <div class="flex-1 space-y-1 py-3">
            {{-- 1. Dashboard --}}
            <a href="{{ route('bendahara.dashboard') }}" class="flex items-center px-6 py-3 text-sm transition-all duration-200 {{ request()->routeIs('bendahara.dashboard') ? 'bg-blue-600 text-white font-medium border-l-4 border-white' : 'text-slate-400 hover:bg-white/5 hover:text-white border-l-4 border-transparent' }}">
                <i class="bi bi-house-door me-3.5 text-lg"></i> Dashboard
            </a>

            {{-- 2. Jenis Iuran --}}
            <a href="{{ route('bendahara.jenis_iuran.index') }}" class="flex items-center px-6 py-3 text-sm transition-all duration-200 {{ request()->routeIs('bendahara.jenis_iuran.*') ? 'bg-blue-600 text-white font-medium border-l-4 border-white' : 'text-slate-400 hover:bg-white/5 hover:text-white border-l-4 border-transparent' }}">
                <i class="bi bi-tags me-3.5 text-lg"></i> Jenis Iuran
            </a>

            {{-- 3. Pembayaran --}}
            <a href="{{ route('bendahara.pembayaran.index') }}" class="flex items-center px-6 py-3 text-sm transition-all duration-200 {{ request()->routeIs('bendahara.pembayaran.*') ? 'bg-blue-600 text-white font-medium border-l-4 border-white' : 'text-slate-400 hover:bg-white/5 hover:text-white border-l-4 border-transparent' }}">
                <i class="bi bi-credit-card-2-front me-3.5 text-lg"></i> Pembayaran
            </a>

            {{-- 4. Laporan --}}
            <a href="{{ route('bendahara.laporan.index') }}" class="flex items-center px-6 py-3 text-sm transition-all duration-200 {{ request()->routeIs('bendahara.laporan.*') ? 'bg-blue-600 text-white font-medium border-l-4 border-white' : 'text-slate-400 hover:bg-white/5 hover:text-white border-l-4 border-transparent' }}">
                <i class="bi bi-bar-chart-line me-3.5 text-lg"></i> Laporan
            </a>

            {{-- 5. Tagihan --}}
            <a href="{{ route('bendahara.tagihan.index') }}" class="flex items-center px-6 py-3 text-sm transition-all duration-200 {{ request()->routeIs('bendahara.tagihan.*') ? 'bg-blue-600 text-white font-medium border-l-4 border-white' : 'text-slate-400 hover:bg-white/5 hover:text-white border-l-4 border-transparent' }}">
                <i class="bi bi-cash-stack me-3.5 text-lg"></i> Tagihan
            </a>

            {{-- 6. Pengeluaran --}}
            <a href="{{ route('bendahara.pengeluaran.index') }}" class="flex items-center px-6 py-3 text-sm transition-all duration-200 {{ request()->routeIs('bendahara.pengeluaran.*') ? 'bg-blue-600 text-white font-medium border-l-4 border-white' : 'text-slate-400 hover:bg-white/5 hover:text-white border-l-4 border-transparent' }}">
                <i class="bi bi-graph-down-arrow me-3.5 text-lg"></i> Pengeluaran
            </a>

            {{-- 7. Pemasukan --}}
            <a href="{{ route('bendahara.pemasukan.index') }}" class="flex items-center px-6 py-3 text-sm transition-all duration-200 {{ request()->routeIs('bendahara.pemasukan.*') ? 'bg-blue-600 text-white font-medium border-l-4 border-white' : 'text-slate-400 hover:bg-white/5 hover:text-white border-l-4 border-transparent' }}">
                <i class="bi bi-graph-up-arrow me-3.5 text-lg"></i> Pemasukan
            </a>
        </div>
    </div>
</aside>

<!-- Main Body Area -->
<div class="min-h-screen bg-[#f8f9fc] pt-[70px] transition-all duration-300 sm:ml-64 flex flex-col justify-between">
    <div class="p-6 sm:p-8">

        <!-- Header Page & Total Terverifikasi Badge -->
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Ringkasan Kas & Warga</h2>
                <p class="text-xs text-gray-500 mt-1">Update terakhir: {{ now()->translatedFormat('d F Y, H:i') }}</p>
            </div>
            <div class="inline-flex items-center rounded-xl bg-blue-50 border border-blue-100 px-4 py-2.5 text-xs font-extrabold uppercase tracking-wide text-blue-700 shadow-sm">
                TOTAL TERVERIFIKASI: Rp {{ number_format($totalMasuk, 0, ',', '.') }}
            </div>
        </div>

        <!-- Metric Cards Grid (4 Cards) -->
        <div class="mb-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">

            <!-- Card 1: Total KK -->
            <div class="rounded-xl bg-white p-5 shadow-sm border-l-4 border-l-blue-600 border-gray-100 border transition-all duration-200 hover:shadow-md">
                <h6 class="text-xs font-bold uppercase tracking-wider text-gray-400">TOTAL KK</h6>
                <h3 class="mt-2 text-2xl font-extrabold text-gray-900">{{ $totalKK }}</h3>
            </div>

            <!-- Card 2: Total Warga -->
            <div class="rounded-xl bg-white p-5 shadow-sm border-l-4 border-l-emerald-500 border-gray-100 border transition-all duration-200 hover:shadow-md">
                <h6 class="text-xs font-bold uppercase tracking-wider text-gray-400">TOTAL WARGA</h6>
                <h3 class="mt-2 text-2xl font-extrabold text-gray-900">{{ $totalWarga }}</h3>
            </div>

            <!-- Card 3: Total Pemasukan -->
            <div class="rounded-xl bg-white p-5 shadow-sm border-l-4 border-l-cyan-500 border-gray-100 border transition-all duration-200 hover:shadow-md">
                <h6 class="text-xs font-bold uppercase tracking-wider text-gray-400">TOTAL PEMASUKAN</h6>
                <h3 class="mt-2 text-2xl font-extrabold text-emerald-600">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</h3>
            </div>

            <!-- Card 4: Sisa Saldo Kas -->
            <div class="rounded-xl bg-white p-5 shadow-sm border-l-4 border-l-amber-500 border-gray-100 border transition-all duration-200 hover:shadow-md">
                <h6 class="text-xs font-bold uppercase tracking-wider text-gray-400">SISA SALDO KAS</h6>
                <h3 class="mt-2 text-2xl font-extrabold text-blue-600">Rp {{ number_format($sisaSaldo, 0, ',', '.') }}</h3>
            </div>

        </div>

        <!-- Recent Payments Table Card -->
        <div class="overflow-hidden rounded-xl bg-white shadow-sm border border-gray-100">
            <!-- Table Sub-Header -->
            <div class="flex items-center justify-between border-b border-gray-100 bg-white p-5">
                <h5 class="text-base font-bold text-gray-800">Riwayat Pembayaran Terbaru</h5>
                <a href="{{ route('bendahara.pembayaran.index') }}" class="inline-flex items-center justify-center rounded-full border border-blue-600 px-4 py-1.5 text-xs font-bold text-blue-600 transition-colors hover:bg-blue-600 hover:text-white">
                    Lihat Semua
                </a>
            </div>

            <!-- Table Body -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 text-[0.7rem] font-bold uppercase tracking-wider text-gray-400 border-b border-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-4">NO</th>
                            <th scope="col" class="px-6 py-4">NAMA WARGA</th>
                            <th scope="col" class="px-6 py-4">JENIS IURAN</th>
                            <th scope="col" class="px-6 py-4">TANGGAL</th>
                            <th scope="col" class="px-6 py-4">NOMINAL</th>
                            <th scope="col" class="px-6 py-4 text-center">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($pembayaran as $index => $d)
                            <tr class="transition-colors hover:bg-slate-50/70">
                                <td class="px-6 py-4 font-mono text-xs text-gray-400">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-bold uppercase text-gray-900">{{ $d->nama }}</div>
                                    <div class="text-[0.7rem] text-gray-400">KK: {{ $d->no_kk }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-block rounded-md border border-gray-200 bg-gray-50 px-2.5 py-1 text-xs font-medium text-gray-700">
                                        {{ $d->nama_iuran }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                    {{ \Carbon\Carbon::parse($d->created_at)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900">
                                    Rp {{ number_format($d->jumlah, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if (strtolower($d->status) === 'lunas')
                                        <span class="inline-block rounded-full bg-emerald-100 px-3 py-1 text-[0.7rem] font-bold text-emerald-800">
                                            LUNAS
                                        </span>
                                    @else
                                        <span class="inline-block rounded-full bg-orange-100 px-3 py-1 text-[0.7rem] font-bold text-orange-800">
                                            {{ strtoupper($d->status) }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-xs text-gray-400">
                                    Belum ada data pembayaran terbaru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 p-4 text-center text-xs text-gray-500">
        &copy; {{ date('Y') }} Sistem Informasi Master Data Iuran
    </footer>
</div>
@endsection
