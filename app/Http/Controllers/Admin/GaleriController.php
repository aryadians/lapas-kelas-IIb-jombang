<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function index()
    {
        $galeris = Galeri::orderBy('order_index')->get();
        return view('admin.galeri.index', compact('galeris'));
    }

    public function create()
    {
        return view('admin.galeri.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'material' => 'nullable|string',
            'dimension' => 'nullable|string',
            'status' => 'required|string',
            'order_index' => 'nullable|integer'
        ]);

        $file = $request->file('image');
        $mime = $file->getMimeType();
        $fileData = file_get_contents($file->getRealPath());
        $imageBase64 = 'data:' . $mime . ';base64,' . base64_encode($fileData);

        Galeri::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imageBase64,
            'price' => $request->price,
            'material' => $request->material,
            'dimension' => $request->dimension,
            'status' => $request->status,
            'order_index' => $request->order_index ?? 0,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('admin.galeri.index')->with('success', 'Data galeri berhasil ditambahkan.');
    }

    public function edit(Galeri $galeri)
    {
        return view('admin.galeri.edit', compact('galeri'));
    }

    public function update(Request $request, Galeri $galeri)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'material' => 'nullable|string',
            'dimension' => 'nullable|string',
            'status' => 'required|string',
            'order_index' => 'nullable|integer'
        ]);

        $data = $request->only(['title', 'description', 'price', 'material', 'dimension', 'status', 'order_index']);
        $data['is_active'] = $request->has('is_active') ? true : false;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $mime = $file->getMimeType();
            $fileData = file_get_contents($file->getRealPath());
            $data['image_path'] = 'data:' . $mime . ';base64,' . base64_encode($fileData);
        }

        $galeri->update($data);

        return redirect()->route('admin.galeri.index')->with('success', 'Data galeri berhasil diperbarui.');
    }

    public function destroy(Galeri $galeri)
    {
        $galeri->delete();
        return redirect()->route('admin.galeri.index')->with('success', 'Data galeri berhasil dihapus.');
    }
}
