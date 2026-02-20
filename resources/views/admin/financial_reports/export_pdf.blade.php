<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Informasi Publik - Lapas Jombang</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; margin: 0; padding: 0; }
        .kop-surat { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .kop-surat h1 { margin: 0; font-size: 16px; text-transform: uppercase; }
        .kop-surat h2 { margin: 2px 0; font-size: 14px; text-transform: uppercase; }
        .kop-surat p { margin: 2px 0; font-size: 10px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; text-transform: uppercase; text-align: center; }
        
        .footer { margin-top: 30px; text-align: right; }
        .footer p { margin: 0; }
        
        @media print {
            .no-print { display: none; }
            body { padding: 30px; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="text-align: center; background: #fef3c7; padding: 15px; margin-bottom: 20px; border: 1px solid #f59e0b;">
        <button onclick="window.print()" style="padding: 10px 25px; background: #1e293b; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: bold;">
            <i class="fas fa-print"></i> CETAK / SIMPAN SEBAGAI PDF
        </button>
    </div>

    <div class="kop-surat">
        <h2>Kementerian Imigrasi dan Pemasyarakatan</h2>
        <h1>Lembaga Pemasyarakatan Kelas IIB Jombang</h1>
        <p>Jl. KH. Wahid Hasyim No.155, Jombang, Jawa Timur 61419</p>
        <p>Telepon: (0321) 861205 | Email: lapasjombang@gmail.com</p>
    </div>

    <h3 style="text-align: center; text-transform: uppercase; margin-bottom: 20px;">Rekapitulasi Laporan Informasi Publik</h3>

    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th>Judul Laporan</th>
                <th width="80">Kategori</th>
                <th width="50">Tahun</th>
                <th>Keterangan</th>
                <th width="80">Tgl Unggah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report)
            <tr>
                <td style="text-align: center;">{{ $loop->iteration }}</td>
                <td>{{ $report->title }}</td>
                <td style="text-align: center;">{{ $report->category }}</td>
                <td style="text-align: center;">{{ $report->year }}</td>
                <td>{{ $report->description ?? '-' }}</td>
                <td style="text-align: center;">{{ $report->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->translatedFormat('d F Y H:i') }}</p>
        <br><br><br>
        <p><b>Admin Sistem Lapas Jombang</b></p>
    </div>
</body>
</html>
