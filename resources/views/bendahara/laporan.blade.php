@extends('layouts.app')

@section('title', 'Manajemen Laporan Pembayaran')

@section('content')
<style>
    /* RESET & BASE LAYOUT */
    :root {
        --primary-blue: #0061f2;
        --sidebar-dark: #1a1d21;
        --bg-light: #f2f5f9;
    }
    body { background-color: var(--bg-light) !important; font-family: 'Poppins', sans-serif; margin: 0; padding: 0; }

    /* NAVBAR TOPBAR */
    .topbar-fixed {
        position: fixed; top: 0; left: 0; right: 0; height: 60px;
        background-color: var(--primary-blue); color: #fff; z-index: 1050;
        display: flex; align-items: center; justify-content: space-between;
        padding: 0 24px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .topbar-brand { font-weight: 700; font-size: 1.1rem; display: flex; align-items: center; gap: 8px; }
    .topbar-user { display: flex; align-items: center; gap: 12px; font-size: 0.85rem; }
    .btn-logout-yellow {
        background-color: #ffc107; color: #000; font-weight: 700; font-size: 0.75rem;
        padding: 6px 16px; border-radius: 6px; border: none; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;
    }

    /* SIDEBAR DARK */
    .sidebar-fixed {
        position: fixed; top: 60px; left: 0; bottom: 0; width: 240px;
        background-color: var(--sidebar-dark); z-index: 1040; padding-top: 15px;
        overflow-y: auto; border-right: 1px solid #2d3239;
    }
    .sidebar-label {
        font-size: 0.65rem; font-weight: 800; color: #6c757d; text-transform: uppercase;
        padding: 10px 24px; letter-spacing: 0.5px;
    }
    .sidebar-menu { display: flex; flex-direction: column; }
    .sidebar-link {
        display: flex; align-items: center; gap: 12px; padding: 12px 24px;
        color: #adb5bd; font-size: 0.85rem; text-decoration: none; font-weight: 500; transition: 0.2s;
    }
    .sidebar-link:hover { color: #fff; background-color: rgba(255,255,255,0.05); }
    .sidebar-link.active { background-color: var(--primary-blue); color: #fff; font-weight: 700; }

    /* MAIN CONTENT AREA */
    .main-wrapper { margin-left: 240px; padding-top: 80px; padding-left: 30px; padding-right: 30px; padding-bottom: 40px; }
    .header-section { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; }
    .title-main { font-size: 1.5rem; font-weight: 800; color: #1a1c23; margin: 0; }
    .subtitle-main { color: #6c757d; font-size: 0.8rem; margin-top: 2px; }
    .badge-verif { background: #e8f2ff; color: var(--primary-blue); font-weight: 800; font-size: 0.75rem; padding: 8px 16px; border-radius: 8px; border: 1px solid #cce0ff; text-transform: uppercase; }

    /* FILTER CARD (1 BARIS SEJAJAR) */
    .card-filter { background: #fff; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.03); margin-bottom: 24px; }
    .filter-grid { display: flex; align-items: flex-end; gap: 16px; }
    .filter-col-1 { flex: 2; }
    .filter-col-2 { flex: 1.5; }
    .filter-col-btn { display: flex; gap: 8px; }
    .label-custom { display: block; font-size: 0.75rem; font-weight: 700; color: #333; margin-bottom: 8px; }
    .select-custom { width: 100%; height: 40px; border: 1px solid #ced4da; border-radius: 8px; padding: 0 12px; font-size: 0.85rem; color: #333; outline: none; background: #fff; }
    .btn-filter { height: 40px; background: var(--primary-blue); color: #fff; font-weight: 700; font-size: 0.85rem; border-radius: 8px; border: none; padding: 0 20px; cursor: pointer; white-space: nowrap; }
    .btn-icon-green { height: 40px; width: 40px; background: #198754; color: #fff; border-radius: 8px; border: none; display: inline-flex; align-items: center; justify-content: center; font-size: 1rem; text-decoration: none; }
    .btn-icon-reset { height: 40px; width: 40px; background: #fff; border: 1px solid #ced4da; color: #333; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; font-size: 1rem; text-decoration: none; }

    /* TABEL DATA */
    .card-table { background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.03); overflow: hidden; }
    .table-custom { width: 100%; border-collapse: collapse; text-align: left; font-size: 0.85rem; }
    .table-custom thead tr { background: #f8f9fa; border-bottom: 1px solid #e9ecef; color: var(--primary-blue); font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; }
    .table-custom th, .table-custom td { padding: 16px 24px; vertical-align: middle; }
    .table-custom tbody tr { border-bottom: 1px solid #f1f3f5; }
    .badge-lunas { background: #e6fcf5; color: #087f5b; font-weight: 800; padding: 6px 14px; border-radius: 20px; font-size: 0.7rem; text-transform: uppercase; display: inline-block; }
    .badge-pending { background: #fff5f5; color: #c92a2a; font-weight: 800; padding: 6px 14px; border-radius: 20px; font-size: 0.7rem; text-transform: uppercase; display: inline-block; }
</style>

<div class="-m-6">

    <!-- 1. NAVBAR TOPBAR -->
    <nav class="topbar-fixed">
        <div class="topbar-brand">
            <i class="bi bi-wallet2 text-xl"></i> Master Data Iuran
        </div>
        <div class="topbar-user">
            <span><i class="bi bi-person-circle"></i> {{ Auth::user()->nama_lengkap ?? Auth::user()->username ?? 'Danny' }}</span>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn-logout-yellow">
                    Logout <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>
    </nav>

    <!-- 2. SIDEBAR DARK -->
    <aside class="sidebar-fixed">
        <div class="sidebar-label">MENU UTAMA</div>
        <div class="sidebar-menu">
            <a href="{{ route('bendahara.dashboard') }}" class="sidebar-link">
                <i class="bi bi-house-door"></i> Dashboard
            </a>
            <a href="{{ route('bendahara.jenis_iuran.index') }}" class="sidebar-link">
                <i class="bi bi-tags"></i> Jenis Iuran
            </a>
            <a href="{{ route('bendahara.pembayaran.index') }}" class="sidebar-link">
                <i class="bi bi-credit-card-2-front"></i> Pembayaran
            </a>
            <a href="{{ route('bendahara.laporan.index') }}" class="sidebar-link active">
                <i class="bi bi-bar-chart-line"></i> Laporan
            </a>
            <a href="{{ route('bendahara.tagihan.index') }}" class="sidebar-link">
                <i class="bi bi-cash-stack"></i> Tagihan
            </a>
            <a href="{{ route('bendahara.pengeluaran.index') }}" class="sidebar-link">
                <i class="bi bi-graph-down-arrow"></i> Pengeluaran
            </a>
            <a href="{{ route('bendahara.pemasukan.index') }}" class="sidebar-link">
                <i class="bi bi-graph-up-arrow"></i> Pemasukan
            </a>
        </div>
    </aside>

    <!-- 3. MAIN CONTENT LAPORAN -->
    <main class="main-wrapper">

        <!-- Header Page -->
        <div class="header-section">
            <div>
                <h1 class="title-main">Manajemen Laporan Pembayaran</h1>
                <p class="subtitle-main">kelola Laporan pembayaran iuran</p>
            </div>
            <div class="badge-verif">
                TOTAL TERVERIFIKASI: RP {{ number_format($totalUang ?? 0, 0, ',', '.') }}
            </div>
        </div>

        <!-- Filter Card -->
        <div class="card-filter">
            <form method="GET" action="{{ route('bendahara.laporan.index') }}">
                <div class="filter-grid">
                    <div class="filter-col-1">
                        <label class="label-custom">Pilih Jenis Iuran</label>
                        <select name="iuran" class="select-custom">
                            <option value="">Semua Jenis Iuran</option>
                            @foreach ($jenisIuranList ?? [] as $j)
                                <option value="{{ $j->id_iuran }}" {{ (request('iuran') == $j->id_iuran) ? 'selected' : '' }}>
                                    {{ $j->nama_iuran }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-col-2">
                        <label class="label-custom">Status</label>
                        <select name="status" class="select-custom">
                            <option value="">Semua Status</option>
                            <option value="Lunas" {{ (request('status') == 'Lunas') ? 'selected' : '' }}>LUNAS</option>
                            <option value="Tidak Lunas" {{ (request('status') == 'Tidak Lunas') ? 'selected' : '' }}>BELUM LUNAS</option>
                        </select>
                    </div>

                    <div class="filter-col-btn">
                        <button type="submit" class="btn-filter">
                            Tampilkan Filter
                        </button>
                        <a href="{{ route('bendahara.laporan.cetak-pdf', ['iuran' => request('iuran'), 'status' => request('status')]) }}" class="btn-icon-green" title="Cetak PDF">
                            <i class="bi bi-printer"></i>
                        </a>
                        <a href="{{ route('bendahara.laporan.index') }}" class="btn-icon-reset" title="Reset">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tabel Data -->
        <div class="card-table">
            <div style="overflow-x: auto;">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th style="width: 60px; text-align: center;">NO</th>
                            <th>NAMA WARGA / NIK</th>
                            <th>KATEGORI IURAN</th>
                            <th>NOMINAL</th>
                            <th style="text-align: center;">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data ?? [] as $index => $row)
                            <tr>
                                <td style="text-align: center; color: #6c757d; font-weight: 600;">{{ $index + 1 }}</td>
                                <td>
                                    <div style="font-weight: 700; color: #1a1c23; text-transform: uppercase;">{{ $row->nama }}</div>
                                    <div style="font-size: 0.75rem; color: #6c757d; margin-top: 2px;">NIK: {{ $row->nik }}</div>
                                </td>
                                <td style="color: #495057; font-weight: 500;">{{ $row->nama_iuran }}</td>
                                <td style="font-weight: 700; color: #0061f2;">Rp {{ number_format($row->jumlah, 0, ',', '.') }}</td>
                                <td style="text-align: center;">
                                    @if (strtolower($row->status) == 'lunas')
                                        <span class="badge-lunas">LUNAS</span>
                                    @else
                                        <span class="badge-pending">BELUM</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 40px; color: #6c757d;">
                                    <i class="bi bi-inbox" style="font-size: 2rem; display: block; margin-bottom: 10px; opacity: 0.5;"></i>
                                    Tidak ada data laporan pembayaran.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

</div>
@endsection
