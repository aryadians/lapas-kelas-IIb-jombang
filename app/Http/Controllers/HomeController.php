<?php

namespace App\Http\Controllers;
use App\Models\News;
use App\Models\Announcement;

class HomeController extends Controller
{
    public function index()
    {
        $news = News::latest()->take(3)->get();
        $announcements = Announcement::latest()->take(5)->get();

        // Kirim data ke view welcome
        return view('welcome', compact('news', 'announcements'));
    }

    public function contact()
    {
        return view('contact.index');
    }

    public function profile()
    {
        return view('profile.index');
    }

    public function liveAntrian()
    {
        return view('guest.kunjungan.live-antrian');
    }
}