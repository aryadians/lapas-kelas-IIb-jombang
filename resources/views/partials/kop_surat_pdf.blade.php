{{--
    ╔══════════════════════════════════════════════════════════════╗
    ║  PARTIAL: Kop Surat Resmi – Lapas Kelas IIB Jombang         ║
    ║  Usage: @include('partials.kop_surat_pdf', ['title'=>'...'])  ║
    ╚══════════════════════════════════════════════════════════════╝
    Variables:
    - $title    : Judul dokumen (required)
    - $subtitle : Sub-judul atau periode (optional)
--}}
@php
    // Konversi logo ke Base64 agar pasti muncul di PDF
    $logoPath = public_path('img/logo.png');
    $logoBase64 = '';
    if (file_exists($logoPath)) {
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoBase64 = 'data:image/png;base64,' . $logoData;
    }
@endphp
<style>
    /* ── Reset & Base ── */
    * { box-sizing: border-box; }
    body {
        font-family: 'Arial', sans-serif;
        font-size: 11px;
        color: #1e293b;
        margin: 0;
        padding: 0;
        background: #fff;
    }

    /* ── Kop Surat ── */
    .kop-wrapper {
        width: 100%;
        border-bottom: 4px double #1e3a5f;
        padding-bottom: 12px;
        margin-bottom: 18px;
    }
    .kop-inner {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .kop-logo {
        width: 70px;
        height: 70px;
        flex-shrink: 0;
        object-fit: contain;
    }
    .kop-text {
        flex: 1;
        text-align: center;
    }
    .kop-kementerian {
        font-size: 11px;
        font-weight: normal;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #374151;
        margin: 0;
    }
    .kop-kanwil {
        font-size: 11px;
        font-weight: bold;
        text-transform: uppercase;
        color: #374151;
        margin: 2px 0;
    }
    .kop-instansi {
        font-size: 15px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #1e3a5f;
        margin: 3px 0;
    }
    .kop-alamat {
        font-size: 9.5px;
        color: #6b7280;
        margin: 3px 0 0;
    }
    .kop-logo-right {
        width: 70px;
        height: 70px;
        flex-shrink: 0;
        object-fit: contain;
    }

    /* ── Judul Laporan ── */
    .doc-title-block {
        text-align: center;
        margin: 14px 0 16px;
        padding: 10px 0;
        background: #1e3a5f;
        border-radius: 4px;
    }
    .doc-title {
        font-size: 13px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #fff;
        margin: 0;
    }
    .doc-subtitle {
        font-size: 10px;
        color: #93c5fd;
        margin: 3px 0 0;
        font-weight: normal;
    }

    /* ── Metadata strip ── */
    .meta-strip {
        display: flex;
        justify-content: space-between;
        font-size: 9.5px;
        color: #6b7280;
        margin-bottom: 12px;
        padding: 4px 2px;
        border-bottom: 1px solid #e2e8f0;
    }

    /* ── Table ── */
    table { width: 100%; border-collapse: collapse; margin-top: 6px; }
    thead tr th {
        background-color: #1e3a5f;
        color: #fff;
        font-size: 10px;
        font-weight: bold;
        text-transform: uppercase;
        text-align: center;
        padding: 8px 6px;
        border: 1px solid #1e3a5f;
        letter-spacing: 0.3px;
    }
    tbody tr td {
        padding: 6px;
        border: 1px solid #cbd5e1;
        font-size: 10.5px;
        vertical-align: middle;
    }
    tbody tr:nth-child(even) { background-color: #f8fafc; }
    tbody tr:hover { background-color: #eff6ff; }

    /* ── Footer ── */
    .doc-footer {
        margin-top: 28px;
    }
    .footer-ttd {
        display: flex;
        justify-content: flex-end;
    }
    .ttd-block {
        text-align: center;
        min-width: 200px;
    }
    .ttd-block p { margin: 0; font-size: 10.5px; }
    .ttd-block .ttd-kota { margin-bottom: 4px; }
    .ttd-block .ttd-jabatan { font-weight: bold; }
    .ttd-block .ttd-space { height: 48px; }
    .ttd-block .ttd-nama { font-weight: bold; text-decoration: underline; }
    .ttd-block .ttd-nip { font-size: 9.5px; color: #6b7280; margin-top: 2px; }

    .footer-system {
        margin-top: 16px;
        padding-top: 8px;
        border-top: 1px solid #e2e8f0;
        font-size: 9px;
        color: #94a3b8;
        display: flex;
        justify-content: space-between;
    }

    /* ── Print bar ── */
    .print-bar {
        background: linear-gradient(135deg, #1e3a5f, #1e4d8c);
        padding: 12px 20px;
        margin-bottom: 20px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }
    .print-bar p { margin: 0; color: #bfdbfe; font-size: 10.5px; }
    .btn-print {
        background: #fff;
        color: #1e3a5f;
        border: none;
        padding: 8px 20px;
        border-radius: 6px;
        font-weight: bold;
        font-size: 11px;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }
    .btn-print:hover { background: #dbeafe; }

    @media print {
        .no-print { display: none !important; }
        body { padding: 20px; }
        @page { margin: 15mm 15mm 20mm; }
    }

    /* Utility */
    .text-center { text-align: center; }
    .text-right  { text-align: right; }
    .fw-bold     { font-weight: bold; }
</style>

{{-- ── Print bar (tidak tercetak) ── --}}
<div class="no-print print-bar">
    <p>📄 Dokumen ini siap dicetak atau disimpan sebagai PDF. Gunakan "Save as PDF" saat dialog print muncul.</p>
    <button class="btn-print" onclick="window.print()">🖨 Cetak / Simpan PDF</button>
</div>

{{-- ── KOP SURAT ── --}}
<div class="kop-wrapper">
    <div class="kop-inner">
        {{-- Logo kiri (Kemenimipas) --}}
        <img class="kop-logo"
            src="{{ $logoBase64 }}"
            alt="Logo"
            onerror="this.style.display='none'">

        <div class="kop-text">
            <p class="kop-kementerian">Kementerian Imigrasi dan Pemasyarakatan Republik Indonesia</p>
            <p class="kop-kanwil">Kantor Wilayah Direktorat Jenderal Pemasyarakatan Jawa Timur</p>
            <p class="kop-instansi">Lembaga Pemasyarakatan Kelas IIB Jombang</p>
            <p class="kop-alamat">
                Jl. KH. Wahid Hasyim No. 155, Jombang, Jawa Timur 61419 &nbsp;|&nbsp;
                Telp. (0321) 861205 &nbsp;|&nbsp; Email: lapasjombang@gmail.com
            </p>
        </div>

        {{-- Logo kanan (Garuda / bisa diganti) --}}
        <img class="kop-logo-right"
            src="{{ $logoBase64 }}"
            alt="Logo"
            onerror="this.style.display='none'">
    </div>
</div>

{{-- ── JUDUL DOKUMEN ── --}}
<div class="doc-title-block">
    <p class="doc-title">{{ $title ?? 'Laporan' }}</p>
    @if(!empty($subtitle))
    <p class="doc-subtitle">{{ $subtitle }}</p>
    @endif
</div>

{{-- ── META STRIP ── --}}
<div class="meta-strip">
    <span>📅 Dicetak pada: <strong>{{ now()->translatedFormat('l, d F Y') }}</strong> pukul <strong>{{ now()->format('H:i') }} WIB</strong></span>
    <span>🖥 Sistem Informasi Layanan Kunjungan Lapas Jombang</span>
</div>
