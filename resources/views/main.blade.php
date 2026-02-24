<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lapas Kelas IIB Jombang</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom Navy Colors */
        .bg-navy-dark {
            background-color: #0f172a;
        }

        /* Slate 900 */
        .bg-navy-light {
            background-color: #1e293b;
        }

        /* Slate 800 */
        .text-gold {
            color: #fbbf24;
        }

        /* Aksen Emas agar elegan */
    </style>
</head>

<body class="bg-gray-50 flex flex-col min-h-screen">

    <nav class="bg-navy-dark text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-navy-dark font-bold">L</div>
                <div>
                    <h1 class="text-xl font-bold tracking-wide">LAPAS KELAS IIB JOMBANG</h1>
                    <p class="text-xs text-gray-300">Kelas IIB - Kanwil Jawa Timur</p>
                </div>
            </a>
            <div class="hidden md:flex space-x-8 font-medium">
                <a href="/" class="hover:text-gold transition">Beranda</a>
                <a href="#profil" class="hover:text-gold transition">Profil</a>
                <a href="#berita" class="hover:text-gold transition">Berita</a>
                <a href="#pengumuman" class="hover:text-gold transition">Pengumuman</a>
            </div>
            <div>
                <a href="/login" class="bg-blue-700 hover:bg-blue-600 px-4 py-2 rounded text-sm font-semibold transition">Login Admin</a>
            </div>
        </div>
    </nav>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-navy-dark text-gray-300 py-10 mt-10">
        <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-white text-lg font-bold mb-4 border-b border-gray-600 pb-2">Lapas Kelas IIB Jombang</h3>
                <p class="text-sm">Mewujudkan pelayanan pemasyarakatan yang PASTI (Profesional, Akuntabel, Sinergi, Transparan, Inovatif).</p>
            </div>
            <div>
                <h3 class="text-white text-lg font-bold mb-4 border-b border-gray-600 pb-2">Hubungi Kami</h3>
                <ul class="text-sm space-y-2">
                    <li>📍 Jl. KH. Wahid Hasyim, Jombang</li>
                    <li>📞 (0321) 123456</li>
                    <li>📧 humas@lapasjombang.go.id</li>
                </ul>
            </div>
            <div>
                <h3 class="text-white text-lg font-bold mb-4 border-b border-gray-600 pb-2">Tautan Terkait</h3>
                <ul class="text-sm space-y-2">
                    <li><a href="#" class="hover:text-white">Ditjen Pas</a></li>
                    <li><a href="#" class="hover:text-white">Keminipas Jatim</a></li>
                </ul>
            </div>
        </div>
        <div class="text-center text-xs mt-10 border-t border-gray-700 pt-4">
            &copy; 2025 Lapas Kelas IIB Jombang. All rights reserved.
        </div>
    </footer>

</body>

</html>