<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Pengunjung - Lapas Jombang</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 5px 0 0; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; text-transform: uppercase; font-size: 10px; }
        .footer { margin-top: 30px; text-align: right; font-size: 10px; color: #777; }
        @media print {
            .no-print { display: none; }
            body { padding: 20px; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="background: #fff3cd; padding: 10px; margin-bottom: 20px; border: 1px solid #ffeeba; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
            KLIK UNTUK CETAK PDF / PRINT
        </button>
        <p style="margin-top: 10px; font-size: 11px;">Gunakan fitur "Save as PDF" pada dialog print browser Anda.</p>
    </div>

    <div class="header">
        <h1>Lembaga Pemasyarakatan Kelas IIB Jombang</h1>
        <h1>Database Profil Pengunjung</h1>
        <p>Dicetak pada: {{ now()->translatedFormat('d F Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>L/P</th>
                <th>No. WhatsApp</th>
                <th>Alamat</th>
                <th>WBP yang Dikunjungi</th>
                <th>Tgl Terdaftar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($visitors as $visitor)
            @php
                $latestKunjungan = $visitor->kunjungans->first();
                $wbpName = $latestKunjungan && $latestKunjungan->wbp ? $latestKunjungan->wbp->nama : '-';
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $visitor->nik }}</td>
                <td>{{ $visitor->nama }}</td>
                <td>{{ $visitor->jenis_kelamin == 'Laki-laki' ? 'L' : 'P' }}</td>
                <td>{{ $visitor->nomor_hp }}</td>
                <td>{{ $visitor->alamat }}</td>
                <td>{{ $wbpName }}</td>
                <td>{{ $visitor->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Sistem Informasi Layanan Kunjungan Lapas Jombang &copy; {{ date('Y') }}
    </div>

    <script>
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
