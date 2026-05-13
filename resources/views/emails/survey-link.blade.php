<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f3f4f6; margin: 0; padding: 0; width: 100%; -webkit-text-size-adjust: none; }
        .email-wrapper { width: 100%; margin: 0; padding: 20px; background-color: #f3f4f6; }
        .email-content { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .header { background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); padding: 35px 20px; text-align: center; border-bottom: 4px solid #fbbf24; }
        .body { padding: 40px 30px; color: #334155; line-height: 1.6; }
        .footer { background-color: #f8fafc; padding: 25px; text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0; }
        h1 { margin: 0; font-size: 22px; font-weight: bold; color: #fbbf24; text-transform: uppercase; letter-spacing: 1px; }
        h2 { margin-top: 0; font-size: 20px; font-weight: bold; color: #1e293b; }
        p { margin-bottom: 15px; font-size: 15px; }
        .btn { display: inline-block; padding: 14px 28px; border-radius: 8px; font-weight: bold; text-decoration: none; color: white !important; margin: 25px 0; background-color: #3b82f6; box-shadow: 0 4px 6px rgba(59, 130, 246, 0.3); transition: all 0.3s ease; }
        .btn:hover { background-color: #2563eb; transform: translateY(-1px); }
        .logo-img { height: 70px; width: auto; margin-bottom: 15px; }
        .survey-card { background-color: #f0f9ff; border: 1px solid #bae6fd; border-radius: 12px; padding: 20px; margin: 20px 0; text-align: center; }
        .divider { height: 1px; background-color: #e2e8f0; margin: 30px 0; }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-content">
            
            {{-- HEADER --}}
            <div class="header">
                <img src="{{ $message->embed(public_path('img/logo.png')) }}" alt="Logo Lapas" class="logo-img">
                <h1>Lapas Kelas IIB Jombang</h1>
                <div style="color: #cbd5e1; font-size: 13px; margin-top: 8px; font-weight: 500;">Sistem Informasi Layanan Kunjungan</div>
            </div>

            <div class="body">
                <h2>Halo, {{ $kunjungan->nama_pengunjung }}</h2>
                <p>Terima kasih telah mengunjungi keluarga/kerabat Anda di <strong>Lapas Kelas IIB Jombang</strong>. Kami berharap layanan yang kami berikan memberikan kenyamanan bagi Anda.</p>
                
                <div class="divider"></div>

                <div class="survey-card">
                    <p style="color: #0369a1; font-weight: 600; margin-bottom: 10px;">Bantu Kami Menjadi Lebih Baik!</p>
                    <p style="font-size: 14px; color: #0c4a6e;">Kami sangat menghargai waktu Anda untuk mengisi survei kepuasan layanan sebagai bahan evaluasi dan peningkatan kualitas pelayanan kami ke depan.</p>
                    
                    <a href="{{ $surveyUrl }}" class="btn">Isi Survei Kepuasan</a>
                </div>

                <div class="divider"></div>

                <p style="font-size: 14px; color: #64748b;">Setiap masukan dari Anda sangat berarti bagi kami untuk mewujudkan pelayanan publik yang prima dan bebas dari korupsi.</p>
                <p style="font-size: 14px; font-weight: bold; color: #1e293b; margin-top: 20px;">Salam hormat,<br>Manajemen Lapas Kelas IIB Jombang</p>
            </div>

            {{-- FOOTER --}}
            <div class="footer">
                <p style="margin: 0; font-weight: bold; color: #475569;">Lembaga Pemasyarakatan Kelas IIB Jombang</p>
                <p style="margin: 5px 0 0 0;">Jl. Wahid Hasyim No. 123, Jombang, Jawa Timur</p>
                <p style="margin: 20px 0 0 0; opacity: 0.7;">&copy; {{ date('Y') }} Sistem Informasi Layanan Kunjungan. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>