<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f3f4f6; margin: 0; padding: 0; width: 100%; -webkit-text-size-adjust: none; }
        .email-wrapper { width: 100%; margin: 0; padding: 20px; background-color: #f3f4f6; }
        .email-content { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .header { background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); padding: 30px 20px; text-align: center; border-bottom: 4px solid #fbbf24; }
        .body { padding: 30px; color: #334155; line-height: 1.6; }
        .footer { background-color: #f8fafc; padding: 20px; text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0; }
        h1 { margin: 0; font-size: 20px; font-weight: bold; color: #fbbf24; text-transform: uppercase; letter-spacing: 1px; }
        h2 { margin-top: 0; font-size: 18px; font-weight: bold; color: #1e293b; }
        p { margin-bottom: 15px; }
        .info-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 14px; }
        .info-table td { padding: 8px 0; border-bottom: 1px solid #f1f5f9; }
        .info-table td:first-child { font-weight: bold; color: #64748b; width: 40%; }
        .info-table td:last-child { font-weight: bold; color: #1e293b; }
        .badge { padding: 8px 16px; border-radius: 50px; font-weight: bold; font-size: 14px; display: inline-block; }
        .badge-warning { background-color: #fffbeb; color: #b45309; border: 1px solid #f59e0b; }
        .logo-img { height: 60px; width: auto; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-content">
            
            <div class="header">
                <img src="{{ $message->embed(public_path('img/logo.png')) }}" alt="Logo Lapas" class="logo-img">
                <h1>Lapas Kelas IIB Jombang</h1>
                <div style="color: #cbd5e1; font-size: 12px; margin-top: 5px;">Kementerian Imigrasi dan Pemasyarakatan Republik Indonesia</div>
            </div>

            <div class="body">
                <div style="text-align: center; margin-bottom: 25px;">
                    <span class="badge badge-warning">⏰ PENGINGAT KUNJUNGAN BESOK</span>
                </div>

                <h2>Halo, {{ $kunjungan->nama_pengunjung }}</h2>
                <p>Ini adalah pengingat bahwa jadwal kunjungan tatap muka Anda adalah <strong>BESOK</strong>. Mohon persiapkan diri Anda dan perhatikan detail berikut:</p>

                <table class="info-table">
                    <tr>
                        <td>No. Pendaftaran</td>
                        <td style="color: #2563eb;">#{{ $kunjungan->id }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td><strong>{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('l, d F Y') }}</strong></td>
                    </tr>
                    <tr>
                        <td>Sesi</td>
                        <td>{{ ucfirst($kunjungan->sesi) }}</td>
                    </tr>
                    <tr>
                        <td>Warga Binaan</td>
                        <td>{{ $kunjungan->wbp->nama }}</td>
                    </tr>
                </table>

                @if($kunjungan->qr_token)
                <div style="text-align: center; margin: 25px 0; padding: 20px; background: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 8px;">
                    <p style="margin: 0 0 15px 0; color: #64748b; font-size: 13px;">Jangan lupa tunjukkan QR Code ini kepada petugas:</p>
                    <img src="data:image/png;base64, {!! base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(180)->generate($kunjungan->qr_token)) !!}" alt="QR Code">
                </div>
                @endif

                <div style="background-color: #fffbeb; border-left: 4px solid #f59e0b; padding: 15px; font-size: 13px; color: #92400e; margin-top: 20px;">
                    <strong>⚠️ Tata Tertib Penting:</strong>
                    <ul style="margin: 5px 0 0 0; padding-left: 20px;">
                        <li>Wajib membawa KTP/Identitas Asli yang masih berlaku.</li>
                        <li>Datang 15 menit sebelum jam sesi dimulai untuk verifikasi.</li>
                        <li>Berpakaian sopan dan rapi.</li>
                        <li>Dilarang membawa barang terlarang (HP, Sajam, Narkoba, dll).</li>
                    </ul>
                </div>

                <p style="margin-top: 25px;">Kami tunggu kedatangan Anda besok. Terima kasih atas kerja sama Anda.</p>

            </div>

            <div class="footer">
                <p style="margin: 0; font-weight: bold;">Lembaga Pemasyarakatan Kelas IIB Jombang</p>
                <p style="margin: 5px 0 0 0;">Jl. Wahid Hasyim No. 123, Jombang, Jawa Timur</p>
                <p style="margin: 15px 0 0 0; opacity: 0.7;">&copy; {{ date('Y') }} Sistem Informasi Lapas Kelas IIB Jombang. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
