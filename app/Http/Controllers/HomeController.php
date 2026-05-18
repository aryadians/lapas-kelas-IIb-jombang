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
            'misi' => '<ol><li>Mendukung penegakan hukum di bidang penyelenggaraan pemasyarakatan yang bebas dari korupsi, bermartabat, dan terpercaya.</li><li>Ikut serta dalam menjaga stabilitas keamanan melalui peran pemasyarakatan.</li><li>Mewujudkan penyelenggaraan pemasyarakatan yang profesional dalam mendukung penegakan hukum berbasis Hak Asasi Manusia yang berkeadilan.</li><li>Melaksanakan tata laksana pemerintahan yang baik melalui reformasi birokrasi.</li></ol>',
            'tujuan' => '<div class="space-y-6"><div><h4 class="text-xl font-black text-emerald-700 mb-3 flex items-center gap-2"><span class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center text-sm">1</span> Integritas Hukum</h4><p class="pl-10 text-slate-700 leading-relaxed">Membentuk Warga Binaan Pemasyarakatan menjadi manusia seutuhnya yang menyadari kesalahan, memperbaiki diri, dan tidak mengulangi tindak pidana. Memberikan jaminan pelindungan HAM tahanan, serta keamanan barang sitaan/rampasan negara.</p></div><div><h4 class="text-xl font-black text-emerald-700 mb-3 flex items-center gap-2"><span class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center text-sm">2</span> Stabilitas Keamanan</h4><p class="pl-10 text-slate-700 leading-relaxed">Menciptakan kondisi Unit Pelaksana Teknis (UPT) Pemasyarakatan yang aman dan tertib.</p></div><div><h4 class="text-xl font-black text-emerald-700 mb-3 flex items-center gap-2"><span class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center text-sm">3</span> Profesionalisme Berbasis HAM</h4><p class="pl-10 text-slate-700 leading-relaxed">Menjaga derajat kesehatan tahanan dan narapidana, mengoptimalkan peran masyarakat, serta mengembangkan pemasyarakatan berbasis Teknologi Informasi (TI).</p></div><div><h4 class="text-xl font-black text-emerald-700 mb-3 flex items-center gap-2"><span class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center text-sm">4</span> Reformasi Birokrasi</h4><p class="pl-10 text-slate-700 leading-relaxed">Meningkatkan kinerja tata kelola pemerintahan di lingkungan Direktorat Jenderal Pemasyarakatan.</p></div></div>',
            'sasaran_program' => '<div class="space-y-8"><div class="bg-white/50 backdrop-blur-sm rounded-2xl p-6 border border-indigo-100/50"><h4 class="text-xl font-black text-indigo-400 mb-4 flex items-center gap-3"><span class="w-10 h-10 bg-indigo-500/20 rounded-xl flex items-center justify-center"><i class="fas fa-users text-indigo-400"></i></span>Perspektif Pemangku Kepentingan</h4><ul class="space-y-3"><li class="flex gap-3 items-start"><span class="text-indigo-400 mt-1">•</span><span class="text-slate-200 leading-relaxed">Terwujudnya penyelenggaraan yang mendorong inovasi dan kreativitas ekonomi nasional.</span></li><li class="flex gap-3 items-start"><span class="text-indigo-400 mt-1">•</span><span class="text-slate-200 leading-relaxed">Profesionalisme dalam penegakan hukum berbasis HAM terhadap Tahanan, Benda Sitaan, Narapidana, Anak, dan Warga Binaan Pemasyarakatan.</span></li></ul></div><div class="bg-white/50 backdrop-blur-sm rounded-2xl p-6 border border-indigo-100/50"><h4 class="text-xl font-black text-indigo-400 mb-4 flex items-center gap-3"><span class="w-10 h-10 bg-indigo-500/20 rounded-xl flex items-center justify-center"><i class="fas fa-user-check text-indigo-400"></i></span>Perspektif Penerima Layanan</h4><ul class="space-y-3"><li class="flex gap-3 items-start"><span class="text-indigo-400 mt-1">•</span><span class="text-slate-200 leading-relaxed">Penyelenggaraan Pemasyarakatan yang berkualitas.</span></li><li class="flex gap-3 items-start"><span class="text-indigo-400 mt-1">•</span><span class="text-slate-200 leading-relaxed">Penyelenggaraan Pemasyarakatan yang aman dan tertib.</span></li></ul></div><div class="bg-white/50 backdrop-blur-sm rounded-2xl p-6 border border-indigo-100/50"><h4 class="text-xl font-black text-indigo-400 mb-4 flex items-center gap-3"><span class="w-10 h-10 bg-indigo-500/20 rounded-xl flex items-center justify-center"><i class="fas fa-cogs text-indigo-400"></i></span>Perspektif Proses Bisnis Internal</h4><ul class="space-y-3"><li class="flex gap-3 items-start"><span class="text-indigo-400 mt-1">•</span><span class="text-slate-200 leading-relaxed">Tersedianya kebijakan pembangunan yang efektif.</span></li><li class="flex gap-3 items-start"><span class="text-indigo-400 mt-1">•</span><span class="text-slate-200 leading-relaxed">Meningkatnya kualitas penyelenggaraan pendukung penegakan hukum berbasis HAM.</span></li><li class="flex gap-3 items-start"><span class="text-indigo-400 mt-1">•</span><span class="text-slate-200 leading-relaxed">Terselenggaranya pengendalian dan pengawasan yang partisipatif.</span></li></ul></div><div class="bg-white/50 backdrop-blur-sm rounded-2xl p-6 border border-indigo-100/50"><h4 class="text-xl font-black text-indigo-400 mb-4 flex items-center gap-3"><span class="w-10 h-10 bg-indigo-500/20 rounded-xl flex items-center justify-center"><i class="fas fa-graduation-cap text-indigo-400"></i></span>Perspektif Pembelajaran & Tumbuh</h4><ul class="space-y-3"><li class="flex gap-3 items-start"><span class="text-indigo-400 mt-1">•</span><span class="text-slate-200 leading-relaxed">SDM Pemasyarakatan yang kompeten, profesional, dan berintegritas.</span></li><li class="flex gap-3 items-start"><span class="text-indigo-400 mt-1">•</span><span class="text-slate-200 leading-relaxed">Sistem Informasi dan layanan berbasis IT yang andal dan terintegrasi.</span></li><li class="flex gap-3 items-start"><span class="text-indigo-400 mt-1">•</span><span class="text-slate-200 leading-relaxed">Peningkatan peran masyarakat.</span></li><li class="flex gap-3 items-start"><span class="text-indigo-400 mt-1">•</span><span class="text-slate-200 leading-relaxed">Birokrasi yang efektif dan berorientasi layanan prima.</span></li><li class="flex gap-3 items-start"><span class="text-indigo-400 mt-1">•</span><span class="text-slate-200 leading-relaxed">Pengelolaan keuangan yang efisien dan akuntabel.</span></li></ul></div></div>',
            'tugas_fungsi' => '<div class="space-y-6"><div class="bg-blue-50/50 rounded-2xl p-6 border-l-4 border-blue-500"><h4 class="text-xl font-black text-blue-900 mb-3">Tugas Pokok</h4><p class="text-slate-700 text-lg leading-relaxed">Lembaga Pemasyarakatan mempunyai tugas melaksanakan pemasyarakatan narapidana atau anak didik.</p></div><div class="bg-slate-50/50 rounded-2xl p-6 border-l-4 border-slate-400"><h4 class="text-xl font-black text-slate-900 mb-4">Fungsi Institusi</h4><ol class="space-y-3"><li class="flex gap-3 items-start"><span class="font-black text-slate-600 min-w-[24px]">1.</span><span class="text-slate-700 leading-relaxed">Melakukan pembinaan narapidana / anak didik.</span></li><li class="flex gap-3 items-start"><span class="font-black text-slate-600 min-w-[24px]">2.</span><span class="text-slate-700 leading-relaxed">Memberikan bimbingan, mempersiapkan sarana, dan mengelola hasil kerja.</span></li><li class="flex gap-3 items-start"><span class="font-black text-slate-600 min-w-[24px]">3.</span><span class="text-slate-700 leading-relaxed">Melakukan bimbingan sosial dan kerohanian bagi narapidana / anak didik.</span></li><li class="flex gap-3 items-start"><span class="font-black text-slate-600 min-w-[24px]">4.</span><span class="text-slate-700 leading-relaxed">Melakukan pemeliharaan keamanan dan tata tertib Lembaga Pemasyarakatan.</span></li><li class="flex gap-3 items-start"><span class="font-black text-slate-600 min-w-[24px]">5.</span><span class="text-slate-700 leading-relaxed">Melakukan urusan tata usaha dan rumah tangga.</span></li></ol></div></div>',
            'hak_kewajiban' => '<div class="space-y-8"><div class="bg-rose-50/80 backdrop-blur-sm rounded-2xl p-8 border-2 border-rose-200/50"><p class="text-lg font-bold text-rose-900 leading-relaxed mb-2">Berdasarkan Undang-Undang Nomor 22 Tahun 2022 tentang Pemasyarakatan, terdapat perbedaan signifikan mengenai hak dan kewajiban Warga Binaan Pemasyarakatan dibandingkan dengan UU No. 12 Tahun 1995.</p><p class="text-base text-rose-800 leading-relaxed">Sesuai Pasal 1 angka 8, <strong>Warga Binaan Pemasyarakatan</strong> adalah seseorang yang berada dalam pembimbingan kemasyarakatan, baik dewasa maupun anak.</p></div><div class="bg-white rounded-3xl p-8 border-2 border-emerald-100"><h4 class="text-2xl font-black text-emerald-700 mb-6 flex items-center gap-3"><span class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center"><i class="fas fa-check-circle text-emerald-600"></i></span>Hak Warga Binaan Pemasyarakatan</h4><p class="text-slate-600 mb-6 text-lg">Warga Binaan Pemasyarakatan berhak menerima berbagai layanan dan program selama masa pembinaan, meliputi:</p><div class="space-y-4"><div class="flex gap-4 items-start p-4 bg-emerald-50/50 rounded-xl border border-emerald-100"><span class="text-emerald-600 font-black text-xl min-w-[28px]">1.</span><div><h5 class="font-black text-slate-800 mb-2">Hak Pendampingan</h5><p class="text-slate-700 leading-relaxed">Diberikan pada tahap pra-adjudikasi, adjudikasi, pasca-adjudikasi, hingga bimbingan lanjutan. <em class="text-slate-500 text-sm">(Catatan: Saat ini, implementasi penuh baru berjalan untuk Anak Berhadapan dengan Hukum, sementara untuk Warga Binaan dewasa masih dalam proses penerapan).</em></p></div></div><div class="flex gap-4 items-start p-4 bg-emerald-50/50 rounded-xl border border-emerald-100"><span class="text-emerald-600 font-black text-xl min-w-[28px]">2.</span><div><h5 class="font-black text-slate-800 mb-2">Program Pembimbingan</h5><p class="text-slate-700 leading-relaxed">Meliputi Penelitian Kemasyarakatan oleh Pembimbing Kemasyarakatan (PK) untuk menentukan program yang sesuai karakteristik Warga Binaan. Pada bimbingan lanjutan, fokus utama adalah pembimbingan kemandirian (keterampilan kerja/usaha) untuk bekal hidup di masyarakat.</p></div></div><div class="flex gap-4 items-start p-4 bg-emerald-50/50 rounded-xl border border-emerald-100"><span class="text-emerald-600 font-black text-xl min-w-[28px]">3.</span><div><h5 class="font-black text-slate-800 mb-2">Izin Bepergian ke Luar Negeri</h5><p class="text-slate-700 leading-relaxed">Diberikan khusus bagi Warga Binaan yang menjalani Pembebasan Bersyarat (PB) untuk alasan penting seperti pengobatan, pendidikan, atau ibadah, dengan syarat mendapatkan izin dari Menteri Hukum dan HAM RI.</p></div></div><div class="flex gap-4 items-start p-4 bg-emerald-50/50 rounded-xl border border-emerald-100"><span class="text-emerald-600 font-black text-xl min-w-[28px]">4.</span><div><h5 class="font-black text-slate-800 mb-2">Hak Informasi</h5><p class="text-slate-700 leading-relaxed">Mendapatkan informasi penting mengenai peraturan pembimbingan kemasyarakatan yang harus disepakati.</p></div></div><div class="flex gap-4 items-start p-4 bg-emerald-50/50 rounded-xl border border-emerald-100"><span class="text-emerald-600 font-black text-xl min-w-[28px]">5.</span><div><h5 class="font-black text-slate-800 mb-2">Hak Pengaduan</h5><p class="text-slate-700 leading-relaxed">Berhak menyampaikan keluhan atau masalah kepada PK, misalnya kendala dalam mencari pekerjaan, agar PK dapat membantu mencarikan solusi atau lowongan pekerjaan.</p></div></div></div></div><div class="bg-white rounded-3xl p-8 border-2 border-rose-100"><h4 class="text-2xl font-black text-rose-700 mb-6 flex items-center gap-3"><span class="w-12 h-12 bg-rose-100 rounded-xl flex items-center justify-center"><i class="fas fa-exclamation-triangle text-rose-600"></i></span>Kewajiban Warga Binaan Pemasyarakatan</h4><p class="text-slate-600 mb-6 text-lg">Selain hak, Warga Binaan Pemasyarakatan diwajibkan untuk mematuhi aturan integrasi di masyarakat:</p><div class="space-y-4"><div class="flex gap-4 items-start p-4 bg-rose-50/50 rounded-xl border border-rose-100"><span class="text-rose-600 font-black text-xl min-w-[28px]">1.</span><div><h5 class="font-black text-slate-800 mb-2">Menaati Kesepakatan</h5><p class="text-slate-700 leading-relaxed">Mematuhi seluruh persyaratan pembimbingan yang telah disepakati hingga masa bimbingan berakhir.</p></div></div><div class="flex gap-4 items-start p-4 bg-rose-50/50 rounded-xl border border-rose-100"><span class="text-rose-600 font-black text-xl min-w-[28px]">2.</span><div><h5 class="font-black text-slate-800 mb-2">Wajib Lapor</h5><p class="text-slate-700 leading-relaxed">Melapor secara rutin ke Balai Pemasyarakatan (Bapas) agar PK dapat memantau kondisi dan keberadaan Warga Binaan. <em class="text-rose-600 font-semibold">(Sanksi: Tidak lapor 3 kali berturut-turut dianggap pelanggaran khusus dan program PB dapat dicabut).</em></p></div></div><div class="flex gap-4 items-start p-4 bg-rose-50/50 rounded-xl border border-rose-100"><span class="text-rose-600 font-black text-xl min-w-[28px]">3.</span><div><h5 class="font-black text-slate-800 mb-2">Menjaga Ketertiban</h5><p class="text-slate-700 leading-relaxed">Memelihara perikehidupan yang bersih, tertib, aman, dan damai selama berbaur dengan masyarakat.</p></div></div><div class="flex gap-4 items-start p-4 bg-rose-50/50 rounded-xl border border-rose-100"><span class="text-rose-600 font-black text-xl min-w-[28px]">4.</span><div><h5 class="font-black text-slate-800 mb-2">Tidak Menimbulkan Keresahan</h5><p class="text-slate-700 leading-relaxed">Dilarang melakukan perbuatan yang meresahkan warga. Laporan keresahan dari masyarakat atau aparatur dapat berakibat pada pencabutan program Integrasi.</p></div></div><div class="flex gap-4 items-start p-4 bg-rose-50/50 rounded-xl border border-rose-100"><span class="text-rose-600 font-black text-xl min-w-[28px]">5.</span><div><h5 class="font-black text-slate-800 mb-2">Menghormati Hak Asasi Manusia (HAM)</h5><p class="text-slate-700 leading-relaxed">Menjunjung tinggi toleransi antarumat beragama dan menghormati hak asasi setiap individu di lingkungannya.</p></div></div></div></div></div>',
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