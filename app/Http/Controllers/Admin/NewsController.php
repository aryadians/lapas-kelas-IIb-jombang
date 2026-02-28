<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class NewsController extends Controller
{

    public function index(Request $request)
    {
        $query = News::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        $news = $query->latest()->paginate(10)->withQueryString();

        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|max:255',
            'content'  => 'required',
            'images.*' => 'nullable|image|file|max:5120',        // max 5MB per gambar
            'videos.*' => 'nullable|file|mimes:mp4,mov,avi,webm|max:102400', // max 100MB per video
            'status'   => 'required|in:published,draft',
        ]);

        $data = [
            'title'   => $request->title,
            'slug'    => Str::slug($request->title),
            'content' => $request->content,
            'status'  => $request->status,
        ];

        // Upload Gambar → Base64
        $imagesData = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $base64 = base64_encode(file_get_contents($file->getRealPath()));
                $imagesData[] = 'data:' . $file->getMimeType() . ';base64,' . $base64;
            }
            $data['image'] = $imagesData;
        }

        // Upload Video → Storage (public/news_videos)
        $videoPaths = [];
        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $file) {
                $path = $file->store('news_videos', 'public');
                $videoPaths[] = $path;
            }
            $data['videos'] = $videoPaths;
        }

        News::create($data);

        Cache::forget('homepage_news');

        return redirect()->route('news.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    public function show(News $news)
    {
        return view('admin.news.show', compact('news'));
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title'    => 'required|max:255',
            'content'  => 'required',
            'images.*' => 'nullable|image|file|max:5120',
            'videos.*' => 'nullable|file|mimes:mp4,mov,avi,webm|max:102400',
            'status'   => 'required|in:published,draft',
        ]);

        $data = [
            'title'   => $request->title,
            'slug'    => Str::slug($request->title),
            'content' => $request->content,
            'status'  => $request->status,
        ];

        // Gambar baru → Base64 (jika ada)
        if ($request->hasFile('images')) {
            $imagesData = [];
            foreach ($request->file('images') as $file) {
                $base64 = base64_encode(file_get_contents($file->getRealPath()));
                $imagesData[] = 'data:' . $file->getMimeType() . ';base64,' . $base64;
            }
            $data['image'] = $imagesData;
        }

        // Video baru → Storage (jika ada, hapus yang lama dulu)
        if ($request->hasFile('videos')) {
            // Hapus video lama dari storage
            if (!empty($news->videos)) {
                foreach ($news->videos as $oldVideo) {
                    Storage::disk('public')->delete($oldVideo);
                }
            }
            $videoPaths = [];
            foreach ($request->file('videos') as $file) {
                $path = $file->store('news_videos', 'public');
                $videoPaths[] = $path;
            }
            $data['videos'] = $videoPaths;
        }

        // Handle hapus semua video (jika flag dikirim)
        if ($request->has('remove_all_videos') && $request->remove_all_videos == '1') {
            if (!empty($news->videos)) {
                foreach ($news->videos as $oldVideo) {
                    Storage::disk('public')->delete($oldVideo);
                }
            }
            $data['videos'] = null;
        }

        $news->update($data);

        Cache::forget('homepage_news');

        return redirect()->route('news.index')->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy(News $news)
    {
        // Hapus video dari storage sebelum delete record
        if (!empty($news->videos)) {
            foreach ($news->videos as $video) {
                Storage::disk('public')->delete($video);
            }
        }

        $news->delete();

        Cache::forget('homepage_news');

        return redirect()->route('news.index')->with('success', 'Berita berhasil dihapus!');
    }
}