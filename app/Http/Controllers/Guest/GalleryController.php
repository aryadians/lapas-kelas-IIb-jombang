<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        // Link Marketplace (Sesuai Request)
        $links = [
            'shopee' => 'https://id.shp.ee/N6U83aS3',
            'tokopedia' => 'https://www.tokopedia.com/galerylapasjombang'
        ];

        // Ambil data galeri aktif dan urutkan
        $products = \App\Models\Galeri::where('is_active', true)
            ->orderBy('order_index')
            ->get();

        return view('guest.gallery.index', compact('products', 'links'));
    }
}
