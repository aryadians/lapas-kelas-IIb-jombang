<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$dataKalapas = [
    'nama' => 'RINO SOLEH SUMITRO, A.Md.IP, S.H., M.H.',
    'jabatan' => 'Kepala Lapas Kelas IIB Jombang',
    'level' => 'kalapas',
    'quotes' => 'Melayani dengan Hati, Berintegritas, dan Profesional demi mewujudkan pemasyarakatan yang maju dan bermartabat.',
    'order_index' => 1
];
\App\Models\Pegawai::create($dataKalapas);

$dataEselon4 = [
    ['nama' => 'MOCH. ARIEF KAFANIE, A.Md.P., S.H', 'jabatan' => 'Ka. KPLP', 'seksi' => 'Kesatuan Pengamanan Lapas', 'level' => 'eselon_4', 'order_index' => 1],
    ['nama' => 'AFIF EKO SUHARIYANTO, S.H., M.H', 'jabatan' => 'Kasubag Tata Usaha', 'seksi' => 'Sub Bagian Tata Usaha', 'level' => 'eselon_4', 'order_index' => 2],
    ['nama' => 'RD EPA FATIMAH, A.Md.IP.,S.H', 'jabatan' => 'Kasi Binadik & Giatja', 'seksi' => 'Bimbingan & Kegiatan Kerja', 'level' => 'eselon_4', 'order_index' => 3],
    ['nama' => 'WAYAN RIASA, S.H', 'jabatan' => 'Kasi Adm. Kamtib', 'seksi' => 'Administrasi Keamanan & Tata Tertib', 'level' => 'eselon_4', 'order_index' => 4],
];
\App\Models\Pegawai::insert($dataEselon4);

$dataEselon5 = [
    ['nama' => 'DANANG PANDU WINOTO, S.Sos', 'jabatan' => 'Kaur Kepeg & Keu', 'level' => 'eselon_5', 'order_index' => 1],
    ['nama' => 'LATIFA ISNA DAMAYANTI, S.H', 'jabatan' => 'Kaur Umum', 'level' => 'eselon_5', 'order_index' => 2],
    ['nama' => 'GUSTIANSYAH SURYA W, P,S.Tr.Pas.', 'jabatan' => 'Kasubsi Registrasi', 'level' => 'eselon_5', 'order_index' => 3],
    ['nama' => 'MOCHAMAD MACHMUDA HARIS, S.H', 'jabatan' => 'Kasubsi Keperawatan', 'level' => 'eselon_5', 'order_index' => 4],
    ['nama' => 'BUDI MULYONO, S.H', 'jabatan' => 'Kasubsi Kegiatan Kerja', 'level' => 'eselon_5', 'order_index' => 5],
    ['nama' => 'EDY HARIADY, S.H', 'jabatan' => 'Kasubsi Keamanan', 'level' => 'eselon_5', 'order_index' => 6],
    ['nama' => 'SAMUD, S.H', 'jabatan' => 'Kasubsi Portatib', 'level' => 'eselon_5', 'order_index' => 7],
];
\App\Models\Pegawai::insert($dataEselon5);

echo "Data pegawai berhasil di-seed!\n";
