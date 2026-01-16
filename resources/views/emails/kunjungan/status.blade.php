<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pendaftaran Kunjungan</title>
    @php
        use App\Enums\KunjunganStatus;
    @endphp
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
            background-color: #f4f7f6;
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border: 1px solid #e9ecef;
        }
        .header {
            background-color: #0d6efd;
            color: white;
            padding: 24px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }
        .content {
            padding: 24px;
        }
        .status-section {
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 24px;
            text-align: center;
        }
        .status-pending {
            background-color: #fff3cd;
            border-left: 5px solid #ffc107;
            color: #664d03;
        }
        .status-approved {
            background-color: #d1e7dd;
            border-left: 5px solid #198754;
            color: #0f5132;
        }
        .status-rejected {
            background-color: #f8d7da;
            border-left: 5px solid #dc3545;
            color: #58151c;
        }
        .status-section h2 {
            margin-top: 0;
            font-size: 20px;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        .details-table th, .details-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }
        .details-table th {
            background-color: #f8f9fa;
            width: 40%;
            font-weight: 600;
            color: #555;
        }
        .qr-code {
            text-align: center;
            margin-top: 24px;
        }
        .qr-code img {
            max-width: 200px;
            height: auto;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 16px;
            text-align: center;
            font-size: 12px;
            color: #6c757d;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #0d6efd;
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin-top: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Lapas Kelas IIB Jombang</h1>
        </div>
        <div class="content">
            @php
                $statusClass = '';
                $statusText = '';
                $statusIcon = '';
                switch ($kunjungan->status) {
                    case KunjunganStatus::APPROVED:
                        $statusClass = 'status-approved';
                        $statusText = 'DISETUJUI';
                        $statusIcon = '✅';
                        break;
                    case KunjunganStatus::REJECTED:
                        $statusClass = 'status-rejected';
                        $statusText = 'DITOLAK';
                        $statusIcon = '❌';
                        break;
                    default:
                        $statusClass = 'status-approved'; // Use green style for success
                        $statusText = 'Selamat Telah Berhasil Mendaftar';
                        $statusIcon = '✅';
                        break;
                }
            @endphp

            <div class="status-section {{ $statusClass }}">
                <h2>{{ $statusIcon }} Status Kunjungan: {{ $statusText }}</h2>
                @if($kunjungan->status == KunjunganStatus::PENDING)
                    <p>Terima kasih telah mendaftar. Silakan datang ke Lapas Jombang sesuai jadwal yang dipilih untuk melakukan verifikasi data dan mendapatkan tiket antrian.</p>
                @elseif($kunjungan->status == KunjunganStatus::APPROVED)
                    <p>Selamat! Pendaftaran kunjungan Anda telah disetujui. Silakan tunjukkan QR Code di bawah ini kepada petugas pada saat jadwal kunjungan.</p>
                @else
                    <p>Mohon maaf, pendaftaran kunjungan Anda ditolak. Silakan hubungi petugas untuk informasi lebih lanjut atau lakukan pendaftaran ulang dengan data yang benar.</p>
                @endif
            </div>

            <h3>Detail Pendaftaran:</h3>
            <table class="details-table">
                <tr>
                    <th>Kode Kunjungan</th>
                    <td>{{ $kunjungan->kode_kunjungan }}</td>
                </tr>
                <tr>
                    <th>Nama Pengunjung</th>
                    <td>{{ $kunjungan->nama_pengunjung }}</td>
                </tr>
                <tr>
                    <th>Warga Binaan yang Dikunjungi</th>
                    <td>{{ $kunjungan->wbp->nama }}</td>
                </tr>
                <tr>
                    <th>Tanggal & Sesi Kunjungan</th>
                    <td>{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('l, d F Y') }} (Sesi {{ ucfirst($kunjungan->sesi) }})</td>
                </tr>
                 <tr>
                    <th>Nomor Antrian</th>
                    <td>{{ $kunjungan->nomor_antrian_harian }}</td>
                </tr>
            </table>

            @if($kunjungan->status == KunjunganStatus::APPROVED || $kunjungan->status == KunjunganStatus::PENDING)
                <div class="qr-code">
                    <h3>QR Code Anda</h3>
                    <p>Gunakan kode ini untuk verifikasi di Lapas.</p>
                    <img src="{{ $message->embed($qrCodePath) }}" alt="QR Code">
                </div>
            @endif

            <div style="text-align: center;">
                 <a href="{{ route('kunjungan.status', $kunjungan->id) }}" class="button">Lihat Status Online</a>
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Lapas Kelas IIB Jombang. Semua Hak Dilindungi.</p>
            <p>Ini adalah email yang dibuat secara otomatis. Mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>
