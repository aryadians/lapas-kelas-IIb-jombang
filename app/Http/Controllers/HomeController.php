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
        // Placeholder: A proper view should be created for this.
        return "Profile page is under construction.";
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
}
