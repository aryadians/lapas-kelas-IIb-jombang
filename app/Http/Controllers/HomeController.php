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

class HomeController extends Controller
{
    /**
     * Display the landing page with scraping logic.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        // Ambil data berita dan pengumuman untuk view (Sesuaikan Model-nya jika berbeda)
        // Jika Anda mem-pass variabel ini dari route closure di web.php sebelumnya, 
        // lebih rapi dipindah ke controller seperti ini.
        $news = News::latest()->take(2)->get(); 
        $announcements = Announcement::latest()->take(5)->get();

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

        // Pastikan nama view sesuai dengan file blade landing page Anda (misal 'welcome')
        return view('welcome', compact('news', 'announcements', 'kemenimipasSlides'));
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