@extends('layouts.app')

@section('title', 'Manajemen User - Admin')

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
            <span class="ml-2 text-base font-semibold text-white sm:text-lg">Pengaturan Pengguna</span>
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

            <a href="{{ route('admin.kk.index') }}" class="flex items-center px-6 py-3 text-sm font-medium text-[#9ea4b0] transition-colors duration-200 hover:bg-white/5 hover:text-white">
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
            <h2 class="text-2xl font-bold text-gray-800">Manajemen User</h2>
            <p class="mt-1 text-sm text-gray-500">Atur hak akses Admin, Bendahara, dan Warga.</p>
        </div>
        <button onclick="openModal('modalTambah')" type="button" class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition-all hover:bg-blue-700 active:scale-95">
            <i class="bi bi-person-plus-fill me-2 text-base"></i> Tambah User
        </button>
    </div>

    <!-- Main Content Area -->
    <div class="px-6 pb-8 sm:px-8">

        <!-- Flash Alert Notification -->
        @if (session('notif'))
            <div class="mb-6 flex items-center rounded-2xl bg-blue-50 border border-blue-200 p-4 text-sm text-blue-800 shadow-sm" role="alert">
                <i class="bi bi-info-circle-fill me-3 text-xl"></i>
                <span class="font-semibold">{{ session('notif') }}</span>
            </div>
        @endif

        <!-- Search Card Bar -->
        <div class="mb-6 rounded-2xl bg-white p-4 shadow-sm border border-gray-100">
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <i class="bi bi-search text-gray-400"></i>
                </div>
                <input type="text" id="searchUser" class="block w-full rounded-xl border border-gray-200 bg-gray-50 p-2.5 pl-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" placeholder="Cari nama atau username...">
            </div>
        </div>

        <!-- Table User Card -->
        <div class="overflow-hidden rounded-2xl bg-white shadow-sm border border-gray-100">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600" id="userTable">
                    <thead class="bg-slate-50 text-[0.7rem] font-bold uppercase tracking-wider text-slate-400 border-b border-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-center">NO</th>
                            <th scope="col" class="px-6 py-4">NAMA PENGGUNA</th>
                            <th scope="col" class="px-6 py-4">USERNAME</th>
                            <th scope="col" class="px-6 py-4">HAK AKSES</th>
                            <th scope="col" class="px-6 py-4 text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($users as $index => $u)
                            <tr class="transition-colors duration-150 hover:bg-slate-50/70">
                                <td class="whitespace-nowrap px-6 py-4 text-center text-xs text-gray-400 font-mono">
                                    {{ $index + 1 }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="font-semibold text-gray-900">{{ $u->nama_lengkap }}</div>
                                    <div class="text-[0.7rem] text-gray-400 mt-0.5">
                                        Sejak: {{ $u->created_at ? \Carbon\Carbon::parse($u->created_at)->format('d M Y') : '-' }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <code class="rounded bg-slate-100 px-2 py-1 font-mono text-xs text-blue-600 border border-slate-200 font-bold">{{ $u->username }}</code>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    @php
                                        $role = strtolower($u->role);
                                        $badgeClass = match($role) {
                                            'admin' => 'bg-red-50 text-red-600 border-red-200',
                                            'bendahara' => 'bg-amber-50 text-amber-600 border-amber-200',
                                            default => 'bg-blue-50 text-blue-600 border-blue-200',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center rounded-md border px-2.5 py-1 text-xs font-semibold uppercase {{ $badgeClass }}">
                                        <i class="bi bi-shield-lock me-1.5"></i> {{ strtoupper($u->role) }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Tombol Edit dengan JS Trigger Universal -->
                                        <button onclick="openModal('modalEdit{{ $u->id_user }}')" type="button" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-blue-200 bg-blue-50 text-blue-600 transition-colors hover:bg-blue-600 hover:text-white shadow-sm">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <!-- Form Delete CRUD -->
                                        <form method="POST" action="{{ route('admin.users.destroy', $u->id_user) }}" onsubmit="return confirm('Hapus user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-red-200 bg-red-50 text-red-600 transition-colors hover:bg-red-600 hover:text-white shadow-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-400">
                                    <i class="bi bi-inbox text-3xl block mb-2 opacity-50"></i>
                                    Belum ada data user terdaftar.
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
<!-- MODAL-MODAL DITARUH DI LUAR TABEL (SOLUSI BUG) -->
<!-- ========================================== -->

<!-- MODAL TAMBAH USER -->
<div id="modalTambah" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 hidden flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-900/50 p-4 backdrop-blur-sm">
    <div class="relative max-h-full w-full max-w-md">
        <div class="relative rounded-2xl bg-white shadow-xl border border-gray-100">
            <div class="flex items-center justify-between p-4 border-b border-gray-100">
                <h3 class="text-base font-bold text-blue-600 flex items-center">
                    <i class="bi bi-person-plus-fill me-2"></i> User Baru
                </h3>
                <button type="button" onclick="closeModal('modalTambah')" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.users.store') }}" class="p-6">
                @csrf
                <div class="mb-4">
                    <label class="block mb-1 text-xs font-bold uppercase text-gray-600">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" placeholder="Nama asli" class="w-full rounded-xl border border-gray-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 text-xs font-bold uppercase text-gray-600">Username</label>
                    <input type="text" name="username" placeholder="Untuk login" class="w-full rounded-xl border border-gray-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 text-xs font-bold uppercase text-gray-600">Password</label>
                    <input type="password" name="password" placeholder="Min. 6 karakter" class="w-full rounded-xl border border-gray-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <div class="mb-6">
                    <label class="block mb-1 text-xs font-bold uppercase text-gray-600">Role</label>
                    <select name="role" class="w-full rounded-xl border border-gray-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="admin">Admin</option>
                        <option value="bendahara">Bendahara</option>
                        <option value="warga">Warga</option>
                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <button type="button" onclick="closeModal('modalTambah')" class="w-1/3 rounded-xl bg-gray-100 py-3 text-sm font-bold text-gray-600 transition-all hover:bg-gray-200">
                        BATAL
                    </button>
                    <button type="submit" class="w-2/3 rounded-xl bg-blue-600 py-3 text-sm font-bold text-white transition-all hover:bg-blue-700 shadow-sm">
                        DAFTARKAN
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- LOOP MODAL EDIT USER -->
@foreach ($users as $u)
    <div id="modalEdit{{ $u->id_user }}" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 hidden flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-900/50 p-4 backdrop-blur-sm">
        <div class="relative max-h-full w-full max-w-md">
            <div class="relative rounded-2xl bg-white shadow-xl text-left border border-gray-100">
                <div class="flex items-center justify-between p-4 border-b border-gray-100">
                    <h3 class="text-base font-bold text-gray-900 flex items-center">
                        <i class="bi bi-pencil-square text-blue-600 me-2"></i> Edit Akun
                    </h3>
                    <button type="button" onclick="closeModal('modalEdit{{ $u->id_user }}')" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.users.update', $u->id_user) }}" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block mb-1 text-xs font-bold uppercase text-gray-600">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ $u->nama_lengkap }}" class="w-full rounded-xl border border-gray-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1 text-xs font-bold uppercase text-gray-600">Username</label>
                        <input type="text" name="username" value="{{ $u->username }}" class="w-full rounded-xl border border-gray-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1 text-xs font-bold uppercase text-gray-600">Role Akses</label>
                        <select name="role" class="w-full rounded-xl border border-gray-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500">
                            <option value="admin" {{ strtolower($u->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="bendahara" {{ strtolower($u->role) == 'bendahara' ? 'selected' : '' }}>Bendahara</option>
                            <option value="warga" {{ strtolower($u->role) == 'warga' ? 'selected' : '' }}>Warga</option>
                        </select>
                    </div>

                    <div class="p-4 rounded-xl bg-red-50 border border-dashed border-red-200 mb-6">
                        <label class="block text-xs font-bold text-red-600 mb-1">
                            <i class="bi bi-key me-1"></i> Ganti Password?
                        </label>
                        <input type="password" name="password" placeholder="Kosongkan jika tidak diganti" class="w-full rounded-lg border border-gray-200 bg-white p-2 text-sm text-gray-900 focus:border-red-500 focus:ring-red-500">
                        <p class="mt-1 text-[0.65rem] text-gray-500">Biarkan kosong jika tetap menggunakan password lama.</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="button" onclick="closeModal('modalEdit{{ $u->id_user }}')" class="w-1/3 rounded-xl bg-gray-100 py-3 text-sm font-bold text-gray-600 transition-all hover:bg-gray-200">
                            BATAL
                        </button>
                        <button type="submit" class="w-2/3 rounded-xl bg-blue-600 py-3 text-sm font-bold text-white transition-all hover:bg-blue-700 shadow-sm">
                            SIMPAN
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<script>
    // Universal Modal Opener / Closer
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    // Live Search Table Functionality
    document.getElementById("searchUser").addEventListener("keyup", function() {
        let value = this.value.toLowerCase();
        let rows = document.querySelectorAll("#userTable tbody tr");
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(value) ? "" : "none";
        });
    });
</script>
@endsection
