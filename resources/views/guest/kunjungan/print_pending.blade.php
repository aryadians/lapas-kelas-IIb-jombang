<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket Kunjungan - {{ $kunjungan->kode_booking }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inconsolata:wght@400;700&display=swap');
        
        body { font-family: 'Inconsolata', monospace; background-color: #f3f4f6; }
        .ticket { background: white; max-width: 400px; margin: 40px auto; padding: 20px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); position: relative; }
        .pending-watermark {
            position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 3rem; color: rgba(245, 158, 11, 0.2); font-weight: 900;
            pointer-events: none; text-transform: uppercase; letter-spacing: 0.1em;
        }
    </style>
</head>
<body class="p-4">
    <div class="ticket">
        <div class="pending-watermark">DRAFT</div>
        
        <div class="text-center border-b-2 border-dashed border-gray-300 pb-4 mb-4">
            <h2 class="font-bold text-lg uppercase text-amber-600">MENUNGGU VERIFIKASI</h2>
            <p class="text-[10px] text-gray-400">Tiket ini belum sah untuk kunjungan</p>
        </div>

        <div class="text-center mb-6">
            <p class="text-sm font-bold text-gray-500 uppercase">Kode Booking</p>
            <h1 class="text-4xl font-black text-gray-900 my-2">{{ $kunjungan->kode_booking }}</h1>
            <p class="text-xs text-gray-500">Silakan tunggu verifikasi admin.</p>
        </div>

        <div class="space-y-2 border-t border-dashed border-gray-300 pt-4 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-500">Tanggal</span>
                <span class="font-bold">{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->format('d/m/Y') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Pengunjung</span>
                <span class="font-bold text-right">{{ $kunjungan->nama_pengunjung }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">WBP</span>
                <span class="font-bold text-right">{{ optional($kunjungan->wbp)->nama ?? '-' }}</span>
            </div>
        </div>

        <div class="mt-8 text-center text-xs text-gray-400 border-t border-dashed border-gray-300 pt-4">
            <p>Admin sedang memproses verifikasi data Anda.</p>
            <p>Anda akan menerima notifikasi jika telah disetujui.</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        }
    </script>
</body>
</html>