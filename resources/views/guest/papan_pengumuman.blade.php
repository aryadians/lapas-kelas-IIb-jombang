<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Papan Informasi Kunjungan - Lapas Jombang</title>
    <meta http-equiv="refresh" content="300"> 
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-color: #1a202c;
            color: #e2e8f0;
            font-family: 'Inter', sans-serif;
        }
        .text-glow {
            text-shadow: 0 0 8px rgba(59, 130, 246, 0.5), 0 0 20px rgba(59, 130, 246, 0.3);
        }
        .marquee-container {
            overflow: hidden;
            position: relative;
            width: 100%;
            height: 50px;
        }
        .marquee-text {
            position: absolute;
            white-space: nowrap;
            will-change: transform;
            animation: marquee 30s linear infinite;
        }
        @keyframes marquee {
            from { transform: translateX(100%); }
            to { transform: translateX(-100%); }
        }
    </style>
</head>
<body class="antialiased" x-data="papanData()">
    <div class="container mx-auto p-4 md:p-8">
        <header class="flex justify-between items-center mb-6 border-b-2 border-gray-700 pb-4">
            <div class="flex items-center">
                <img src="{{ asset('img/logo.png') }}" alt="Logo Lapas Jombang" class="h-16 mr-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-white">Lembaga Pemasyarakatan Kelas IIB Jombang</h1>
                    <p class="text-lg text-gray-400">Papan Informasi Kunjungan</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-white" x-text="currentTime"></p>
                <p class="text-lg text-gray-400" x-text="currentDate"></p>
            </div>
        </header>

        <main class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Kolom Kiri: Antrian & Jadwal --}}
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-gray-800 rounded-2xl p-6 shadow-lg h-full">
                    <h2 class="text-2xl font-bold text-center text-blue-300 mb-4">NOMOR ANTRIAN SAAT INI</h2>
                    <div class="flex items-center justify-center bg-gray-900 rounded-xl p-8">
                        <p class="text-8xl font-black text-glow text-blue-400" x-text="antrian.nomor_antrian_sekarang ?? '---'"></p>
                    </div>

                    <h2 class="text-2xl font-bold text-center text-blue-300 mt-8 mb-4">JADWAL KUNJUNGAN HARI INI</h2>
                    <div class="space-y-3 text-lg">
                        <div class="flex justify-between items-center bg-gray-700/50 p-4 rounded-lg">
                            <span class="font-semibold text-gray-300">Sesi Pagi</span>
                            <span class="font-bold text-green-400">08:00 - 12:00 WIB</span>
                        </div>
                        <div class="flex justify-between items-center bg-gray-700/50 p-4 rounded-lg">
                            <span class="font-semibold text-gray-300">Sesi Siang</span>
                            <span class="font-bold text-green-400">13:00 - 15:00 WIB</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Pengumuman Berjalan --}}
            <div class="lg:col-span-2 bg-gray-800 rounded-2xl p-6 shadow-lg">
                <h2 class="text-2xl font-bold text-center text-amber-300 mb-4">PENGUMUMAN PENTING</h2>
                <div class="bg-gray-900 rounded-xl p-6 h-full text-xl text-gray-300 leading-relaxed">
                    <ul class="list-disc list-inside space-y-4">
                        <template x-for="item in announcements" :key="item.id">
                            <li x-text="item.title"></li>
                        </template>
                         <template x-if="announcements.length === 0">
                            <li>Tidak ada pengumuman penting saat ini.</li>
                        </template>
                    </ul>
                </div>
            </div>
        </main>

        <footer class="mt-6 bg-gray-900/50 rounded-2xl p-4 text-center text-white text-lg">
            <div class="marquee-container">
                <p class="marquee-text font-semibold" x-text="runningText"></p>
            </div>
        </footer>
    </div>

    <script>
        function papanData() {
            return {
                currentTime: '',
                currentDate: '',
                antrian: { nomor_antrian_sekarang: null },
                announcements: [],
                runningText: 'SELALU PATUHI TATA TERTIB KUNJUNGAN. DILARANG MEMBAWA SENJATA TAJAM, NARKOBA, DAN BARANG BERBAHAYA LAINNYA. TERIMA KASIH ATAS KERJA SAMANYA.',
                
                init() {
                    this.updateTime();
                    setInterval(() => this.updateTime(), 1000);
                    
                    this.fetchAntrian();
                    setInterval(() => this.fetchAntrian(), 5000); // Ambil data antrian setiap 5 detik

                    this.fetchAnnouncements();
                    setInterval(() => this.fetchAnnouncements(), 60000); // Ambil data pengumuman setiap 1 menit
                },

                updateTime() {
                    const now = new Date();
                    this.currentTime = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                    this.currentDate = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
                },
                
                fetchAntrian() {
                    fetch('{{ route('api.antrian.status') }}')
                        .then(response => response.json())
                        .then(data => {
                            this.antrian = data;
                        })
                        .catch(error => console.error('Error fetching antrian:', error));
                },

                fetchAnnouncements() {
                    fetch('{{ route('announcements.public.index') }}?json=true') // Asumsi endpoint bisa return JSON
                        .then(response => response.json())
                        .then(data => {
                            this.announcements = data.data; // Sesuaikan dengan struktur data Anda
                        })
                        .catch(error => console.error('Error fetching announcements:', error));
                }
            }
        }
    </script>
</body>
</html>
