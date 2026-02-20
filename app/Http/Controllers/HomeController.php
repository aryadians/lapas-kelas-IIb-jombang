<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
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
     * @return string
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
