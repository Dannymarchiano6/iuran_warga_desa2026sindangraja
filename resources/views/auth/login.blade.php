<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Autentikasi - Iuran Desa Sindangraja</title>
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

    <!-- Ornaments Background 3D -->
    <div class="fixed -top-24 -left-20 w-80 h-80 bg-blue-400/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="fixed -bottom-24 -right-20 w-80 h-80 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10 my-auto">
        <!-- Card Login 3D Minimalis -->
        <div class="bg-white/80 backdrop-blur-xl border border-white/60 rounded-3xl p-6 sm:p-8 shadow-3d relative overflow-hidden">

            <!-- Header Logo & Judul -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center p-3 bg-gradient-to-tr from-blue-50 to-indigo-50 rounded-2xl shadow-inner mb-3 transform hover:scale-105 transition-transform duration-300 border border-blue-100/50">
                    <img src="{{ asset('assets/logodesa.png') }}" alt="Logo Desa" class="w-16 h-auto drop-shadow-md" onerror="this.src='https://flowbite.com/docs/images/logo.svg'">
                </div>
                <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Selamat Datang</h2>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mt-1">Sistem Iuran Desa Sindangraja</p>
            </div>

            <!-- Session Alert Success / Error Custom -->
            @if (session('status'))
                <div id="alert-status" class="flex items-center p-4 mb-6 text-sm text-green-800 rounded-2xl bg-green-50/80 border border-green-200/60 backdrop-blur-sm" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                    </svg>
                    <div class="font-medium text-xs">{{ session('status') }}</div>
                </div>
            @endif

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

            <!-- Form Autentikasi Laravel Blade -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5" autocomplete="off">
                @csrf

                <!-- Input Username -->
                <div>
                    <label for="username" class="block mb-2 text-xs font-bold text-slate-600 uppercase tracking-wider">Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <input type="text" name="username" id="username" value="" autocomplete="off" required autofocus
                            class="bg-slate-50/80 border border-slate-200/80 text-slate-800 text-sm rounded-2xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-3.5 transition-all duration-200 shadow-inner placeholder-slate-400"
                            placeholder="Masukkan username Anda">
                    </div>
                </div>

                <!-- Input Password -->
                <div>
                    <label for="password" class="block mb-2 text-xs font-bold text-slate-600 uppercase tracking-wider">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <input type="password" name="password" id="password" autocomplete="new-password" required
                            class="bg-slate-50/80 border border-slate-200/80 text-slate-800 text-sm rounded-2xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 pe-10 p-3.5 transition-all duration-200 shadow-inner placeholder-slate-400"
                            placeholder="••••••••">

                        <!-- Toggle Password Button -->
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 end-0 flex items-center pe-3.5 text-slate-400 hover:text-slate-600 transition-colors">
                            <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Tombol Submit 3D -->
                <button type="submit" class="w-full text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-2xl text-sm px-5 py-4 text-center transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 shadow-3d-button flex items-center justify-center gap-2 mt-2">
                    <span>MASUK KE SISTEM</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </button>

                <!-- Footer Link -->
                <div class="text-center pt-2">
                    <p class="text-xs text-slate-500">
                        Lupa password atau belum punya akun?
                    </p>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 transition-colors mt-1 inline-block">
                            Daftar / Hubungi Administrator
                        </a>
                    @else
                        <a href="#" class="text-xs font-bold text-blue-600 hover:text-blue-800 transition-colors mt-1 inline-block">
                            Hubungi Administrator
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script>
        // Reset form input pada saat dimuat agar tidak terisi otomatis
        document.addEventListener("DOMContentLoaded", function () {
            const usernameInput = document.getElementById('username');
            const passwordInput = document.getElementById('password');

            if (usernameInput && !usernameInput.hasAttribute('data-has-error')) {
                usernameInput.value = '';
            }
            if (passwordInput) {
                passwordInput.value = '';
            }
        });

        function togglePassword() {
            const passInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (passInput.type === 'password') {
                passInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.018 10.018 0 013.832-.863c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21M3 3l18 18"></path>
                `;
            } else {
                passInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                `;
            }
        }
    </script>
</body>
</html>
