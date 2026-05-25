<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Str;

$mdPath = 'C:\Users\Peter\.gemini\antigravity-ide\brain\2c1e361a-e801-47f4-8d7d-2cdd91f56b14\laporan_pemagangan.md';
if (!file_exists($mdPath)) {
    die("Error: Berkas laporan_pemagangan.md tidak ditemukan di: {$mdPath}\n");
}

$markdown = file_get_contents($mdPath);

// Hapus bagian-bagian non-markdown di awal jika ada
$markdown = preg_replace('/^Created At:.*?\n/is', '', $markdown);
$markdown = preg_replace('/^Completed At:.*?\n/is', '', $markdown);
$markdown = preg_replace('/^File Path:.*?\n/is', '', $markdown);

// Membagi markdown berdasarkan header Bab utama (h2 markdown: ##)
$sections = preg_split('/^(##\s+.*)$/m', $markdown, -1, PREG_SPLIT_DELIM_CAPTURE);

$htmlContent = '';

// Kustomisasi render Cover Page agar terlihat profesional dan rapi
$isCover = true;

for ($i = 1; $i < count($sections); $i += 2) {
    $header = trim($sections[$i]);
    $body = isset($sections[$i + 1]) ? $sections[$i + 1] : '';
    
    $fullSection = $header . "\n" . $body;
    $sectionHtml = Str::markdown($fullSection);
    
    if (strpos($header, 'HALAMAN COVER') !== false) {
        // Render kustom Cover Page
        $htmlContent .= '<div class="cover-page">';
        $htmlContent .= '<div class="cover-top">';
        $htmlContent .= '<h1 class="cover-title">RANCANG BANGUN SISTEM LAYANAN KUNJUNGAN TERINTEGRASI (Si-LAKU) BERBASIS WEB</h1>';
        $htmlContent .= '<h3 class="cover-subtitle">PADA LEMBAGA PEMASYARAKATAN KELAS IIB JOMBANG</h3>';
        $htmlContent .= '<p class="cover-ministry">KEMENTERIAN IMIGRASI DAN PEMASYARAKATAN REPUBLIK INDONESIA</p>';
        $htmlContent .= '</div>';
        
        $htmlContent .= '<div class="cover-middle">';
        $htmlContent .= '<p class="cover-label">LAPORAN KEGIATAN PEMAGANGAN INDIVIDUAL</p>';
        $htmlContent .= '<div class="cover-decoration"></div>';
        $htmlContent .= '</div>';
        
        $htmlContent .= '<div class="cover-bottom">';
        $htmlContent .= '<table class="cover-meta">';
        $htmlContent .= '<tr><td><strong>Nama Peserta</strong></td><td>: Arya Dian Saputra</td></tr>';
        $htmlContent .= '<tr><td><strong>Nomor Induk Mahasiswa</strong></td><td>: [Masukkan NIM Anda di Sini]</td></tr>';
        $htmlContent .= '<tr><td><strong>Program Studi</strong></td><td>: [Masukkan Program Studi Anda]</td></tr>';
        $htmlContent .= '<tr><td><strong>Satuan Kerja Mitra</strong></td><td>: Lembaga Pemasyarakatan Kelas IIB Jombang</td></tr>';
        $htmlContent .= '<tr><td><strong>Periode Pemagangan</strong></td><td>: Februari 2026 – Mei 2026</td></tr>';
        $htmlContent .= '<tr><td><strong>Tahun Akademik</strong></td><td>: 2026</td></tr>';
        $htmlContent .= '</table>';
        $htmlContent .= '</div>';
        $htmlContent .= '</div>';
    } else {
        // Bersihkan emoji dari header untuk formalitas akademis
        $cleanHeader = preg_replace('/[\x{1F300}-\x{1F9FF}]|[\x{1F600}-\x{1F64F}]|[\x{1F680}-\x{1F6FF}]|[\x{2600}-\x{26FF}]|[\x{2700}-\x{27BF}]/u', '', $header);
        $cleanHeader = trim(str_replace('##', '', $cleanHeader));
        
        // Membungkus section dalam div pembagi halaman
        $htmlContent .= '<div class="page-break-before">';
        
        // Konversi markdown ke html untuk isi body saja
        $bodyHtml = Str::markdown($body);
        
        // Ganti header dengan format h1 atau h2 yang rapi
        if (preg_match('/^(BAB\s+[IVXLCDM]+|LAMPIRAN)/i', $cleanHeader)) {
            $htmlContent .= '<h1 class="chapter-title">' . $cleanHeader . '</h1>';
        } else {
            $htmlContent .= '<h2 class="section-title">' . $cleanHeader . '</h2>';
        }
        
        $htmlContent .= $bodyHtml;
        $htmlContent .= '</div>';
    }
}

// Kerangka Dokumen HTML Lengkap dengan Style CSS Cetak (A4)
$fullHtml = <<<HTML
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pemagangan Individual - Si-LAKU</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Times+New+Roman&family=Inter:wght@400;500;600;700&display=swap');
        
        @page {
            size: A4;
            margin: 3cm 3cm 3cm 4cm; /* Margin standar akademis (Kiri 4cm, Atas/Bawah/Kanan 3cm) */
        }
        
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000000;
            margin: 0;
            padding: 0;
        }
        
        /* Pengaturan Cover Page */
        .cover-page {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-align: center;
            padding: 2cm 0;
            box-sizing: border-box;
            page-break-after: always;
            break-after: page;
        }
        
        .cover-top {
            margin-bottom: 2cm;
        }
        
        .cover-title {
            font-family: 'Inter', sans-serif;
            font-size: 16pt;
            font-weight: 700;
            line-height: 1.4;
            margin: 0 0 10px 0;
            text-transform: uppercase;
        }
        
        .cover-subtitle {
            font-family: 'Inter', sans-serif;
            font-size: 14pt;
            font-weight: 600;
            margin: 0 0 15px 0;
            text-transform: uppercase;
        }
        
        .cover-ministry {
            font-family: 'Inter', sans-serif;
            font-size: 12pt;
            font-weight: 500;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .cover-middle {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: 3cm 0;
        }
        
        .cover-label {
            font-family: 'Inter', sans-serif;
            font-size: 12pt;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 20px;
        }
        
        .cover-decoration {
            width: 80px;
            height: 3px;
            background-color: #000000;
        }
        
        .cover-bottom {
            margin-top: auto;
            display: flex;
            justify-content: center;
        }
        
        .cover-meta {
            width: 85%;
            margin: 0 auto;
            border-collapse: collapse;
            font-family: 'Inter', sans-serif;
            font-size: 11pt;
            text-align: left;
        }
        
        .cover-meta td {
            border: none !important;
            background: transparent !important;
            padding: 6px 4px !important;
            vertical-align: top;
        }
        
        .cover-meta td:first-child {
            width: 40%;
        }
        
        /* Pengaturan Judul Bab & Sub-Bab */
        .chapter-title {
            font-family: 'Inter', sans-serif;
            font-size: 14pt;
            font-weight: 700;
            text-align: center;
            text-transform: uppercase;
            margin-top: 0;
            margin-bottom: 2cm;
            page-break-after: avoid;
            break-after: avoid;
        }
        
        .section-title {
            font-family: 'Inter', sans-serif;
            font-size: 12pt;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 1.5cm;
            margin-bottom: 0.5cm;
            page-break-after: avoid;
            break-after: avoid;
        }
        
        h3 {
            font-family: 'Inter', sans-serif;
            font-size: 12pt;
            font-weight: 700;
            margin-top: 0.8cm;
            margin-bottom: 0.4cm;
            page-break-after: avoid;
            break-after: avoid;
        }

        h4 {
            font-family: 'Inter', sans-serif;
            font-size: 11pt;
            font-weight: 700;
            margin-top: 0.6cm;
            margin-bottom: 0.3cm;
            page-break-after: avoid;
            break-after: avoid;
        }
        
        p {
            margin-top: 0;
            margin-bottom: 0.5cm;
            text-align: justify;
            text-indent: 1.25cm; /* Alenia masuk standar Indonesia */
        }
        
        ul, ol {
            margin-top: 0;
            margin-bottom: 0.5cm;
            padding-left: 2cm;
            text-align: justify;
        }
        
        li {
            margin-bottom: 0.2cm;
        }
        
        /* Pengaturan Tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0.5cm;
            margin-bottom: 0.8cm;
            font-size: 11pt;
            page-break-inside: avoid;
        }
        
        th, td {
            border: 1px solid #000000;
            padding: 8px 10px;
            text-align: left;
            vertical-align: top;
        }
        
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }
        
        /* Pengaturan Code block & syntax */
        code {
            font-family: 'Consolas', 'Courier New', monospace;
            font-size: 10pt;
            background-color: #f5f5f5;
            padding: 2px 4px;
            border-radius: 3px;
        }
        
        pre {
            background-color: #fafafa;
            border: 1px solid #cccccc;
            border-radius: 4px;
            padding: 12px;
            overflow-x: auto;
            margin-bottom: 0.6cm;
            page-break-inside: avoid;
        }
        
        pre code {
            background-color: transparent;
            padding: 0;
            font-size: 9.5pt;
            display: block;
            line-height: 1.35;
        }
        
        /* Page break controls */
        .page-break-before {
            page-break-before: always;
            break-before: page;
            padding-top: 1cm;
        }
        
        .page-break-after {
            page-break-after: always;
            break-after: page;
        }
        
        /* Hapus indentasi paragraf khusus setelah header atau di daftar isi */
        .cover-page p, .cover-page td, table td, table th, pre p {
            text-indent: 0 !important;
        }
        
        /* Menghapus bullet default pada daftar isi agar terlihat rapi */
        .daftar-isi-list {
            list-style-type: none;
            padding-left: 0;
        }
    </style>
</head>
<body>
    {$htmlContent}
</body>
</html>
HTML;

// Simpan file HTML sementara
$htmlPath = __DIR__ . '/laporan_pemagangan.html';
file_put_contents($htmlPath, $fullHtml);
echo "HTML berhasil digenerate di: {$htmlPath}\n";

// Path menuju file PDF keluaran
$pdfPath = __DIR__ . '/laporan_pemagangan.pdf';

// Panggil Google Chrome Headless untuk mencetak HTML ke PDF
$chromePath = 'C:\Program Files\Google\Chrome\Application\chrome.exe';
$command = sprintf(
    '"%s" --headless --disable-gpu --no-sandbox --print-to-pdf="%s" "%s"',
    $chromePath,
    $pdfPath,
    $htmlPath
);

echo "Menjalankan konversi PDF via Google Chrome Headless...\n";
exec($command, $output, $returnVar);

if ($returnVar === 0 && file_exists($pdfPath)) {
    echo "SUKSES: PDF berhasil dibuat di: {$pdfPath} (" . number_format(filesize($pdfPath) / 1024, 2) . " KB)\n";
    // Hapus berkas HTML sementara
    @unlink($htmlPath);
} else {
    echo "GAGAL: Terjadi kesalahan saat memanggil Chrome. Kode error: {$returnVar}\n";
    echo "Detail Command: {$command}\n";
    echo "Output:\n" . implode("\n", $output) . "\n";
}
