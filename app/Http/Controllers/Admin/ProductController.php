<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wbp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $wbps = Wbp::orderBy('nama')->get();
        return view('admin.products.create', compact('wbps'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Logic to validate and store the new product
        // Redirect back with a success message
        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     * Note: Admin might not need a dedicated 'show' view, can redirect to edit.
     */
    public function show(Product $product): RedirectResponse
    {
        return redirect()->route('admin.products.edit', $product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        $wbps = Wbp::orderBy('nama')->get();
        return view('admin.products.edit', compact('product', 'wbps'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        // Logic to validate and update the product
        // Redirect back with a success message
        return redirect()->route('admin.products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        // Logic to delete the product and its image
        // Redirect back with a success message
        return redirect()->route('admin.products.index');
    }
}