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

        // UPDATE DATA PRODUK DENGAN DETAIL INFORMASI YANG LEBIH LENGKAP
        $products = [
            [
                'name' => 'Miniatur Kapal Pinisi',
                'category' => 'Kerajinan Kayu',
                'price' => 'Rp 350.000',
                'image' => 'https://images.unsplash.com/photo-1542042952-6703567d023e?q=80&w=600&auto=format&fit=crop',
                'description' => 'Miniatur detail dibuat dari limbah kayu jati berkualitas. Dibuat dengan ketelitian tinggi oleh warga binaan, mencerminkan nilai seni budaya bahari Indonesia.',
                'material' => 'Kayu Jati / Mahoni',
                'dimensions' => '30cm x 10cm x 25cm',
                'stock' => 'Pre-order / Tersedia'
            ],
            [
                'name' => 'Kotak Tisu Ukir',
                'category' => 'Cukil Kayu',
                'price' => 'Rp 75.000',
                'image' => 'https://images.unsplash.com/photo-1610701596007-11502861dcfa?q=80&w=600&auto=format&fit=crop',
                'description' => 'Kotak tisu estetik dengan ukiran khas Jombang. Finishing halus dengan melamin untuk ketahanan terhadap air dan debu.',
                'material' => 'Kayu Pinus / Mindi',
                'dimensions' => '24cm x 12cm x 9cm',
                'stock' => 'Tersedia'
            ],
            [
                'name' => 'Hiasan Dinding Tembaga',
                'category' => 'Seni Logam',
                'price' => 'Rp 500.000',
                'image' => 'https://images.unsplash.com/photo-1578320339912-78d2b2c27162?q=80&w=600&auto=format&fit=crop',
                'description' => 'Karya seni logam timbul (repousse) yang dikerjakan secara manual. Memberikan kesan mewah dan elegan untuk dekorasi interior kantor atau rumah.',
                'material' => 'Pelat Tembaga / Kuningan',
                'dimensions' => '40cm x 60cm',
                'stock' => 'Edisi Terbatas'
            ],
            [
                'name' => 'Asbak Resin Unik',
                'category' => 'Kerajinan Resin',
                'price' => 'Rp 45.000',
                'image' => 'https://images.unsplash.com/photo-1616400619175-5beda3a17896?q=80&w=600&auto=format&fit=crop',
                'description' => 'Perpaduan modern antara potongan kayu alami dan resin bening. Tahan panas dan mudah dibersihkan, setiap unit memiliki corak kayu yang unik.',
                'material' => 'Resin Polimer & Wood Slice',
                'dimensions' => 'Diameter 12cm',
                'stock' => 'Tersedia'
            ],
            [
                'name' => 'Tas Rajut Nilon',
                'category' => 'Rajutan',
                'price' => 'Rp 120.000',
                'image' => 'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?q=80&w=600&auto=format&fit=crop',
                'description' => 'Rajutan tangan yang kuat dan rapi menggunakan benang nilon premium. Tersedia dalam berbagai pilihan warna menarik, modis untuk kegiatan formal maupun santai.',
                'material' => 'Benang Nilon D27',
                'dimensions' => '25cm x 18cm',
                'stock' => 'Sesuai Pesanan'
            ],
            [
                'name' => 'Lukisan Bakar (Pyrography)',
                'category' => 'Seni Lukis',
                'price' => 'Rp 200.000',
                'image' => 'https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?q=80&w=600&auto=format&fit=crop',
                'description' => 'Teknik melukis unik dengan membakar permukaan kayu menggunakan solder khusus. Menghasilkan gradasi warna cokelat alami yang tahan lama dan tidak luntur.',
                'material' => 'Kayu Lapis / Solid Wood',
                'dimensions' => 'A3 (30cm x 42cm)',
                'stock' => 'Custom (Kirim Foto)'
            ],
        ];

        return view('guest.gallery.index', compact('products', 'links'));
    }
}
