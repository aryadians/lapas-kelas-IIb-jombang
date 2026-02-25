<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

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
        $extension = strtolower($file->getClientOriginalExtension());
        $mime = $file->getMimeType();
        $type = in_array($extension, ['mp4', 'webm']) ? 'video' : 'image';
        
        if ($type === 'image') {
            // Store as Base64
            $fileData = file_get_contents($file->getRealPath());
            $filePath = 'data:' . $mime . ';base64,' . base64_encode($fileData);
        } else {
            // Store as File Path
            $filePath = $file->store('banners', 'public');
        }

        Banner::create([
            'title' => $request->title,
            'type' => $type,
            'file_path' => $filePath,
            'is_active' => $request->has('is_active'),
            'order_index' => $request->order_index ?? 0,
        ]);

        Cache::forget('active_banners');

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
            // Hapus file lama jika tipe sebelumnya adalah video/file storage
            if ($banner->type === 'video' || !str_starts_with($banner->file_path, 'data:')) {
                if (Storage::disk('public')->exists($banner->file_path)) {
                    Storage::disk('public')->delete($banner->file_path);
                }
            }

            $file = $request->file('file');
            $extension = strtolower($file->getClientOriginalExtension());
            $mime = $file->getMimeType();
            $data['type'] = in_array($extension, ['mp4', 'webm']) ? 'video' : 'image';
            
            if ($data['type'] === 'image') {
                $fileData = file_get_contents($file->getRealPath());
                $data['file_path'] = 'data:' . $mime . ';base64,' . base64_encode($fileData);
            } else {
                $data['file_path'] = $file->store('banners', 'public');
            }
        }

        $banner->update($data);
        Cache::forget('active_banners');

        return redirect()->route('admin.banners.index')->with('success', 'Banner berhasil diperbarui.');
    }

    public function destroy(Banner $banner)
    {
        // Hanya hapus file jika bukan Base64
        if (!str_starts_with($banner->file_path, 'data:')) {
            if (Storage::disk('public')->exists($banner->file_path)) {
                Storage::disk('public')->delete($banner->file_path);
            }
        }
        
        $banner->delete();
        Cache::forget('active_banners');

        return redirect()->route('admin.banners.index')->with('success', 'Banner berhasil dihapus.');
    }
}
