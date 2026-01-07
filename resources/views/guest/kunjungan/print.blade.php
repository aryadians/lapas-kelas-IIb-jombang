<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket Kunjungan - {{ $kunjungan->kode_kunjungan }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inconsolata:wght@400;700&display=swap');
        
        body {
            font-family: 'Inconsolata', monospace; /* Font struk */
            background-color: #f3f4f6;
        }
        .ticket {
            background: white;
            max-width: 400px; /* Lebar struk standar */
            margin: 40px auto;
            padding: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        /* Efek gerigi kertas di bawah */
        .ticket::after {
            content: "";
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100%;
            height: 10px;
            background: radial-gradient(circle, transparent 70%, white 70%) 0 0;
            background-size: 20px 20px;
            transform: rotate(180deg);
        }

        @media print {
            body { background: white; }
            .ticket { box-shadow: none; margin: 0; width: 100%; max-width: 100%; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

    <div class="ticket">
        
        {{-- HEADER --}}
        <div class="text-center border-b-2 border-dashed border-gray-300 pb-4 mb-4">
            <h2 class="font-bold text-xl uppercase text-gray-800">LAPAS KELAS IIB</h2>
            <h3 class="font-bold text-lg uppercase text-gray-800">JOMBANG</h3>
            <p class="text-xs text-gray-500 mt-1">Jl. KH. Wahid Hasyim No.123, Jombang</p>
            <p class="text-xs text-gray-500">Layanan Kunjungan Tatap Muka</p>
        </div>

        {{-- NOMOR ANTRIAN --}}
        <div class="text-center mb-6">
            <p class="text-sm font-bold text-gray-500 uppercase">Nomor Antrian</p>
            <h1 class="text-6xl font-black text-gray-900 my-2">{{ $kunjungan->nomor_antrian_harian }}</h1>
            <span class="inline-block bg-black text-white px-3 py-1 text-sm font-bold rounded uppercase">
                Sesi: {{ $kunjungan->sesi ?? 'Umum' }}
            </span>
        </div>

        {{-- QR CODE --}}
        <div class="flex justify-center mb-6">
            {{-- Menggunakan API QR Code Server (Gratis & Stabil) --}}
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ $kunjungan->qr_token }}&bgcolor=ffffff" 
                 alt="QR Code" class="w-40 h-40 border-4 border-gray-800 p-1 rounded">
        </div>
        <p class="text-center text-xs font-mono mb-6">{{ $kunjungan->qr_token }}</p>

        {{-- DETAIL DATA --}}
        <div class="space-y-2 border-t border-dashed border-gray-300 pt-4 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-500">Tanggal</span>
                <span class="font-bold">{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->format('d/m/Y') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Pengunjung</span>
                <span class="font-bold text-right w-32 truncate">{{ $kunjungan->nama_pengunjung }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Tujuan WBP</span>
                {{-- Gunakan optional() untuk menghindari error jika WBP terhapus --}}
                <span class="font-bold text-right w-32 truncate">{{ optional($kunjungan->wbp)->nama ?? '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Pengikut</span>
                <span class="font-bold">{{ $kunjungan->pengikuts->count() }} Orang</span>
            </div>
        </div>

        {{-- FOOTER --}}
        <div class="mt-8 text-center text-xs text-gray-400 border-t border-dashed border-gray-300 pt-4">
            <p>Harap membawa KTP Asli saat berkunjung.</p>
            <p class="mt-1">Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
            <p class="mt-4 font-bold text-gray-300">--- TERIMA KASIH ---</p>
        </div>

    </div>

    {{-- TOMBOL PRINT (Hanya tampil di layar) --}}
    <div class="fixed bottom-6 right-6 no-print flex gap-2">
        <button onclick="window.close()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-full shadow-lg transition">
            Tutup
        </button>
        <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-full shadow-lg transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak Tiket
        </button>
    </div>

    <script>
        // Otomatis muncul dialog print saat halaman dibuka
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        }
    </script>
</body>
</html>