<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Kunjungan – Lapas Kelas IIB Jombang</title>
    @php $title = 'Laporan Data Kunjungan'; $subtitle = 'Periode: ' . $label; @endphp
    @include('partials.kop_surat_pdf')
</head>
<body>
    {{-- REKAP STATISTIK --}}
    @php
        use App\Enums\KunjunganStatus;
        $pending   = $kunjungans->where('status', KunjunganStatus::PENDING)->count();
        $approved  = $kunjungans->where('status', KunjunganStatus::APPROVED)->count();
        $completed = $kunjungans->where('status', KunjunganStatus::COMPLETED)->count();
        $rejected  = $kunjungans->where('status', KunjunganStatus::REJECTED)->count();
        $pagi      = $kunjungans->where('sesi', 'pagi')->count();
        $siang     = $kunjungans->where('sesi', 'siang')->count();
    @endphp
    <table class="summary-table">
        <tr>
            <td class="s-cell s-blue"><strong>Total</strong><br>{{ $kunjungans->count() }}</td>
            <td class="s-cell s-amber"><strong>Menunggu</strong><br>{{ $pending }}</td>
            <td class="s-cell s-green"><strong>Disetujui</strong><br>{{ $approved }}</td>
            <td class="s-cell s-slate"><strong>Selesai</strong><br>{{ $completed }}</td>
            <td class="s-cell s-red"><strong>Ditolak</strong><br>{{ $rejected }}</td>
            <td class="s-cell s-indigo"><strong>Pagi</strong><br>{{ $pagi }}</td>
            <td class="s-cell s-cyan"><strong>Siang</strong><br>{{ $siang }}</td>
        </tr>
    </table>

    {{-- TABEL DATA --}}
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Booking</th>
                <th>Tgl Kunjungan</th>
                <th>Sesi</th>
                <th>Antrian</th>
                <th>Nama Pengunjung</th>
                <th>NIK KTP</th>
                <th>Nama WBP</th>
                <th>No. Reg WBP</th>
                <th>Status</th>
                <th>Tipe</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kunjungans as $i => $k)
            @php
                $statusColors = [
                    'pending'     => ['MENUNGGU',   '#f59e0b', '#fef3c7'],
                    'approved'    => ['DISETUJUI',  '#16a34a', '#dcfce7'],
                    'rejected'    => ['DITOLAK',    '#dc2626', '#fee2e2'],
                    'completed'   => ['SELESAI',    '#475569', '#f1f5f9'],
                    'on_queue'    => ['ANTREAN',    '#2563eb', '#dbeafe'],
                    'called'      => ['DIPANGGIL',  '#7c3aed', '#ede9fe'],
                    'in_progress' => ['SEDANG LAYANI','#0891b2','#cffafe'],
                ];
                $st = $k->status instanceof \BackedEnum ? $k->status->value : (string) $k->status;
                $sc = $statusColors[$st] ?? [$st, '#64748b', '#f8fafc'];
            @endphp
            <tr class="{{ $i % 2 === 0 ? 'row-even' : 'row-odd' }}">
                <td class="center">{{ $i + 1 }}</td>
                <td class="mono">{{ $k->kode_booking ?? $k->kode_kunjungan ?? '-' }}</td>
                <td class="center">{{ \Carbon\Carbon::parse($k->tanggal_kunjungan)->format('d/m/Y') }}</td>
                <td class="center">{{ ucfirst($k->sesi ?? '-') }}</td>
                <td class="center bold">{{ $k->nomor_antrian_harian ?? '-' }}</td>
                <td>{{ $k->nama_pengunjung }}</td>
                <td class="mono">{{ $k->nik_ktp }}</td>
                <td>{{ $k->wbp?->nama ?? '-' }}</td>
                <td class="center mono">{{ $k->wbp?->no_registrasi ?? '-' }}</td>
                <td class="center">
                    <span class="badge" style="background:{{ $sc[2] }}; color:{{ $sc[1] }}; border:1px solid {{ $sc[1] }}">
                        {{ $sc[0] }}
                    </span>
                </td>
                <td class="center">
                    <span class="badge-type {{ $k->registration_type === 'offline' ? 'badge-offline' : 'badge-online' }}">
                        {{ strtoupper($k->registration_type ?? 'online') }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="11" class="center" style="padding: 24px; color: #94a3b8;">
                    Tidak ada data kunjungan untuk periode ini.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- FOOTER TTD --}}
    <div class="footer-ttd">
        <div class="ttd-col">
            <p>Mengetahui,</p>
            <p class="ttd-jabatan">Kepala Lapas Kelas IIB Jombang</p>
            <div class="ttd-space"></div>
            <div class="ttd-name">___________________________</div>
            <div class="ttd-nip">NIP. ________________________</div>
        </div>
        <div class="ttd-col">
            <p>Jombang, {{ now()->translatedFormat('d F Y') }}</p>
            <p class="ttd-jabatan">Kepala Sub-seksi Registrasi</p>
            <div class="ttd-space"></div>
            <div class="ttd-name">___________________________</div>
            <div class="ttd-nip">NIP. ________________________</div>
        </div>
    </div>

    <div class="sys-strip">
        Dokumen ini dicetak otomatis oleh Sistem Layanan Kunjungan Lapas Kelas IIB Jombang · {{ now()->format('d/m/Y H:i') }} WIB
    </div>

    {{-- PRINT BAR (tidak ikut cetak) --}}
    <div class="print-bar no-print">
        <span class="print-title">📄 Laporan Data Kunjungan — {{ $label }}</span>
        <div class="print-actions">
            <button onclick="window.print()" class="btn-print">🖨️ Cetak / Simpan PDF</button>
            <button onclick="window.close()" class="btn-close">✕ Tutup</button>
        </div>
    </div>

    <style>
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }
        .summary-table .s-cell {
            text-align: center;
            padding: 8px 6px;
            font-size: 11px;
            font-weight: 700;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }
        .s-blue   { background: #dbeafe; color: #1e40af; }
        .s-amber  { background: #fef3c7; color: #92400e; }
        .s-green  { background: #dcfce7; color: #166534; }
        .s-slate  { background: #f1f5f9; color: #334155; }
        .s-red    { background: #fee2e2; color: #991b1b; }
        .s-indigo { background: #ede9fe; color: #4c1d95; }
        .s-cyan   { background: #cffafe; color: #0e7490; }

        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 9.5px; }
        .data-table thead tr { background: #1e293b; color: white; }
        .data-table thead th { padding: 8px 6px; text-align: center; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 3px solid #3b82f6; white-space: nowrap; }
        .data-table tbody td { padding: 6px; border-bottom: 1px solid #e2e8f0; vertical-align: middle; }
        .row-even td { background: #f8fafc; }
        .row-odd  td { background: #ffffff; }
        .center { text-align: center; }
        .bold   { font-weight: 700; }
        .mono   { font-family: 'Courier New', monospace; font-size: 8.5px; }
        .badge  { display: inline-block; padding: 2px 7px; border-radius: 20px; font-size: 8px; font-weight: 800; letter-spacing: 0.05em; white-space: nowrap; }
        .badge-type { display: inline-block; padding: 2px 6px; border-radius: 4px; font-size: 8px; font-weight: 700; }
        .badge-online  { background: #dbeafe; color: #1e40af; }
        .badge-offline { background: #fef3c7; color: #92400e; }
    </style>
</body>
</html>
