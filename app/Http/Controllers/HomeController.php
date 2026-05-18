<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\DomCrawler\Crawler;
// Sesuaikan dengan letak Model Anda jika berbeda
use App\Models\News; 
use App\Models\Announcement; 

use App\Models\Banner; 

class HomeController extends Controller
{
    /**
     * Display the landing page with scraping logic.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        // Mengambil 4 berita terbaru langsung dari Database tanpa Cache.
        // Base64 image payload terlalu besar untuk MySQL cache table limit (max_allowed_packet).
        $hasPublishedAt = \Illuminate\Support\Facades\Schema::hasColumn('news', 'published_at');
        $orderColumn = $hasPublishedAt ? 'published_at' : 'created_at';
        
        $columns = ['id', 'title', 'slug', 'content', 'created_at', 'status', 'image', 'videos'];
        if ($hasPublishedAt) {
            $columns[] = 'published_at';
        }

        $news = News::select($columns)
            ->where('status', 'published')
            ->orderBy($orderColumn, 'desc')
            ->take(4)
            ->get()
            ->map(function ($item) {
                // Ambil gambar pertama saja untuk preview homepage
                if (is_array($item->image) && count($item->image) > 0) {
                    $item->image = [$item->image[0]];
                } else {
                    $item->image = [];
                }
                
                // Ambil video pertama saja jika ada
                if (is_array($item->videos) && count($item->videos) > 0) {
                    $item->videos = [$item->videos[0]];
                } else {
                    $item->videos = [];
                }
                return $item;
            });

        $announcements = Cache::remember('homepage_announcements', 3600, function() {
            return Announcement::where('status', 'published')->orderBy('date', 'desc')->take(5)->get();
        });

        // Ambil Banner Aktif
        $banners = Cache::rememberForever('active_banners', function() {
            return Banner::where('is_active', true)->orderBy('order_index')->get();
        });

        // Caching data slide Kemenimipas selama 2 jam (7200 detik)
        $kemenimipasSlides = Cache::remember('kemenimipas_slides', 7200, function () {
            try {
                $response = Http::timeout(10)->get('https://kemenimipas.go.id');
                $crawler = new Crawler($response->body());
                $slides = [];

                // Targetkan tag <li> yang membungkus setiap slide
                $crawler->filter('li.tp-revslider-slidesli')->each(function (Crawler $node) use (&$slides) {
                    
                    // 1. Ambil URL tujuan dari atribut data-link
                    $link = $node->attr('data-link') ?? '#';

                    // 2. Cari tag <img> di dalam <li> tersebut
                    $imgNode = $node->filter('img')->first();
                    
                    if ($imgNode->count() > 0) {
                        $imgSrc = $imgNode->attr('data-lazyload') ?? $imgNode->attr('data-src') ?? $imgNode->attr('src');
                        
                        // Pastikan format URL absolute
                        if ($imgSrc && !str_starts_with($imgSrc, 'http')) {
                            $imgSrc = 'https://kemenimipas.go.id/' . ltrim($imgSrc, '/');
                        }

                        $slides[] = [
                            'image' => $imgSrc,
                            'link'  => $link,
                            'alt'   => $imgNode->attr('alt') ?? 'Headline Kemenimipas'
                        ];
                    }
                });

                return $slides;
            } catch (\Exception $e) {
                return []; 
            }
        });

        return view('welcome', compact('news', 'announcements', 'banners', 'kemenimipasSlides'));
    }

    /**
     * Display the contact page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function contact()
    {
        return redirect()->to(url('/') . '#kontak');
    }

    /**
     * Display the profile page.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        $kalapas = \App\Models\Pegawai::where('level', 'kalapas')->orderBy('order_index')->first();
        $eselon4 = \App\Models\Pegawai::where('level', 'eselon_4')->orderBy('order_index')->get();
        $eselon5 = \App\Models\Pegawai::where('level', 'eselon_5')->orderBy('order_index')->get();

        $institutional = [
            'visi' => 'Terwujudnya Pemasyarakatan yang Profesional dalam Mendukung Penegakan Hukum Berbasis Hak Asasi Manusia yang Berkeadilan untuk Mewujudkan Indonesia Maju yang Berdaulat, Mandiri dan Berkepribadian, berlandaskan Gotong Royong',
            'misi' => '<ul><li>Mendukung penegakan hukum di bidang penyelenggaraan pemasyarakatan yang bebas dari korupsi, bermartabat, dan terpercaya.</li><li>Ikut serta dalam menjaga stabilitas keamanan melalui peran pemasyarakatan.</li><li>Mewujudkan penyelenggaraan pemasyarakatan yang profesional dalam mendukung penegakan hukum berbasis Hak Asasi Manusia yang berkeadilan.</li><li>Melaksanakan tata laksana pemerintahan yang baik melalui reformasi birokrasi.</li></ul>',
            'tujuan' => '<ul><li><strong>Integritas Hukum:</strong> Membentuk Warga Binaan Pemasyarakatan menjadi manusia seutuhnya yang menyadari kesalahan, memperbaiki diri, dan tidak mengulangi tindak pidana. Memberikan jaminan pelindungan HAM tahanan, serta keamanan barang sitaan/rampasan negara.</li><li><strong>Stabilitas Keamanan:</strong> Menciptakan kondisi Unit Pelaksana Teknis (UPT) Pemasyarakatan yang aman dan tertib.</li><li><strong>Profesionalisme Berbasis HAM:</strong> Menjaga derajat kesehatan tahanan dan narapidana, mengoptimalkan peran masyarakat, serta mengembangkan pemasyarakatan berbasis Teknologi Informasi (TI).</li><li><strong>Reformasi Birokrasi:</strong> Meningkatkan kinerja tata kelola pemerintahan di lingkungan Direktorat Jenderal Pemasyarakatan.</li></ul>',
            'sasaran_program' => '<h3>Perspektif Pemangku Kepentingan (Stakeholders)</h3><ul><li>Terwujudnya penyelenggaraan yang mendorong inovasi dan kreativitas ekonomi nasional.</li><li>Profesionalisme dalam penegakan hukum berbasis HAM terhadap Tahanan, Benda Sitaan, Narapidana, Anak, dan Klien Pemasyarakatan.</li></ul><h3>Perspektif Penerima Layanan (Customer)</h3><ul><li>Penyelenggaraan Pemasyarakatan yang berkualitas.</li><li>Penyelenggaraan Pemasyarakatan yang aman dan tertib.</li></ul><h3>Perspektif Proses Bisnis Internal (Internal Process)</h3><ul><li>Tersedianya kebijakan pembangunan yang efektif.</li><li>Meningkatnya kualitas penyelenggaraan pendukung penegakan hukum berbasis HAM.</li><li>Terselenggaranya pengendalian dan pengawasan yang partisipatif.</li></ul><h3>Perspektif Pembelajaran & Tumbuh (Learning & Growth)</h3><ul><li>SDM Pemasyarakatan yang kompeten, profesional, dan berintegritas.</li><li>Sistem Informasi dan layanan berbasis IT yang andal dan terintegrasi.</li><li>Peningkatan peran masyarakat.</li><li>Birokrasi yang efektif dan berorientasi layanan prima.</li><li>Pengelolaan keuangan yang efisien dan akuntabel.</li></ul>',
            'tugas_fungsi' => '<p><strong>Tugas Pokok:</strong> Lembaga Pemasyarakatan mempunyai tugas melaksanakan pemasyarakatan narapidana atau anak didik.</p><p><strong>Fungsi Institusi:</strong></p><ul><li>Melakukan pembinaan narapidana / anak didik.</li><li>Memberikan bimbingan, mempersiapkan sarana, dan mengelola hasil kerja.</li><li>Melakukan bimbingan sosial dan kerohanian bagi narapidana / anak didik.</li><li>Melakukan pemeliharaan keamanan dan tata tertib Lembaga Pemasyarakatan.</li><li>Melakukan urusan tata usaha dan rumah tangga.</li></ul>',
            'hak_kewajiban' => '<p class="text-lg font-bold text-rose-900 mb-4">Berdasarkan Undang-Undang Nomor 22 Tahun 2022 tentang Pemasyarakatan, terdapat perbedaan signifikan mengenai hak dan kewajiban Klien Pemasyarakatan dibandingkan dengan UU No. 12 Tahun 1995. Sesuai Pasal 1 angka 8, <strong>Klien Pemasyarakatan</strong> adalah seseorang yang berada dalam pembimbingan kemasyarakatan, baik dewasa maupun anak.</p><h4><strong>Hak Klien Pemasyarakatan</strong></h4><p>Klien Pemasyarakatan berhak menerima berbagai layanan dan program selama masa pembinaan, meliputi:</p><ul><li><strong>Hak Pendampingan:</strong> Diberikan pada tahap pra-adjudikasi, adjudikasi, pasca-adjudikasi, hingga bimbingan lanjutan. <em>(Catatan: Saat ini, implementasi penuh baru berjalan untuk Anak Berhadapan dengan Hukum, sementara untuk klien dewasa masih dalam proses penerapan).</em></li><li><strong>Program Pembimbingan:</strong> Meliputi Penelitian Kemasyarakatan oleh Pembimbing Kemasyarakatan (PK) untuk menentukan program yang sesuai karakteristik klien. Pada bimbingan lanjutan, fokus utama adalah pembimbingan kemandirian (keterampilan kerja/usaha) untuk bekal hidup di masyarakat.</li><li><strong>Izin Bepergian ke Luar Negeri:</strong> Diberikan khusus bagi klien yang menjalani Pembebasan Bersyarat (PB) untuk alasan penting seperti pengobatan, pendidikan, atau ibadah, dengan syarat mendapatkan izin dari Menteri Hukum dan HAM RI.</li><li><strong>Hak Informasi:</strong> Mendapatkan informasi penting mengenai peraturan pembimbingan kemasyarakatan yang harus disepakati.</li><li><strong>Hak Pengaduan:</strong> Berhak menyampaikan keluhan atau masalah kepada PK, misalnya kendala dalam mencari pekerjaan, agar PK dapat membantu mencarikan solusi atau lowongan pekerjaan.</li></ul><h4><strong>Kewajiban Klien Pemasyarakatan</strong></h4><p>Selain hak, Klien Pemasyarakatan diwajibkan untuk mematuhi aturan integrasi di masyarakat:</p><ul><li><strong>Menaati Kesepakatan:</strong> Mematuhi seluruh persyaratan pembimbingan yang telah disepakati hingga masa bimbingan berakhir.</li><li><strong>Wajib Lapor:</strong> Melapor secara rutin ke Balai Pemasyarakatan (Bapas) agar PK dapat memantau kondisi dan keberadaan klien. <em>(Sanksi: Tidak lapor 3 kali berturut-turut dianggap pelanggaran khusus dan program PB dapat dicabut).</em></li><li><strong>Menjaga Ketertiban:</strong> Memelihara perikehidupan yang bersih, tertib, aman, dan damai selama berbaur dengan masyarakat.</li><li><strong>Tidak Menimbulkan Keresahan:</strong> Dilarang melakukan perbuatan yang meresahkan warga. Laporan keresahan dari masyarakat atau aparatur dapat berakibat pada pencabutan program Integrasi.</li><li><strong>Menghormati Hak Asasi Manusia (HAM):</strong> Menjunjung tinggi toleransi antarumat beragama dan menghormati hak asasi setiap individu di lingkungannya.</li></ul>',
        ];

        return view('profile.index', compact('kalapas', 'eselon4', 'eselon5', 'institutional'));
    }

    /**
     * Display the live queue monitoring page.
     *
     * @return \Illuminate\View\View
     */
    public function liveAntrian(): View
    {
        return view('guest.live_antrian');
    }

    /**
     * Tampilkan halaman laporan informasi publik untuk pengunjung.
     */
    public function publicReports(Request $request): View
    {
        $category = $request->query('category');
        
        $query = \App\Models\FinancialReport::where('is_published', true);
        
        if ($category) {
            $query->where('category', $category);
        }

        $reports = $query->latest()->get()->groupBy('category');
        
        // Ambil data kategori untuk mendapatkan ikon/emoji
        $categoryData = \App\Models\ReportCategory::all()->keyBy('name');

        return view('guest.public_reports.index', compact('reports', 'category', 'categoryData'));
    }

    public function integrasi(): View
    {
        return view('guest.integrasi.index');
    }

    /**
     * Display the digital announcement board.
     *
     * @return \Illuminate\View\View
     */
    public function papanPengumuman(): View
    {
        return view('guest.papan_pengumuman');
    }
}