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
        // Gunakan Cache untuk meningkatkan performa halaman utama
        $news = Cache::remember('homepage_news', 3600, function() {
            // Hanya ambil kolom penting demi menghemat kapasitas cache DB
            // Hindari mengambil 'content' atau 'image' (base64) secara utuh ke Cache
            return News::select('id', 'title', 'slug', 'created_at', 'status', 'image')
                ->where('status', 'published')
                ->latest()
                ->take(4)
                ->get()
                ->map(function ($item) {
                    // Ambil gambar pertama saja jika berupa array base64, lalu hapus sisa elemen untuk hemat ukuran cache
                    if (is_array($item->image) && count($item->image) > 0) {
                        $item->image = [$item->image[0]];
                    } else {
                        $item->image = [];
                    }
                    return $item;
                });
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
     * @return string
     */
    public function contact()
    {
        // Placeholder: A proper view should be created for this.
        return "Contact page is under construction.";
    }

    /**
     * Display the profile page.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        return view('profile.index');
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

        return view('guest.public_reports.index', compact('reports', 'category'));
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