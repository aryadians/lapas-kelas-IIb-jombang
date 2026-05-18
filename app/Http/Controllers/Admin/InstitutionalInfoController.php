<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstitutionalInfo;
use Illuminate\Http\Request;

class InstitutionalInfoController extends Controller
{
    public function index()
    {
        $infos = InstitutionalInfo::all();
        
        // Auto-seed if empty (solves production deployment issue without terminal)
        if ($infos->isEmpty()) {
            \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'InstitutionalInfoSeeder', '--force' => true]);
            $infos = InstitutionalInfo::all();
        }

        return view('admin.institutional.index', compact('infos'));
    }

    public function create()
    {
        return view('admin.institutional.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|max:255|unique:institutional_infos,key',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:text,html',
        ]);

        try {
            InstitutionalInfo::create([
                'key' => \Illuminate\Support\Str::slug($request->key, '_'),
                'title' => $request->title,
                'content' => $request->content,
                'type' => $request->type,
            ]);

            return redirect()->route('admin.institutional.index')->with('success', "Informasi '{$request->title}' berhasil ditambahkan!");
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan data: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(InstitutionalInfo $institutional)
    {
        return view('admin.institutional.edit', compact('institutional'));
    }

    public function update(Request $request, InstitutionalInfo $institutional)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        try {
            $institutional->update([
                'title' => $request->title,
                'content' => $request->content,
            ]);

            return redirect()->route('admin.institutional.index')->with('success', "Informasi '{$institutional->title}' berhasil diperbarui dan sudah live!");
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(InstitutionalInfo $institutional)
    {
        try {
            $title = $institutional->title;
            $institutional->delete();
            return redirect()->route('admin.institutional.index')->with('success', "Informasi '{$title}' berhasil dihapus.");
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:institutional_infos,id'
        ]);

        try {
            InstitutionalInfo::whereIn('id', $request->ids)->delete();
            return response()->json([
                'success' => true,
                'message' => count($request->ids) . ' informasi berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data.'
            ], 500);
        }
    }
}
