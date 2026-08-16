<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Iuran Warga - Desa Sindangraja</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .hover-card { transition: all 0.3s ease; }
        .hover-card:hover { transform: translateY(-10px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); }
        .map-placeholder { background: linear-gradient(45deg, #e2e8f0, #cbd5e1); }
    </style>
</head>
<body class="bg-gray-50 font-sans text-gray-900">

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-xl font-bold text-blue-700"><i class="bi bi-wallet2 me-2"></i>IuranDesa</span>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#" class="text-gray-600 hover:text-blue-600 font-medium">Beranda</a>
                    <a href="#" class="text-gray-600 hover:text-blue-600 font-medium">Info Desa</a>
                    <a href="#" class="text-gray-600 hover:text-blue-600 font-medium">Layanan</a>
                    <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Login Warga</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="relative bg-blue-900 py-16 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 relative z-10 text-center">
            <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-6">Portal Layanan Iuran Warga</h1>
            <p class="text-blue-200 text-lg mb-8 max-w-2xl mx-auto">Sistem transparansi pembayaran iuran desa untuk kenyamanan dan pembangunan wilayah Sindangraja.</p>

            <!-- Quick Action Input -->
            <div class="max-w-xl mx-auto bg-white p-2 rounded-xl shadow-lg flex flex-col sm:flex-row gap-2">
                <input type="text" placeholder="Masukkan NIK untuk cek status iuran..." class="flex-1 px-4 py-3 rounded-lg focus:outline-none text-gray-700">
                <button class="bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700 transition">
                    <i class="bi bi-search me-2"></i> Cek Status
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="max-w-7xl mx-auto px-4 py-12">

        <!-- Service Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
            <!-- Card 1 -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 hover-card">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-4 text-2xl"><i class="bi bi-credit-card"></i></div>
                <h3 class="font-bold text-lg mb-2">Bayar Iuran</h3>
                <p class="text-gray-500 text-sm mb-4">Proses pembayaran iuran bulanan secara online dan aman.</p>
            </div>
            <!-- Card 2 -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 hover-card">
                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center mb-4 text-2xl"><i class="bi bi-clock-history"></i></div>
                <h3 class="font-bold text-lg mb-2">Riwayat</h3>
                <p class="text-gray-500 text-sm mb-4">Lihat catatan riwayat pembayaran iuran tahunan Anda.</p>
            </div>
            <!-- Card 3 -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 hover-card">
                <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center mb-4 text-2xl"><i class="bi bi-megaphone"></i></div>
                <h3 class="font-bold text-lg mb-2">Pengumuman</h3>
                <p class="text-gray-500 text-sm mb-4">Update informasi penting dan kegiatan desa terkini.</p>
            </div>
            <!-- Card 4 -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 hover-card">
                <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center mb-4 text-2xl"><i class="bi bi-file-earmark-text"></i></div>
                <h3 class="font-bold text-lg mb-2">Laporan Kas</h3>
                <p class="text-gray-500 text-sm mb-4">Transparansi penggunaan dana kas desa untuk warga.</p>
            </div>
        </div>

        <!-- Section Info & Map -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl font-bold mb-6">Informasi & Lokasi Desa</h2>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    Kami hadir untuk memudahkan akses layanan warga. Kantor desa Sindangraja berlokasi strategis untuk melayani administrasi warga setiap hari kerja. Pastikan NIK Anda terdaftar untuk mengakses seluruh fitur layanan kami.
                </p>
                <div class="space-y-4">
                    <div class="flex items-center"><i class="bi bi-geo-alt-fill text-blue-600 me-3"></i> <span>Jl. Desa Sindangraja, Cianjur, Jawa Barat</span></div>
                    <div class="flex items-center"><i class="bi bi-telephone-fill text-blue-600 me-3"></i> <span>(0263) 12345678</span></div>
                </div>
            </div>
            <!-- Map Placeholder -->
            <div class="map-placeholder h-80 rounded-3xl flex items-center justify-center shadow-inner border-4 border-white">
                <p class="text-gray-500 font-medium"><i class="bi bi-map text-4xl block mb-2"></i> Peta Lokasi Kantor Desa</p>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-12">
            <div>
                <h4 class="text-white font-bold mb-4">Tentang Kami</h4>
                <p class="text-sm">Sistem Informasi Iuran Desa yang dirancang untuk mempermudah warga dalam kewajiban iuran dan transparansi pembangunan desa.</p>
            </div>
            <div>
                <h4 class="text-white font-bold mb-4">Link Cepat</h4>
                <ul class="text-sm space-y-2">
                    <li><a href="#" class="hover:text-white">Dinas Terkait</a></li>
                    <li><a href="#" class="hover:text-white">Panduan Pembayaran</a></li>
                    <li><a href="#" class="hover:text-white">Kontak Pengurus</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold mb-4">Media Sosial</h4>
                <div class="flex space-x-4">
                    <a href="#" class="text-xl hover:text-blue-400"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-xl hover:text-blue-400"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-xl hover:text-blue-400"><i class="bi bi-twitter"></i></a>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 mt-12 pt-8 border-t border-gray-800 text-center text-xs">
            &copy; 2026 Desa Sindangraja. Dikembangkan oleh Tim IT Desa.
        </div>
    </footer>

</body>
</html>
