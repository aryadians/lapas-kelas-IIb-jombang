<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Draft Tiket - {{ $kunjungan->kode_booking }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inconsolata:wght@400;700&display=swap');
        body { font-family: 'Inconsolata', monospace; background-color: #f3f4f6; }
        .ticket { background: white; max-width: 400px; margin: 40px auto; padding: 20px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); position: relative; overflow: hidden; }
        .pending-watermark {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            display: flex; align-items: center; justify-content: center;
            font-size: 5rem; color: rgba(245, 158, 11, 0.08); font-weight: 900;
            pointer-events: none; text-transform: uppercase; letter-spacing: 0.1em;
            z-index: 0; transform: rotate(-45deg);
        }
        .content-wrapper { position: relative; z-index: 1; }
        @media print {
            body { background: white; width: 220px; margin: 0; padding: 0; }
            .ticket { box-shadow: none; margin: 0; width: 100%; padding: 5px; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="p-4">
    <div class="ticket">
        <div class="pending-watermark">DRAFT</div>
        
        <div class="content-wrapper">
            <div class="text-center border-b-2 border-dashed border-gray-300 pb-4 mb-4">
                <h2 class="font-bold text-lg uppercase text-amber-600">MENUNGGU VERIFIKASI</h2>
                <p class="text-[10px] text-gray-400">Tiket ini belum sah untuk kunjungan</p>
            </div>

            <div class="text-center mb-4">
                <p class="text-xs font-bold text-gray-500 uppercase">Kode Booking</p>
                <h1 class="text-3xl font-black text-gray-900 my-1">{{ $kunjungan->kode_booking }}</h1>
            </div>

            <div class="flex justify-center mb-4">
                <img src="{{ $kunjungan->qr_code_url }}" alt="QR Code" class="w-20 h-20 border-2 border-gray-800 p-1">
            </div>

            <div class="space-y-1.5 border-t border-dashed border-gray-300 pt-3 text-xs">
                <div class="flex justify-between">
                    <span class="text-gray-500">Tanggal</span>
                    <span class="font-bold">{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->format('d/m/Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Pengunjung</span>
                    <span class="font-bold text-right">{{ $kunjungan->nama_pengunjung }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Tujuan WBP</span>
                    <span class="font-bold text-right">{{ optional($kunjungan->wbp)->nama ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Alamat</span>
                    <span class="font-bold text-right truncate w-48">{{ $kunjungan->alamat_lengkap ?? '-' }}</span>
                </div>

                <div class="border-t border-dashed border-gray-200 mt-2 pt-2">
                    <p class="text-gray-500 mb-1">Pengikut ({{ $kunjungan->pengikuts->count() }}):</p>
                    @forelse($kunjungan->pengikuts as $p)
                        <div class="flex justify-between text-[10px]">
                            <span>- {{ $p->nama }}</span>
                            <span class="font-bold italic">{{ $p->hubungan }}</span>
                        </div>
                    @empty
                        <p class="text-[10px] text-gray-400 italic">Tidak ada pengikut</p>
                    @endforelse
                </div>
            </div>

            <div class="mt-6 text-center text-[10px] text-gray-400 border-t border-dashed border-gray-300 pt-3">
                <p>Admin sedang memproses verifikasi.</p>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() { window.print(); }, 500);
        }
    </script>
</body>
</html>