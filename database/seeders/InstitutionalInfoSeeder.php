<?php

namespace Database\Seeders;

use App\Models\InstitutionalInfo;
use Illuminate\Database\Seeder;

class InstitutionalInfoSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'key' => 'visi',
                'title' => 'Visi',
                'content' => 'Terwujudnya Pemasyarakatan yang Profesional dalam Mendukung Penegakan Hukum Berbasis Hak Asasi Manusia yang Berkeadilan untuk Mewujudkan Indonesia Maju yang Berdaulat, Mandiri dan Berkepribadian, berlandaskan Gotong Royong',
                'type' => 'text'
            ],
            [
                'key' => 'misi',
                'title' => 'Misi',
                'content' => "<ul><li>Mendukung Penegakan Hukum di Bidang Penyelenggaraan Pemasyarakatan yang Bebas dari Korupsi, Bermartabat dan Terpercaya</li><li>Ikut Serta dalam Menjaga Stabilitas Kemanan Melalui Peran Pemasyarakatan</li><li>Mewujudkan Penyelenggaraan Pemasyarakatan yang Profesional dalam Mendukung Penegakan Hukum Berbasis Hak Asasi Manusia yang Berkeadilan</li><li>Melaksanakan Tata Laksana Pemerintahan yang Baik Melalui Reformasi Birokrasi</li></ul>",
                'type' => 'html'
            ],
            [
                'key' => 'tujuan',
                'title' => 'Tujuan',
                'content' => "<ul><li>Mendukung Penegakan Hukum di Bidang Pemasyarakatan yang Bebas dari Korupsi, Bermartabat dan Terpercaya, yaitu Membentuk Warga Binaan Pemasyarakatan agar Menjadi Manusia Seutuhnya, Menyadari Kesalahan, Memperbaiki Diri, Tidak Mengulangi Tindak Pidana Sehingga dapat diterima kembali oleh lingkungan masyarakat serta Memberikan Jaminan Perlindungan Hak Asasi Tahanan yang Ditahan serta Keselamatan dan Keamanan Benda-Benda yang Disita untuk Keperluan Barang Bukti dan Benda-benda yang dinyatakan dirampas untuk negara berdasarkan putusan pengadilan</li><li>Ikut Serta dalam Menjaga Stabilitas Kemanan Melalui Peran Pemasyarakatan, yaitu Menciptakan Kondisi UPT Pemasyarakatan yang Aman dan Tertib</li><li>Mewujudkan Penyelenggaraan Pemasyarakatan yang Profesional dalam Mendukung Penegakan Hukum Berbasis Hak Asasi Manusia yaitu (1) Terjaganya Derajat Kesehatan Tahanan dan Narapidana, (2) Optimalnya Peran Masyarakat dalam Penyelenggaraan Pemasyarakatan, dan (3) Mengembangkan Penyelenggaraan Pemasyarakatan Berbasis Teknologi Informasi</li><li>Melaksanakan Tata Laksana Pemerintahan yang Baik Melalui Reformasi Birokrasi yaitu Meningkatnya Kinerja Reformasi Birokrasi Direktorat Jenderal Pemasyarakatan.</li></ul>",
                'type' => 'html'
            ],
            [
                'key' => 'sasaran_program',
                'title' => 'Sasaran Program',
                'content' => "<h3>1. Stakeholders Perspective (Perspektif Pemangku Kepentingan)</h3><ul><li>Terwujudnya Penyelenggaraan Pemasyarakatan yang Mampu Menjadi Pendorong Inovasi dan Kreativitas dalam Pertumbuhan Ekonomi Nasional</li><li>Terwujudnya Penyelenggaraan Pemasyarakatan yang Profesional dalam Mendukung Penegakan Hukum Berbasis HAM terhadap Tahanan, Benda Sitaan dan Barang Rampassan Negara, Narapidana, Anak dan Klien Pemasyarakatan</li></ul><h3>2. Customer Perspective (Perspektif Penerima Layanan)</h3><ul><li>Terwujudnya Penyelenggaraan Pemasyarakatan yang Berkualitas</li><li>Terwujudnya Penyelenggaraan Pemasyarakatan yang Aman dan Tertib</li></ul><h3>3. Internal Process Perspective (Perspektif Proses Bisnis Internal)</h3><ul><li>Tersedianya Kebijakan Pembangunan Pemasyarakatan Yang Efektif</li><li>Meningkatnya Kualitas Penyelenggaraan Pemasyarakatan dalam Mendukung Penegakan Hukum Berbasis HAM</li><li>Terselenggaranya Pengendalian dan Pengawasan Penyelenggaraan Pemasyarakatan yang Partisipatif</li></ul><h3>4. Learning & Growth Perspective (Perspektif Pembelajaran dan Tumbuh)</h3><ul><li>Terwujudnya SDM Pemasyarakatan yang Kompeten, Profesional dan Berintegritas</li><li>Tersedianya Sistem Informasi dan Layanan Berbasis IT yang Handal dan Terintegrasi</li><li>Meningkatnya Peran Masyarakat dalam Penyelenggaraan Pemasyarakatan</li><li>Terwujudnya Birokrasi Pemasyarakatan yang Efektif dan Berorientasi pada Layanan Prima</li><li>Terkelolanya Keuangan Secara Efisiensi dan Akuntabel Melalui Shareholder Value</li></ul>",
                'type' => 'html'
            ],
            [
                'key' => 'tugas_fungsi',
                'title' => 'Tugas & Fungsi',
                'content' => 'Lapas Kelas IIB Jombang mempunyai tugas melaksanakan pemasyarakatan narapidana / anak didik.',
                'type' => 'text'
            ],
            [
                'key' => 'hak_kewajiban',
                'title' => 'Hak & Kewajiban WBP',
                'content' => "<p>Berdasarkan Undang-Undang Pemasyarakatan Nomor 22 Tahun 2022, berikut adalah ringkasan hak dan kewajiban Klien Pemasyarakatan:</p><h4><strong>Hak Klien Pemasyarakatan</strong></h4><ul><li>Mendapatkan pendampingan pada tahap pra-adjudikasi, adjudikasi, pasca-adjudikasi, serta bimbingan lanjutan.</li><li>Mendapatkan program pembimbingan kepribadian dan kemandirian sesuai dengan karakteristik berdasarkan Penelitian Kemasyarakatan.</li><li>Mendapatkan izin bepergian ke luar negeri untuk alasan penting (pengobatan, pendidikan, ibadah) bagi Klien Pembebasan Bersyarat (PB) dengan izin Menteri Hukum dan HAM.</li><li>Mendapatkan informasi penting mengenai peraturan pembimbingan kemasyarakatan.</li><li>Menyampaikan pengaduan atau keluhan kepada Pembimbing Kemasyarakatan (PK) untuk dibantu mendapatkan solusi (misal: terkait pencarian pekerjaan).</li></ul><h4><strong>Kewajiban Klien Pemasyarakatan</strong></h4><ul><li>Mematuhi seluruh persyaratan dan kesepakatan pembimbingan, termasuk rutin melakukan wajib lapor ke Balai Pemasyarakatan (Bapas).</li><li>Mengikuti secara tertib seluruh program pembimbingan kemasyarakatan. (Sanksi pencabutan PB dapat diberikan jika mangkir wajib lapor 3 kali berturut-turut).</li><li>Memelihara perikehidupan yang bersih, tertib, aman, dan damai selama menjalani program integrasi di masyarakat.</li><li>Tidak melakukan pelanggaran hukum atau perbuatan yang menimbulkan keresahan di tengah masyarakat.</li><li>Menghormati hak asasi setiap orang di lingkungannya dan menjunjung tinggi sikap toleransi.</li></ul>",
                'type' => 'html'
            ],
        ];

        foreach ($data as $item) {
            InstitutionalInfo::updateOrCreate(['key' => $item['key']], $item);
        }
    }
}
