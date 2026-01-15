<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the available products.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $products = Product::where('status', 'tersedia')->latest()->paginate(12);
        return view('products.index', compact('products'));
    }

    /**
     * Display the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\View\View
     */
    public function show(Product $product)
    {
        // Ensure the product is available to be viewed
        if ($product->status !== 'tersedia') {
            abort(404);
        }
        
        $product->load('creator');

        return view('products.show', compact('product'));
    }
}
