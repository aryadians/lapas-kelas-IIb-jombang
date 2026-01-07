<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .box { border: 1px solid #ddd; padding: 20px; border-radius: 10px; max-width: 500px; margin: 0 auto; }
        .header { text-align: center; border-bottom: 2px solid #4CAF50; padding-bottom: 10px; margin-bottom: 20px; }
        .details { margin-bottom: 20px; }
        .details p { margin: 5px 0; }
        .btn { display: inline-block; background: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; }
        .footer { font-size: 12px; color: #777; text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="box">
        <div class="header">
            <h2>KUNJUNGAN DISETUJUI</h2>
            <p>Lapas Kelas IIB Jombang</p>
        </div>
        
        <p>Halo <strong>{{ $kunjungan->nama_pengunjung }}</strong>,</p>
        <p>Selamat! Pendaftaran kunjungan Anda telah diverifikasi dan <strong>DISETUJUI</strong> oleh petugas.</p>

        <div class="details" style="background: #f9f9f9; padding: 15px; border-radius: 5px;">
            <p><strong>Kode Tiket:</strong> {{ $kunjungan->kode_kunjungan }}</p>
            <p><strong>Nomor Antrian:</strong> #{{ $kunjungan->nomor_antrian_harian }}</p>
            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('l, d F Y') }}</p>
            <p><strong>Sesi:</strong> {{ ucfirst($kunjungan->sesi) }}</p>
            <p><strong>WBP Tujuan:</strong> {{ $kunjungan->wbp->nama ?? '-' }}</p>
        </div>

        <div style="text-align: center;">
            <p>Silakan klik tombol di bawah untuk melihat Tiket QR Code Anda:</p>
            <a href="{{ route('kunjungan.status', $kunjungan->id) }}" class="btn">LIHAT TIKET SAYA</a>
        </div>

        <div class="footer">
            <p>Harap datang 15 menit sebelum jadwal sesi dimulai.<br>
            Bawa KTP Asli dan barang bawaan sesuai aturan.</p>
        </div>
    </div>
</body>
</html>