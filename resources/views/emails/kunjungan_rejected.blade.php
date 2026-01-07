<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .box { border: 1px solid #ffcccc; background-color: #fff5f5; padding: 20px; border-radius: 10px; max-width: 500px; margin: 0 auto; }
        .header { text-align: center; border-bottom: 2px solid #ff4444; padding-bottom: 10px; margin-bottom: 20px; }
        .btn { display: inline-block; background: #ff4444; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="box">
        <div class="header">
            <h2 style="color: #cc0000;">PENDAFTARAN DITOLAK</h2>
            <p>Lapas Kelas IIB Jombang</p>
        </div>
        
        <p>Halo <strong>{{ $kunjungan->nama_pengunjung }}</strong>,</p>
        <p>Mohon maaf, pengajuan kunjungan Anda untuk tanggal <strong>{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('d F Y') }}</strong> tidak dapat kami setujui saat ini.</p>

        <p><strong>Kemungkinan penyebab penolakan:</strong></p>
        <ul>
            <li>Data identitas (KTP) tidak jelas/tidak sesuai.</li>
            <li>Kuota kunjungan pada sesi tersebut sudah penuh.</li>
            <li>Warga Binaan sedang dalam masa isolasi/sanksi.</li>
        </ul>

        <div style="text-align: center; margin-top: 30px;">
            <p>Anda dapat mencoba mendaftar kembali di lain waktu dengan data yang benar.</p>
            <a href="{{ url('/') }}" class="btn">KEMBALI KE WEBSITE</a>
        </div>
    </div>
</body>
</html>