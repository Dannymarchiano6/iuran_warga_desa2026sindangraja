@extends('layouts.app')

@section('title', 'Data Kartu Keluarga - Admin')

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
            <span class="ml-2 text-base font-semibold text-white sm:text-lg">Manajemen Kartu Keluarga</span>
        </div>

        <!-- User Info & Logout -->
        <div class="flex items-center gap-3 sm:gap-4">
            <span class="flex items-center text-xs font-medium text-white sm:text-sm">
                <i class="bi bi-person-circle me-1.5 text-base"></i>
                Admin: {{ Auth::user()->nama_lengkap ?? Auth::user()->username ?? session('nama', 'Admin') }}
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

            <a href="{{ route('admin.users.index') }}" class="flex items-center px-6 py-3 text-sm font-medium transition-colors duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-blue-600 text-white' : 'text-[#9ea4b0] hover:bg-white/5 hover:text-white' }}">
                <i class="bi bi-people me-3.5 text-lg"></i> Manajemen User
            </a>

            <a href="{{ route('admin.kk.index') }}" class="flex items-center px-6 py-3 text-sm font-medium transition-colors duration-200 {{ request()->routeIs('admin.kk.*') ? 'bg-blue-600 text-white' : 'text-[#9ea4b0] hover:bg-white/5 hover:text-white' }}">
                <i class="bi bi-journal-bookmark me-3.5 text-lg"></i> Data KK
            </a>
        </div>
    </div>
</aside>

<!-- Main Body Area -->
<div class="min-h-screen bg-[#f4f7f6] pt-[60px] transition-all duration-300 sm:ml-64">

    <!-- Header Page & Add Button -->
    <div class="flex flex-col gap-4 p-6 sm:flex-row sm:items-center sm:justify-between sm:px-8 sm:py-7">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Data Kartu Keluarga</h2>
            <p class="mt-1 text-sm text-gray-500">Kelola dan pantau data domisili warga secara terpusat.</p>
        </div>
        <button onclick="resetModalKK(); openModal('modalKK')" type="button" class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition-all hover:bg-blue-700 active:scale-95">
            <i class="bi bi-plus-lg me-1.5 text-base"></i> Tambah KK
        </button>
    </div>

    <!-- Main Content Area -->
    <div class="px-6 pb-8 sm:px-8">

        <!-- Flash Alert Success Notification -->
        @if (session('notif'))
            <div class="mb-6 flex items-center rounded-2xl bg-blue-50 border border-blue-200 p-4 text-sm text-blue-800 shadow-sm" role="alert">
                <i class="bi bi-info-circle-fill me-3 text-xl"></i>
                <span class="font-semibold">{{ session('notif') }}</span>
            </div>
        @endif

        <!-- Flash Alert Error Notification (Pesan Error Validasi) -->
        @if ($errors->any())
            <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 p-4 text-sm text-red-800 shadow-sm" role="alert">
                <div class="flex items-center mb-1 font-bold">
                    <i class="bi bi-exclamation-triangle-fill me-2 text-lg text-red-600"></i> Gagal Menyimpan Data:
                </div>
                <ul class="list-disc pl-7 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Search Bar -->
        <div class="mb-6 rounded-2xl bg-white p-4 shadow-sm border border-gray-100">
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <i class="bi bi-search text-gray-400"></i>
                </div>
                <input type="text" id="searchInput" class="block w-full rounded-xl border border-gray-200 bg-gray-50 p-2.5 pl-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" placeholder="Cari No KK, Alamat, atau RT/RW...">
            </div>
        </div>

        <!-- Table KK Card -->
        <div class="overflow-hidden rounded-2xl bg-white shadow-sm border border-gray-100">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600" id="tableKK">
                    <thead class="bg-slate-50 text-[0.7rem] font-bold uppercase tracking-wider text-slate-400 border-b border-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-center">NO</th>
                            <th scope="col" class="px-6 py-4">NOMOR KK</th>
                            <th scope="col" class="px-6 py-4">ALAMAT</th>
                            <th scope="col" class="px-6 py-4">RT / RW</th>
                            <th scope="col" class="px-6 py-4">TOTAL ANGGOTA</th>
                            <th scope="col" class="px-6 py-4 text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($kk as $index => $d)
                            <!-- Main Row KK -->
                            <tr class="kk-row transition-colors duration-150 hover:bg-slate-50/70">
                                <td class="whitespace-nowrap px-6 py-4 text-center text-xs text-gray-400 font-mono">
                                    {{ $index + 1 }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 font-bold text-gray-900 font-mono">
                                    {{ $d->no_kk }}
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-500 max-w-xs truncate">
                                    {{ $d->alamat }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span class="inline-block rounded-lg bg-gray-100 px-3 py-1.5 text-xs font-semibold text-gray-700">
                                        RT {{ $d->rt }} / RW {{ $d->rw }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span class="inline-flex items-center rounded-md bg-blue-50 border border-blue-200 px-2.5 py-1 text-xs font-bold text-blue-600">
                                        {{ $d->jumlah ?? 0 }} Jiwa
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-1">
                                        <!-- Toggle Lihat Warga -->
                                        <button onclick="toggleAnggota('anggota_{{ $d->id_kk }}')" type="button" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-cyan-200 bg-cyan-50 text-cyan-600 transition-colors hover:bg-cyan-600 hover:text-white shadow-sm" title="Lihat Warga">
                                            <i class="bi bi-eye"></i>
                                        </button>

                                        <!-- Tambah Warga -->
                                        <button onclick="tambahAnggota('{{ $d->id_kk }}', '{{ $d->no_kk }}')" type="button" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-600 transition-colors hover:bg-emerald-600 hover:text-white shadow-sm" title="Tambah Warga">
                                            <i class="bi bi-person-plus"></i>
                                        </button>

                                        <!-- Edit KK -->
                                        <button onclick="editKK('{{ $d->id_kk }}','{{ $d->no_kk }}','{{ $d->alamat }}','{{ $d->rt }}','{{ $d->rw }}')" type="button" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-blue-200 bg-blue-50 text-blue-600 transition-colors hover:bg-blue-600 hover:text-white shadow-sm" title="Edit KK">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <!-- Hapus KK -->
                                        <form method="POST" action="{{ route('admin.kk.destroy', $d->id_kk) }}" onsubmit="return confirm('Hapus KK ini beserta semua warganya?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-red-200 bg-red-50 text-red-600 transition-colors hover:bg-red-600 hover:text-white shadow-sm" title="Hapus KK">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- Sub-Row Anggota Keluarga (Collapsible) -->
                            <tr id="anggota_{{ $d->id_kk }}" class="hidden bg-slate-50/50">
                                <td colspan="6" class="p-4 sm:p-6">
                                    <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
                                        <div class="mb-3 flex items-center justify-between border-b border-gray-100 pb-2">
                                            <h6 class="flex items-center text-xs font-bold text-blue-600 uppercase tracking-wider">
                                                <i class="bi bi-people-fill me-2 text-base"></i> Daftar Anggota Keluarga (KK: {{ $d->no_kk }})
                                            </h6>
                                            <button onclick="tambahAnggota('{{ $d->id_kk }}', '{{ $d->no_kk }}')" class="text-xs font-bold text-emerald-600 hover:underline">
                                                + Tambah Anggota
                                            </button>
                                        </div>

                                        <div class="overflow-x-auto">
                                            <table class="w-full text-left text-xs text-gray-600">
                                                <thead class="bg-gray-50 text-[0.65rem] font-bold uppercase text-gray-400">
                                                    <tr>
                                                        <th class="px-4 py-2.5">NIK</th>
                                                        <th class="px-4 py-2.5">NAMA LENGKAP</th>
                                                        <th class="px-4 py-2.5">STATUS KELUARGA</th>
                                                        <th class="px-4 py-2.5">KONTAK HP</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-100">
                                                    @forelse ($d->warga as $w)
                                                        <tr class="hover:bg-gray-50/50">
                                                            <td class="px-4 py-2 font-mono text-gray-700">{{ $w->nik }}</td>
                                                            <td class="px-4 py-2 font-bold text-gray-900">{{ $w->nama }}</td>
                                                            <td class="px-4 py-2">
                                                                <span class="rounded bg-blue-50 px-2 py-0.5 text-[0.65rem] font-semibold uppercase text-blue-600">
                                                                    {{ $w->status_keluarga }}
                                                                </span>
                                                            </td>
                                                            <td class="px-4 py-2 text-gray-500">{{ $w->no_hp ?: '-' }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="4" class="px-4 py-4 text-center text-gray-400">
                                                                Belum ada anggota keluarga terdaftar pada KK ini.
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-400">
                                    <i class="bi bi-inbox text-3xl block mb-2 opacity-50"></i>
                                    Belum ada data Kartu Keluarga terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- ========================================== -->
<!-- MODAL FORM KK (TAMBAH / EDIT) -->
<!-- ========================================== -->
<div id="modalKK" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 hidden flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-900/50 p-4 backdrop-blur-sm">
    <div class="relative max-h-full w-full max-w-md">
        <div class="relative rounded-2xl bg-white shadow-xl border border-gray-100">
            <div class="flex items-center justify-between p-4 border-b border-gray-100">
                <h3 id="modalKKTitle" class="text-base font-bold text-gray-900 flex items-center">
                    <i class="bi bi-journal-plus text-blue-600 me-2"></i> Form Kartu Keluarga
                </h3>
                <button type="button" onclick="closeModal('modalKK')" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <form id="formKK" method="POST" action="{{ route('admin.kk.store') }}" class="p-6">
                @csrf
                <input type="hidden" name="id_kk" id="id_kk" value="{{ old('id_kk') }}">
                <input type="hidden" name="_method" id="methodKK" value="POST">

                <div class="mb-4">
                    <label class="block mb-1 text-xs font-bold uppercase text-gray-600">Nomor KK (Wajib 16 Digit)</label>
                    <input type="text" name="no_kk" id="no_kk" value="{{ old('no_kk') }}" maxlength="16" minlength="16" pattern="[0-9]{16}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Contoh: 3201012345678901" class="w-full rounded-xl border border-gray-200 bg-gray-50 p-2.5 text-sm font-mono text-gray-900 focus:border-blue-500 focus:ring-blue-500" required>
                    <p class="mt-1 text-[0.65rem] text-gray-400">Harus persis 16 digit angka & tidak boleh duplikat.</p>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 text-xs font-bold uppercase text-gray-600">Alamat Domisili</label>
                    <textarea name="alamat" id="alamat" rows="2" placeholder="Nama Jalan, Blok, atau No Rumah" class="w-full rounded-xl border border-gray-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500">{{ old('alamat') }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-3 mb-6">
                    <div>
                        <label class="block mb-1 text-xs font-bold uppercase text-gray-600">RT</label>
                        <input type="text" name="rt" id="rt" value="{{ old('rt') }}" placeholder="001" class="w-full rounded-xl border border-gray-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block mb-1 text-xs font-bold uppercase text-gray-600">RW</label>
                        <input type="text" name="rw" id="rw" value="{{ old('rw') }}" placeholder="001" class="w-full rounded-xl border border-gray-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <button type="button" onclick="closeModal('modalKK')" class="w-1/3 rounded-xl bg-gray-100 py-3 text-sm font-bold text-gray-600 transition-all hover:bg-gray-200">
                        BATAL
                    </button>
                    <button type="submit" class="w-2/3 rounded-xl bg-blue-600 py-3 text-sm font-bold text-white transition-all hover:bg-blue-700 shadow-sm">
                        SIMPAN DATA
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL TAMBAH ANGGOTA WARGA -->
<!-- ========================================== -->
<div id="modalAnggota" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 hidden flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-900/50 p-4 backdrop-blur-sm">
    <div class="relative max-h-full w-full max-w-lg">
        <div class="relative rounded-2xl bg-white shadow-xl border border-gray-100">
            <div class="flex items-center justify-between p-4 border-b border-gray-100">
                <h3 class="text-base font-bold text-emerald-600 flex items-center">
                    <i class="bi bi-person-plus-fill me-2"></i> Tambah Warga Baru
                </h3>
                <button type="button" onclick="closeModal('modalAnggota')" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.kk.store_anggota') }}" class="p-6">
                @csrf
                <p class="text-xs text-gray-500 mb-4">Input data untuk KK: <b id="displayNoKK" class="text-blue-600 font-mono"></b></p>
                <input type="hidden" name="id_kk" id="idKK_anggota" value="{{ old('id_kk') }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block mb-1 text-xs font-bold uppercase text-gray-600">NIK (16 Digit)</label>
                        <input type="text" name="nik" value="{{ old('nik') }}" maxlength="16" minlength="16" pattern="[0-9]{16}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="3201..." class="w-full rounded-xl border border-gray-200 bg-gray-50 p-2.5 text-sm font-mono text-gray-900 focus:border-blue-500 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label class="block mb-1 text-xs font-bold uppercase text-gray-600">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" class="w-full rounded-xl border border-gray-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label class="block mb-1 text-xs font-bold uppercase text-gray-600">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="w-full rounded-xl border border-gray-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block mb-1 text-xs font-bold uppercase text-gray-600">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full rounded-xl border border-gray-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block mb-1 text-xs font-bold uppercase text-gray-600">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="w-full rounded-xl border border-gray-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500">
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-1 text-xs font-bold uppercase text-gray-600">Status Keluarga</label>
                        <select name="status_keluarga" class="w-full rounded-xl border border-gray-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500">
                            <option value="Kepala Keluarga" {{ old('status_keluarga') == 'Kepala Keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
                            <option value="Istri" {{ old('status_keluarga') == 'Istri' ? 'selected' : '' }}>Istri</option>
                            <option value="Anak" {{ old('status_keluarga') == 'Anak' ? 'selected' : '' }}>Anak</option>
                            <option value="Lainnya" {{ old('status_keluarga') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block mb-1 text-xs font-bold uppercase text-gray-600">Nomor HP / WhatsApp</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="08..." class="w-full rounded-xl border border-gray-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex items-center gap-2 mt-6">
                    <button type="button" onclick="closeModal('modalAnggota')" class="w-1/3 rounded-xl bg-gray-100 py-3 text-sm font-bold text-gray-600 transition-all hover:bg-gray-200">
                        BATAL
                    </button>
                    <button type="submit" class="w-2/3 rounded-xl bg-emerald-600 py-3 text-sm font-bold text-white transition-all hover:bg-emerald-700 shadow-sm">
                        KONFIRMASI WARGA
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    function toggleAnggota(id) {
        let el = document.getElementById(id);
        if (el) {
            el.classList.toggle('hidden');
        }
    }

    function resetModalKK() {
        document.getElementById('formKK').action = "{{ route('admin.kk.store') }}";
        document.getElementById('methodKK').value = "POST";
        document.getElementById('id_kk').value = '';
        document.getElementById('no_kk').value = '';
        document.getElementById('alamat').value = '';
        document.getElementById('rt').value = '';
        document.getElementById('rw').value = '';
    }

    function editKK(id, no, alamat, rt, rw) {
        document.getElementById('formKK').action = "/admin/kk/" + id;
        document.getElementById('methodKK').value = "PUT";
        document.getElementById('id_kk').value = id;
        document.getElementById('no_kk').value = no;
        document.getElementById('alamat').value = alamat;
        document.getElementById('rt').value = rt;
        document.getElementById('rw').value = rw;
        openModal('modalKK');
    }

    function tambahAnggota(id, noKK) {
        document.getElementById('idKK_anggota').value = id;
        document.getElementById('displayNoKK').innerText = noKK;
        openModal('modalAnggota');
    }

    // Auto open modal jika terdapat error validasi dari server
    @if ($errors->has('no_kk') || $errors->has('alamat') || $errors->has('rt') || $errors->has('rw'))
        @if (old('_method') == 'PUT')
            editKK("{{ old('id_kk') }}", "{{ old('no_kk') }}", "{{ old('alamat') }}", "{{ old('rt') }}", "{{ old('rw') }}");
        @else
            openModal('modalKK');
        @endif
    @elseif ($errors->has('nik') || $errors->has('nama'))
        openModal('modalAnggota');
    @endif

    // Live Search Filter Table
    document.getElementById("searchInput").addEventListener("keyup", function() {
        let value = this.value.toLowerCase();
        let rows = document.querySelectorAll("#tableKK tbody > tr.kk-row");
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(value) ? "" : "none";
            let nextRow = row.nextElementSibling;
            if (nextRow && nextRow.id.startsWith('anggota_')) {
                nextRow.classList.add('hidden');
            }
        });
    });
</script>
@endsection
