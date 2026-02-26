<!DOCTYPE html>
<html>
@php
    use App\Enums\KunjunganStatus;
@endphp
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
        .btn { display: inline-block; padding: 12px 24px; border-radius: 6px; font-weight: bold; text-decoration: none; color: white !important; margin: 20px 0; }
        .btn-success { background-color: #10b981; }
        .btn-error { background-color: #ef4444; }
        .btn-warning { background-color: #f59e0b; }
        .info-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 14px; }
        .info-table td { padding: 8px 0; border-bottom: 1px solid #f1f5f9; }
        .info-table td:first-child { font-weight: bold; color: #64748b; width: 40%; }
        .info-table td:last-child { font-weight: bold; color: #1e293b; }
        .badge { padding: 8px 16px; border-radius: 50px; font-weight: bold; font-size: 14px; display: inline-block; }
        .badge-success { background-color: #dcfce7; color: #166534; border: 1px solid #16a34a; }
        .badge-danger { background-color: #fee2e2; color: #991b1b; border: 1px solid #dc2626; }
        .badge-pending { background-color: #fef3c7; color: #92400e; border: 1px solid #f59e0b; }
        .logo-img { height: 60px; width: auto; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-content">
            
            {{-- HEADER --}}
            <div class="header">
                {{-- Menggunakan embed untuk logo agar tidak di-block email client --}}
                <img src="{{ $message->embed(public_path('img/logo.png')) }}" alt="Logo Lapas" class="logo-img">
                <h1>Lapas Kelas IIB Jombang</h1>
                <div style="color: #cbd5e1; font-size: 12px; margin-top: 5px;">Kementerian Imigrasi dan Pemasyarakatan Kelas IIb Jombang</div>
            </div>

            <div class="body">
                @if ($kunjungan->status === KunjunganStatus::APPROVED)
                    {{-- STATUS: APPROVED --}}
                    <div style="text-align: center; margin-bottom: 25px;">
                        <span class="badge badge-success">✅ PENDAFTARAN DISETUJUI</span>
                    </div>

                    <h2>Halo, {{ $kunjungan->nama_pengunjung }}</h2>
                    <p>Selamat! Pendaftaran kunjungan tatap muka Anda telah kami terima dan disetujui. Berikut adalah detail tiket kunjungan Anda:</p>

                @elseif ($kunjungan->status === KunjunganStatus::PENDING)
                    {{-- STATUS: PENDING --}}
                    <div style="text-align: center; margin-bottom: 25px;">
                        <span class="badge" style="background-color: #dbeafe; color: #1e40af; border: 1px solid #3b82f6;">✅ PENDAFTARAN BERHASIL</span>
                    </div>

                    <h2>Halo, {{ $kunjungan->nama_pengunjung }}</h2>
                    <p>Selamat! Pendaftaran kunjungan tatap muka Anda telah kami terima. Berikut adalah detail pendaftaran Anda:</p>

                    <div style="margin-top: 30px; margin-bottom: 20px; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px;">
                        <h3 style="margin: 0; font-size: 16px; color: #1e293b;">Data Pengunjung</h3>
                    </div>
                    <table class="info-table">
                        <tr>
                            <td>Nama Lengkap</td>
                            <td>{{ $kunjungan->nama_pengunjung }}</td>
                        </tr>
                        <tr>
                            <td>NIK</td>
                            <td>{{ $kunjungan->nik_ktp }}</td>
                        </tr>
                        <tr>
                            <td>Nomor HP</td>
                            <td>{{ $kunjungan->no_wa_pengunjung }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{{ $kunjungan->email_pengunjung }}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>{{ $kunjungan->alamat_pengunjung }}</td>
                        </tr>
                    </table>
                    <div style="margin-top: 30px; margin-bottom: 20px; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px;">
                        <h3 style="margin: 0; font-size: 16px; color: #1e293b;">Detail Kunjungan</h3>
                    </div>

                @else
                    {{-- STATUS: REJECTED --}}
                    <div style="text-align: center; margin-bottom: 25px;">
                        <span class="badge badge-danger">❌ PENDAFTARAN DITOLAK</span>
                    </div>

                    <h2>Halo, {{ $kunjungan->nama_pengunjung }}</h2>
                    <p>Mohon maaf, pendaftaran kunjungan Anda untuk tanggal <strong>{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('d F Y') }}</strong> belum dapat kami setujui saat ini.</p>
                @endif

                @if ($kunjungan->status !== KunjunganStatus::REJECTED)
                    {{-- TABEL DETAIL (Untuk Approved & Pending) --}}
                    <table class="info-table">
                        <tr>
                            <td>No. Pendaftaran</td>
                            <td style="color: #2563eb;">#{{ $kunjungan->kode_kunjungan }}</td>
                        </tr>
                        <tr>
                            <td>No. Antrian Harian</td>
                            <td><strong>{{ $kunjungan->nomor_antrian_harian ?? '-' }}</strong></td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td>{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('l, d F Y') }}</td>
                        </tr>
                        <tr>
                            <td>Sesi</td>
                            <td>{{ ucfirst($kunjungan->sesi) }}</td>
                        </tr>
                        <tr>
                            <td>Warga Binaan</td>
                            <td>{{ $kunjungan->wbp->nama ?? 'Nama WBP' }}</td>
                        </tr>
                    </table>

                    {{-- QR CODE AREA --}}
                    {{-- Kita menggunakan CID Attachment, BUKAN generate on-the-fly --}}
                    <div style="text-align: center; margin: 25px 0; padding: 20px; background: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 8px;">
                        <p style="margin: 0 0 15px 0; color: #64748b; font-size: 13px;">
                            {{ $kunjungan->status === \App\Enums\KunjunganStatus::APPROVED ? 'Tunjukkan QR Code ini kepada petugas:' : 'QR Code (Menunggu Aktivasi):' }}
                        </p>
                        
                        @php
                            $id = $kunjungan->id;
                            $pngPath = storage_path("app/public/qrcodes/{$id}.png");
                            $svgPath = storage_path("app/public/qrcodes/{$id}.svg");
                            
                            $finalPath = null;
                            if (file_exists($pngPath)) {
                                $finalPath = $pngPath;
                            } elseif (file_exists($svgPath)) {
                                $finalPath = $svgPath;
                            }
                        @endphp

                        @if($finalPath)
                            @if(str_ends_with($finalPath, '.svg'))
                                {{-- SVG fallback: Use API to get PNG for email client compatibility --}}
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($kunjungan->qr_token) }}" 
                                     alt="QR Code" 
                                     style="width: 200px; height: 200px;">
                            @else
                                <img src="{{ $message->embed($finalPath) }}" 
                                     alt="QR Code" 
                                     style="width: 200px; height: 200px;">
                            @endif
                        @else
                            <div style="padding: 20px; border: 1px solid #ddd; background: #fff; display: inline-block;">
                                <p style="margin: 0; font-size: 12px; color: #666;">QR Code tersedia di halaman status:</p>
                                <strong style="font-size: 16px;">{{ $kunjungan->kode_kunjungan }}</strong>
                            </div>
                        @endif
                    </div>

                    <div style="background-color: #fffbeb; border-left: 4px solid #f59e0b; padding: 15px; font-size: 13px; color: #92400e; margin-top: 20px;">
                        <strong>⚠️ Tata Tertib:</strong>
                        <ul style="margin: 5px 0 0 0; padding-left: 20px;">
                            <li>Wajib membawa KTP/Identitas Asli.</li>
                            <li>Datang 15 menit sebelum jam sesi dimulai.</li>
                            <li>Dilarang membawa barang terlarang (HP, Sajam, Narkoba).</li>
                        </ul>
                    </div>

                    <div style="text-align: center;">
                        <a href="{{ route('kunjungan.status', $kunjungan->id) }}" class="btn btn-success">Cek Status di Website</a>
                    </div>

                @else
                    {{-- KONTEN KHUSUS REJECTED --}}
                    <div style="background-color: #fef2f2; border: 1px solid #f87171; border-radius: 8px; padding: 15px; margin: 20px 0;">
                        <h3 style="margin-top: 0; font-size: 14px; color: #b91c1c;">Kemungkinan Penyebab:</h3>
                        <ul style="color: #7f1d1d; font-size: 13px; margin-bottom: 0; padding-left: 20px;">
                            <li>Kuota kunjungan harian sudah penuh.</li>
                            <li>Data pengunjung tidak valid atau masuk daftar hitam.</li>
                            <li>Jadwal tidak sesuai ketentuan.</li>
                        </ul>
                    </div>

                    <p>Silakan coba mendaftar kembali di lain waktu atau hubungi kami untuk informasi lebih lanjut.</p>

                    <div style="text-align: center;">
                        <a href="{{ route('kunjungan.create') }}" class="btn btn-error">Daftar Ulang</a>
                    </div>
                @endif
            </div>

            {{-- FOOTER --}}
            <div class="footer">
                <p style="margin: 0; font-weight: bold;">Lembaga Pemasyarakatan Kelas IIB Jombang</p>
                <p style="margin: 5px 0 0 0;">Jl. Wahid Hasyim No. 123, Jombang, Jawa Timur</p>
                <p style="margin: 15px 0 0 0; opacity: 0.7;">&copy; {{ date('Y') }} Sistem Informasi Lapas Kelas IIB Jombang. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>