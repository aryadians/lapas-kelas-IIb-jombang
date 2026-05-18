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

        $institutional->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('admin.institutional.index')->with('success', 'Informasi lembaga berhasil diperbarui.');
    }
}
