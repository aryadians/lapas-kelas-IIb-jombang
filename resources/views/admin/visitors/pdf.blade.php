<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Database Pengunjung – Lapas Kelas IIB Jombang</title>
</head>
<body>

@php
    $title    = 'Laporan Database Profil Pengunjung';
    $subtitle = 'Data seluruh pengunjung terdaftar dalam sistem';
@endphp
@include('partials.kop_surat_pdf')

<table>
    <thead>
        <tr>
            <th style="width:30px">No</th>
            <th style="width:110px">NIK</th>
            <th>Nama Lengkap</th>
            <th style="width:30px">L/P</th>
            <th style="width:90px">No. WA / HP</th>
            <th>Alamat</th>
            <th>WBP yang Dikunjungi</th>
            <th style="width:55px">Tgl Daftar</th>
        </tr>
    </thead>
    <tbody>
        @forelse($visitors as $visitor)
        @php
            $latestKunjungan = $visitor->kunjungans->first();
            $wbpName = $latestKunjungan && $latestKunjungan->wbp ? strtoupper($latestKunjungan->wbp->nama) : '—';
            $gender  = $visitor->jenis_kelamin == 'Laki-laki' ? 'L' : 'P';
        @endphp
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td style="font-family:monospace; font-size:9.5px;">{{ $visitor->nik }}</td>
            <td class="fw-bold">{{ strtoupper($visitor->nama) }}</td>
            <td class="text-center">
                <span style="background:{{ $gender=='L'?'#dbeafe':'#fce7f3' }};color:{{ $gender=='L'?'#1d4ed8':'#be185d' }};padding:2px 6px;border-radius:20px;font-size:9px;font-weight:bold;">
                    {{ $gender }}
                </span>
            </td>
            <td>{{ $visitor->nomor_hp ?? '—' }}</td>
            <td style="font-size:9.5px;">{{ $visitor->alamat }}</td>
            <td>{{ $wbpName }}</td>
            <td class="text-center">{{ $visitor->created_at->format('d/m/Y') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="8" class="text-center" style="padding:20px;color:#94a3b8;font-style:italic;">Tidak ada data pengunjung.</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{-- Ringkasan --}}
<div style="margin-top:14px; padding:8px 12px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:6px; font-size:10px; color:#475569;">
    <strong>Ringkasan:</strong> Total pengunjung terdaftar: <strong>{{ $visitors->count() }}</strong> orang &nbsp;|&nbsp;
    Laki-laki: <strong>{{ $visitors->where('jenis_kelamin','Laki-laki')->count() }}</strong> &nbsp;|&nbsp;
    Perempuan: <strong>{{ $visitors->where('jenis_kelamin','Perempuan')->count() }}</strong>
</div>

{{-- Footer TTD --}}
<div class="doc-footer">
    <div class="footer-ttd">
        <div class="ttd-block">
            <p class="ttd-kota">Jombang, {{ now()->translatedFormat('d F Y') }}</p>
            <p>Kepala Lapas Kelas IIB Jombang</p>
            <div class="ttd-space"></div>
            <p class="ttd-nama">_____________________________</p>
            <p class="ttd-nip">NIP. ___________________________</p>
        </div>
    </div>
    <div class="footer-system">
        <span>Dokumen ini dicetak secara otomatis oleh Sistem Informasi Layanan Kunjungan Lapas Jombang.</span>
        <span>{{ now()->format('d/m/Y H:i') }} WIB</span>
    </div>
</div>

</body>
</html>
