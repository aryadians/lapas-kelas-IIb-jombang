<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; background-color: #f4f7f6; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 20px auto; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .header { background: #1e3a8a; color: #fff; text-align: center; padding: 20px; border-bottom: 5px solid #facc15; }
        .header h1 { margin: 0; font-size: 24px; }
        .content { padding: 30px; }
        .alert-box { background: #fee2e2; border-left: 5px solid #ef4444; padding: 15px; margin-bottom: 20px; border-radius: 4px; }
        .alert-box p { margin: 0; color: #b91c1c; font-weight: bold; }
        .footer { background: #f1f5f9; text-align: center; padding: 15px; font-size: 12px; color: #64748b; border-top: 1px solid #e2e8f0; }
        .data-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .data-table th, .data-table td { padding: 10px; border-bottom: 1px solid #e2e8f0; text-align: left; }
        .data-table th { width: 40%; color: #475569; }
        .data-table td { font-weight: 600; color: #1e293b; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Pemberitahuan Pembatalan Kunjungan</h1>
        </div>
        <div class="content">
            <p>Yth. Saudara/i <strong>{{ $kunjungan->nama_pengunjung }}</strong>,</p>
            
            <div class="alert-box">
                <p>Mohon maaf, pendaftaran kunjungan Anda terpaksa dibatalkan secara otomatis oleh sistem.</p>
            </div>

            <p>Hal ini dikarenakan Warga Binaan Pemasyarakatan (WBP) yang hendak Anda kunjungi saat ini <strong>tidak dapat menerima kunjungan</strong> dengan alasan:</p>

            <table class="data-table">
                <tr>
                    <th>Nama WBP</th>
                    <td>{{ $wbp->nama }}</td>
                </tr>
                <tr>
                    <th>Status Saat Ini</th>
                    <td>{{ $restriction->type }}</td>
                </tr>
                <tr>
                    <th>Periode Pembatasan</th>
                    <td>{{ \Carbon\Carbon::parse($restriction->start_date)->format('d/m/Y') }} s.d. {{ \Carbon\Carbon::parse($restriction->end_date)->format('d/m/Y') }}</td>
                </tr>
            </table>

            <p style="margin-top: 25px;">Oleh karena itu, tiket pendaftaran Anda untuk tanggal <strong>{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->format('d/m/Y') }}</strong> (Kode Booking: {{ $kunjungan->kode_booking }}) telah dibatalkan.</p>
            <p>Silakan melakukan pendaftaran kembali setelah masa pembatasan tersebut berakhir. Kami mohon maaf atas ketidaknyamanan ini dan terima kasih atas pengertiannya.</p>
        </div>
        <div class="footer">
            Hormat kami,<br>
            <strong>Layanan Kunjungan Lapas Kelas IIB Jombang</strong><br>
            <em>Pesan ini dihasilkan secara otomatis, mohon tidak membalas email ini.</em>
        </div>
    </div>
</body>
</html>