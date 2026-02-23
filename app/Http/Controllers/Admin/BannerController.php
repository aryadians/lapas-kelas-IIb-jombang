<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('order_index')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,gif,mp4,webm|max:20480', // 20MB max
            'title' => 'nullable|string|max:255',
            'order_index' => 'nullable|integer'
        ]);

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $type = in_array(strtolower($extension), ['mp4', 'webm']) ? 'video' : 'image';
        
        $path = $file->store('banners', 'public');

        Banner::create([
            'title' => $request->title,
            'type' => $type,
            'file_path' => $path,
            'is_active' => $request->has('is_active'),
            'order_index' => $request->order_index ?? 0,
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'Banner berhasil ditambahkan.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,webm|max:20480',
            'title' => 'nullable|string|max:255',
            'order_index' => 'nullable|integer'
        ]);

        $data = [
            'title' => $request->title,
            'is_active' => $request->has('is_active'),
            'order_index' => $request->order_index ?? 0,
        ];

        if ($request->hasFile('file')) {
            // Hapus file lama
            if (Storage::disk('public')->exists($banner->file_path)) {
                Storage::disk('public')->delete($banner->file_path);
            }

            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $data['type'] = in_array(strtolower($extension), ['mp4', 'webm']) ? 'video' : 'image';
            $data['file_path'] = $file->store('banners', 'public');
        }

        $banner->update($data);

        return redirect()->route('admin.banners.index')->with('success', 'Banner berhasil diperbarui.');
    }

    public function destroy(Banner $banner)
    {
        if (Storage::disk('public')->exists($banner->file_path)) {
            Storage::disk('public')->delete($banner->file_path);
        }
        
        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Banner berhasil dihapus.');
    }
}
