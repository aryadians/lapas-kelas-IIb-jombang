<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AnnouncementController extends Controller
{
    // INDEX: Tampilkan daftar pengumuman
    public function index(Request $request)
    {
        // Urutkan berdasarkan tanggal kegiatan terbaru, dengan pencarian
        $query = Announcement::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        $announcements = $query->orderBy('date', 'desc')->paginate(10)->withQueryString();
        return view('admin.announcements.index', compact('announcements'));
    }

    // CREATE: Form tambah
    public function create()
    {
        return view('admin.announcements.create');
    }

    // STORE: Simpan data
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|max:255',
            'date'    => 'required|date',
            'content' => 'required',
            'status'  => 'required|in:published,draft',
        ]);

        Announcement::create($request->all());

        Cache::forget('homepage_announcements');

        return redirect()->route('announcements.index')->with('success', 'Pengumuman berhasil dibuat!');
    }

    // SHOW: Tampilkan detail
    public function show(Announcement $announcement)
    {
        return view('admin.announcements.show', compact('announcement'));
    }

    // EDIT: Form edit
    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    // UPDATE: Simpan perubahan
    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title'   => 'required|max:255',
            'date'    => 'required|date',
            'content' => 'required',
            'status'  => 'required|in:published,draft',
        ]);

        $announcement->update($request->all());

        Cache::forget('homepage_announcements');

        return redirect()->route('announcements.index')->with('success', 'Pengumuman berhasil diperbarui!');
    }

    // DESTROY: Hapus
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        Cache::forget('homepage_announcements');
        return redirect()->route('announcements.index')->with('success', 'Pengumuman dihapus!');
    }
}