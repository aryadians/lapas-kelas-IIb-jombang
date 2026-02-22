<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Informasi Publik – Lapas Kelas IIB Jombang</title>
</head>
<body>

@php $title = 'Rekapitulasi Laporan Informasi Publik'; $subtitle = 'Kategori: LHKPN · LAKIP · Laporan Keuangan'; @endphp
@include('partials.kop_surat_pdf')

<table>
    <thead>
        <tr>
            <th style="width:32px">No</th>
            <th>Judul Laporan</th>
            <th style="width:70px">Kategori</th>
            <th style="width:45px">Tahun</th>
            <th>Keterangan</th>
            <th style="width:55px">Status</th>
            <th style="width:65px">Tgl Unggah</th>
        </tr>
    </thead>
    <tbody>
        @forelse($reports as $report)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td>{{ $report->title }}</td>
            <td class="text-center">
                @php
                    $catColor = ['LHKPN'=>'#7c3aed','LAKIP'=>'#1d4ed8','Keuangan'=>'#047857'][$report->category] ?? '#475569';
                @endphp
                <span style="background:{{ $catColor }}1a; color:{{ $catColor }}; padding:2px 7px; border-radius:20px; font-weight:bold; font-size:9px; border:1px solid {{ $catColor }}44;">
                    {{ $report->category }}
                </span>
            </td>
            <td class="text-center fw-bold">{{ $report->year }}</td>
            <td>{{ $report->description ?? '—' }}</td>
            <td class="text-center">
                @if($report->is_published)
                <span style="background:#ecfdf5;color:#059669;padding:2px 7px;border-radius:20px;font-weight:bold;font-size:9px;border:1px solid #bbf7d0;">Publik</span>
                @else
                <span style="background:#f8fafc;color:#64748b;padding:2px 7px;border-radius:20px;font-weight:bold;font-size:9px;border:1px solid #cbd5e1;">Draft</span>
                @endif
            </td>
            <td class="text-center">{{ $report->created_at->format('d/m/Y') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center" style="padding:20px;color:#94a3b8;font-style:italic;">Tidak ada data laporan.</td>
        </tr>
        @endforelse
    </tbody>
</table>

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
