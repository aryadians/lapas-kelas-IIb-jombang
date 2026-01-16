<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DisplayController extends Controller
{
    /**
     * Show the public queue display screen.
     *
     * @return \Illuminate\View\View
     */
    public function antrian()
    {
        return view('display.antrian');
    }
}
