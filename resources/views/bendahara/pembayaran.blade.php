@extends('layouts.app')

@section('title', 'Manajemen Pembayaran')

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

    .badge-box-group { display: flex; gap: 10px; }
    .badge-pending { background: #ffe8e8; color: #e11d48; font-weight: 800; font-size: 0.75rem; padding: 8px 16px; border-radius: 8px; border: 1px solid #fecdd3; text-transform: uppercase; }
    .badge-verif { background: #e8f2ff; color: var(--primary-blue); font-weight: 800; font-size: 0.75rem; padding: 8px 16px; border-radius: 8px; border: 1px solid #cce0ff; text-transform: uppercase; }

    /* FILTER CARD & BUTTONS */
    .card-filter { background: #fff; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.03); margin-bottom: 24px; }
    .filter-grid { display: flex; align-items: flex-end; gap: 16px; }
    .filter-col-main { flex: 1; }
    .filter-col-btn { display: flex; gap: 8px; }
    .label-custom { display: block; font-size: 0.75rem; font-weight: 700; color: #333; margin-bottom: 8px; }
    .select-custom { width: 100%; height: 40px; border: 1px solid #ced4da; border-radius: 8px; padding: 0 12px; font-size: 0.85rem; color: #333; outline: none; background: #fff; }

    .btn-blue-add { background: var(--primary-blue); color: #fff; font-weight: 700; font-size: 0.85rem; border-radius: 8px; border: none; padding: 10px 20px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; margin-bottom: 20px; }
    .btn-filter { height: 40px; background: var(--primary-blue); color: #fff; font-weight: 700; font-size: 0.85rem; border-radius: 8px; border: none; padding: 0 20px; cursor: pointer; white-space: nowrap; }
    .btn-icon-reset { height: 40px; background: #fff; border: 1px solid #ced4da; color: #333; border-radius: 8px; padding: 0 16px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.85rem; font-weight: 700; text-decoration: none; }

    /* TABEL DATA */
    .card-table { background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.03); overflow: hidden; }
    .table-custom { width: 100%; border-collapse: collapse; text-align: left; font-size: 0.85rem; }
    .table-custom thead tr { background: #f8f9fa; border-bottom: 1px solid #e9ecef; color: var(--primary-blue); font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; }
    .table-custom th, .table-custom td { padding: 16px 24px; vertical-align: middle; }
    .table-custom tbody tr { border-bottom: 1px solid #f1f3f5; }

    .badge-status-lunas { background: #e6fcf5; color: #087f5b; font-weight: 800; padding: 6px 14px; border-radius: 20px; font-size: 0.7rem; text-transform: uppercase; display: inline-block; }
    .badge-status-belum { background: #fff5f5; color: #c92a2a; font-weight: 800; padding: 6px 14px; border-radius: 20px; font-size: 0.7rem; text-transform: uppercase; display: inline-block; }

    .btn-action-edit { width: 34px; height: 34px; border-radius: 8px; border: 1px solid #a7f3d0; background: #fff; color: #059669; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; }
    .btn-action-edit:hover { background: #ecfdf5; }
    .btn-action-delete { width: 34px; height: 34px; border-radius: 8px; border: 1px solid #fecdd3; background: #fff; color: #e11d48; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; }
    .btn-action-delete:hover { background: #fff1f2; }

    /* MODAL OVERLAY */
    .modal-overlay { position: fixed; inset: 0; background: rgba(15, 23, 42, 0.4); backdrop-filter: blur(2px); z-index: 9999; display: flex; align-items: center; justify-content: center; padding: 16px; }
    .modal-overlay.hidden { display: none !important; }
    .modal-card-box { background: #fff; width: 100%; max-width: 420px; border-radius: 16px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); overflow: hidden; }
    .modal-header-box { padding: 16px 20px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; }
    .modal-body-box { padding: 20px; }
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
            <a href="{{ route('bendahara.pembayaran.index') }}" class="sidebar-link active">
                <i class="bi bi-credit-card-2-front"></i> Pembayaran
            </a>
            <a href="{{ route('bendahara.laporan.index') }}" class="sidebar-link">
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

    <!-- 3. MAIN CONTENT PEMBAYARAN -->
    <main class="main-wrapper">

        <!-- Header Page -->
        <div class="header-section">
            <div>
                <h1 class="title-main">Manajemen Pembayaran</h1>
                <p class="subtitle-main">Verifikasi dan kelola transaksi iuran warga secara real-time.</p>
            </div>
            <div class="badge-box-group">
                <div class="badge-pending">
                    BELUM VERIFIKASI: {{ $totalPending ?? $total_pending ?? 0 }} DATA
                </div>
                <div class="badge-verif">
                    TOTAL TERVERIFIKASI: RP {{ number_format($totalVerif ?? $total_verif ?? 0, 0, ',', '.') }}
                </div>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="card-filter">
            <form method="GET" action="{{ route('bendahara.pembayaran.index') }}">
                <div class="filter-grid">
                    <div class="filter-col-main">
                        <label class="label-custom">KATEGORI IURAN</label>
                        <select name="kategori" class="select-custom">
                            <option value="">Semua Kategori</option>
                            @foreach ($listIuran ?? $list_iuran ?? [] as $i)
                                <option value="{{ $i->id_iuran }}" {{ (request('kategori') == $i->id_iuran) ? 'selected' : '' }}>
                                    {{ $i->nama_iuran }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-col-btn">
                        <button type="submit" class="btn-filter">
                            <i class="bi bi-filter"></i> Filter
                        </button>
                        <a href="{{ route('bendahara.pembayaran.index') }}" class="btn-icon-reset">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tombol Tambah Pembayaran -->
        <div>
            <button type="button" onclick="openAddModal()" class="btn-blue-add">
                <i class="bi bi-plus-lg"></i> Tambah Pembayaran
            </button>
        </div>

        <!-- Tabel Data Pembayaran -->
        <div class="card-table">
            <div style="overflow-x: auto;">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th style="width: 60px; text-align: center;">NO</th>
                            <th>NAMA WARGA / NIK</th>
                            <th>KATEGORI IURAN</th>
                            <th>NOMINAL</th>
                            <th>STATUS</th>
                            <th style="text-align: center; width: 120px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pembayaran ?? $data_pembayaran ?? [] as $index => $p)
                            <tr>
                                <td style="text-align: center; color: #6c757d; font-weight: 600;">{{ $index + 1 }}</td>
                                <td>
                                    <div style="font-weight: 700; color: #1a1c23; text-transform: uppercase;">{{ $p->nama }}</div>
                                    <div style="font-size: 0.75rem; color: #6c757d; margin-top: 2px;">NIK: {{ $p->nik_warga ?? $p->nik }}</div>
                                </td>
                                <td style="color: #495057; font-weight: 500;">{{ $p->nama_iuran }}</td>
                                <td style="font-weight: 700; color: #0061f2;">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                                <td>
                                    @if (strtolower($p->status) == 'lunas')
                                        <span class="badge-status-lunas">LUNAS</span>
                                    @else
                                        <span class="badge-status-belum">BELUM</span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <div style="display: flex; justify-content: center; gap: 6px;">
                                        <button type="button"
                                            onclick="editBayar('{{ $p->id }}', '{{ $p->nik_warga ?? $p->nik }}', '{{ $p->id_iuran }}', '{{ $p->status }}')"
                                            class="btn-action-edit">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <form method="POST" action="{{ route('bendahara.pembayaran.destroy', $p->id) }}" class="form-hapus" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn-hapus btn-action-delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 40px; color: #6c757d;">
                                    <i class="bi bi-inbox" style="font-size: 2rem; display: block; margin-bottom: 10px; opacity: 0.5;"></i>
                                    Belum ada data pembayaran terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

</div>

<!-- 4. MODAL INPUT / EDIT PEMBAYARAN -->
<div id="modalBayar" class="modal-overlay hidden">
    <div class="modal-card-box">
        <div class="modal-header-box">
            <h3 id="modalTitle" style="font-size: 1rem; font-weight: 800; color: #1a1c23; margin: 0;">Tambah Pembayaran</h3>
            <button type="button" onclick="closeModal()" style="background: none; border: none; color: #6c757d; font-size: 1.2rem; cursor: pointer;">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <form id="formBayar" method="POST" action="{{ route('bendahara.pembayaran.store') }}">
            <div class="modal-body-box">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <input type="hidden" name="id" id="id_field">

                <div style="margin-bottom: 14px;">
                    <label class="label-custom">PILIH WARGA</label>
                    <select name="nik" id="nik" required class="select-custom">
                        <option value="">-- Pilih Warga --</option>
                        @foreach ($listWarga ?? $list_warga ?? [] as $w)
                            <option value="{{ $w->nik }}">{{ strtoupper($w->nama) }} - {{ $w->nik }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom: 14px;">
                    <label class="label-custom">KATEGORI IURAN</label>
                    <select name="id_iuran" id="id_iuran" required class="select-custom">
                        <option value="">-- Pilih Iuran --</option>
                        @foreach ($listIuran ?? $list_iuran ?? [] as $i)
                            <option value="{{ $i->id_iuran }}">{{ $i->nama_iuran }} (Rp {{ number_format($i->jumlah) }})</option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom: 14px;">
                    <label class="label-custom">STATUS PEMBAYARAN</label>
                    <select name="status" id="status" class="select-custom">
                        <option value="Lunas">LUNAS</option>
                        <option value="Tidak Lunas">BELUM</option>
                    </select>
                </div>

                <div style="margin-top: 20px;">
                    <button type="submit" name="simpan_bayar" class="btn-filter" style="width: 100%;">
                        Simpan Data Pembayaran
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const modal = document.getElementById('modalBayar');
    const form = document.getElementById('formBayar');
    const modalTitle = document.getElementById('modalTitle');
    const formMethod = document.getElementById('formMethod');

    @if (session('status') || session('notif'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('status') ?? session('notif') }}",
            timer: 2500,
            showConfirmButton: false
        });
    @endif

    document.querySelectorAll('.btn-hapus').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const formHapus = this.closest('.form-hapus');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0061f2',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    formHapus.submit();
                }
            });
        });
    });

    function openAddModal() {
        form.action = "{{ route('bendahara.pembayaran.store') }}";
        if (formMethod) formMethod.value = "POST";
        document.getElementById('id_field').value = "";
        document.getElementById('nik').value = "";
        document.getElementById('id_iuran').value = "";
        document.getElementById('status').value = "Lunas";
        modalTitle.innerText = "Tambah Pembayaran";
        modal.classList.remove('hidden');
    }

    function editBayar(id, nik, iuran, status) {
        form.action = "/bendahara/pembayaran/" + id;
        if (formMethod) formMethod.value = "PUT";
        document.getElementById('id_field').value = id;
        document.getElementById('nik').value = nik;
        document.getElementById('id_iuran').value = iuran;
        document.getElementById('status').value = status;
        modalTitle.innerText = "Edit Pembayaran";
        modal.classList.remove('hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
    }
</script>
@endsection
