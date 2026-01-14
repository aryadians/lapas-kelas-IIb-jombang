<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Kunjungan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
@php
    use App\Enums\KunjunganStatus;
@endphp
<body class="bg-slate-100">
    <div class="max-w-lg mx-auto my-8 bg-white rounded-lg shadow-lg p-6">
        <div class="text-center mb-6 border-b pb-4">
            <h1 class="text-2xl font-bold text-slate-800">Verifikasi Kunjungan</h1>
            <p class="text-sm text-slate-500">Lapas Kelas IIB Jombang</p>
        </div>

        @if($kunjungan->status == KunjunganStatus::APPROVED)
            <div class="bg-green-100 border-4 border-green-500 text-green-800 text-center font-bold text-2xl py-4 rounded-lg mb-6">
                DISETUJUI
            </div>
        @elseif($kunjungan->status == KunjunganStatus::REJECTED)
            <div class="bg-red-100 border-4 border-red-500 text-red-800 text-center font-bold text-2xl py-4 rounded-lg mb-6">
                DITOLAK
            </div>
        @else
            <div class="bg-yellow-100 border-4 border-yellow-500 text-yellow-800 text-center font-bold text-2xl py-4 rounded-lg mb-6">
                MENUNGGU
            </div>
        @endif

        <div class="space-y-4">
            <div>
                <p class="text-sm text-slate-500">Nama Pengunjung</p>
                <p class="text-lg font-bold text-slate-900">{{ $kunjungan->nama_pengunjung }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500">NIK Pengunjung</p>
                <p class="text-lg font-bold text-slate-900">{{ $kunjungan->nik_pengunjung }}</p>
            </div>
            <hr>
            <div>
                <p class="text-sm text-slate-500">Warga Binaan yang Dikunjungi</p>
                <p class="text-lg font-bold text-slate-900">{{ $kunjungan->nama_wbp }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500">Tanggal Kunjungan</p>
                <p class="text-lg font-bold text-slate-900">{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('l, d F Y') }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500">Sesi</p>
                <p class="text-lg font-bold text-slate-900">{{ $kunjungan->sesi ? 'Sesi ' . ucfirst($kunjungan->sesi) : '-' }}</p>
            </div>
             <div>
                <p class="text-sm text-slate-500">Nomor Antrian</p>
                <p class="text-lg font-bold text-slate-900">#{{ $kunjungan->nomor_antrian_harian }}</p>
            </div>
        </div>

        <div class="mt-8 pt-4 border-t text-center text-xs text-slate-400">
            ID Pendaftaran: {{ $kunjungan->id }}<br>
            Waktu Pindai: {{ now()->translatedFormat('d F Y, H:i:s') }}
        </div>
    </div>
</body>
</html>
