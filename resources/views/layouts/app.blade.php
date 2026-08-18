<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin')</title>

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Tailwind CSS & Flowbite JS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Script Anti Back-History Browser Cache -->
    <script>
        // Deteksi jika halaman dipanggil ulang dari cache memori browser (Tombol Back Browser)
        window.addEventListener("pageshow", function (event) {
            var historyTraversal = event.persisted ||
                (typeof window.performance != "undefined" && window.performance.navigation.type === 2);

            if (historyTraversal) {
                // Paksa redirect ke halaman utama warga (home.blade.php / public.home)
                window.location.href = "{{ route('public.home') }}";
            }
        });
    </script>
</head>
<body class="font-['Poppins',sans-serif] bg-[#f4f7f6] antialiased">
    @yield('content')
</body>
</html>
