<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi Akun - Sistem Iuran Desa Sindangraja</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Tailwind CSS & Flowbite CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    boxShadow: {
                        '3d': '0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01), inset 0 2px 4px 0 rgba(255, 255, 255, 0.6)',
                        '3d-button': '0 10px 15px -3px rgba(37, 99, 235, 0.35), 0 4px 6px -4px rgba(37, 99, 235, 0.2), inset 0 2px 0 0 rgba(255, 255, 255, 0.25)',
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background: radial-gradient(circle at 50% 0%, #e0e7ff 0%, #f1f5f9 60%, #e2e8f0 100%);
        }
    </style>
</head>
<body class="font-sans antialiased min-h-screen flex items-center justify-center p-4 py-8 relative overflow-y-auto">

    <!-- Ornamen Background Dekorasif 3D -->
    <div class="fixed -top-24 -left-20 w-80 h-80 bg-blue-400/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="fixed -bottom-24 -right-20 w-80 h-80 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10 my-auto">
        <!-- Card Register 3D Minimalis -->
        <div class="bg-white/80 backdrop-blur-xl border border-white/60 rounded-3xl p-6 sm:p-8 shadow-3d relative overflow-hidden">

            <!-- Header Logo & Judul -->
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center p-3 bg-gradient-to-tr from-blue-50 to-indigo-50 rounded-2xl shadow-inner mb-3 transform hover:scale-105 transition-transform duration-300 border border-blue-100/50">
                    <img src="{{ asset('assets/logodesa.png') }}" alt="Logo Desa" class="w-14 h-auto drop-shadow-md" onerror="this.src='https://flowbite.com/docs/images/logo.svg'">
                </div>
                <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Registrasi Akun</h2>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mt-1">Lengkapi data untuk akses aplikasi</p>
            </div>

            <!-- Session Alert Success -->
            @if (session('success'))
                <div id="alert-success" class="flex flex-col p-4 mb-6 text-sm text-green-800 rounded-2xl bg-green-50/80 border border-green-200/60 backdrop-blur-sm" role="alert">
                    <div class="flex items-center">
                        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                        </svg>
                        <span class="font-bold text-xs">{{ session('success') }}</span>
                    </div>
                    <a href="{{ route('login') }}" class="mt-3 text-center text-xs font-bold text-white bg-green-600 hover:bg-green-700 py-2 px-4 rounded-xl transition-all shadow-sm">
                        Login Sekarang
                    </a>
                </div>
            @endif

            <!-- Session Alert Errors -->
            @if ($errors->any())
                <div id="alert-error" class="flex items-center p-4 mb-6 text-sm text-red-800 rounded-2xl bg-red-50/80 border border-red-200/60 backdrop-blur-sm" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/>
                    </svg>
                    <div class="font-medium text-xs">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-error" aria-label="Close">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
            @endif

            <!-- Form Registrasi Laravel Blade -->
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Input Nama Lengkap -->
                <div>
                    <label for="nama_lengkap" class="block mb-1.5 text-xs font-bold text-slate-600 uppercase tracking-wider">Nama Lengkap</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                            </svg>
                        </div>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}" required autofocus
                            class="bg-slate-50/80 border border-slate-200/80 text-slate-800 text-sm rounded-2xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-3 transition-all duration-200 shadow-inner placeholder-slate-400"
                            placeholder="Nama asli Anda">
                    </div>
                </div>

                <!-- Input Username -->
                <div>
                    <label for="username" class="block mb-1.5 text-xs font-bold text-slate-600 uppercase tracking-wider">Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <input type="text" name="username" id="username" value="{{ old('username') }}" required
                            class="bg-slate-50/80 border border-slate-200/80 text-slate-800 text-sm rounded-2xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-3 transition-all duration-200 shadow-inner placeholder-slate-400"
                            placeholder="username123">
                    </div>
                </div>

                <!-- Grid Password & Konfirmasi -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label for="password" class="block mb-1.5 text-xs font-bold text-slate-600 uppercase tracking-wider">Password</label>
                        <input type="password" name="password" id="password" required
                            class="bg-slate-50/80 border border-slate-200/80 text-slate-800 text-sm rounded-2xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition-all duration-200 shadow-inner placeholder-slate-400"
                            placeholder="••••••••">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block mb-1.5 text-xs font-bold text-slate-600 uppercase tracking-wider">Konfirmasi</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="bg-slate-50/80 border border-slate-200/80 text-slate-800 text-sm rounded-2xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition-all duration-200 shadow-inner placeholder-slate-400"
                            placeholder="••••••••">
                    </div>
                </div>

                <!-- Tombol Submit 3D -->
                <button type="submit" class="w-full text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-2xl text-sm px-5 py-3.5 text-center transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 shadow-3d-button flex items-center justify-center gap-2 mt-4">
                    <span>DAFTAR AKUN</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </button>

                <!-- Footer Link -->
                <div class="text-center pt-2">
                    <p class="text-xs text-slate-500">
                        Sudah punya akses?
                    </p>
                    <a href="{{ route('login') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 transition-colors mt-1 inline-block">
                        Kembali ke Login
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</body>
</html>
