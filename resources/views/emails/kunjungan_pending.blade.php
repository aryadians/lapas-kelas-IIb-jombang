<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .box { border: 1px solid #ddd; padding: 20px; border-radius: 10px; max-width: 500px; margin: 0 auto; }
        .header { text-align: center; border-bottom: 2px solid #FFC107; padding-bottom: 10px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="box">
        <div class="header">
            <h2>PENDAFTARAN DITERIMA</h2>
            <p>Lapas Kelas IIB Jombang</p>
        </div>
        
        <p>Halo <strong>{{ $kunjungan->nama_pengunjung }}</strong>,</p>
        <p>Data pendaftaran kunjungan Anda telah berhasil masuk ke sistem kami.</p>
        
        <p style="background: #fff3cd; padding: 10px; border-radius: 5px; color: #856404;">
            <strong>Status Saat Ini: MENUNGGU VERIFIKASI</strong>
        </p>

        <p>Mohon tunggu beberapa saat. Admin kami akan memeriksa data Anda. Notifikasi persetujuan (Tiket) atau penolakan akan dikirimkan melalui email ini.</p>
        
        <p>Terima kasih.</p>
    </div>
</body>
</html>