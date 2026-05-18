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
}
