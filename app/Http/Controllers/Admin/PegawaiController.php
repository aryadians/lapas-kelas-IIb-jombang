<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawais = Pegawai::orderBy('level')->orderBy('order_index')->get();
        return view('admin.pegawai.index', compact('pegawais'));
    }

    public function create()
    {
        return view('admin.pegawai.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'seksi' => 'nullable|string|max:255',
            'level' => 'required|in:kalapas,eselon_4,eselon_5',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'quotes' => 'nullable|string|max:500',
            'order_index' => 'nullable|integer'
        ]);

        $fotoBase64 = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $mime = $file->getMimeType();
            $fileData = file_get_contents($file->getRealPath());
            $fotoBase64 = 'data:' . $mime . ';base64,' . base64_encode($fileData);
        }

        Pegawai::create([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'seksi' => $request->seksi,
            'level' => $request->level,
            'foto' => $fotoBase64,
            'quotes' => $request->quotes,
            'order_index' => $request->order_index ?? 0,
        ]);

        return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    public function edit(Pegawai $pegawai)
    {
        return view('admin.pegawai.edit', compact('pegawai'));
    }

    public function update(Request $request, Pegawai $pegawai)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'seksi' => 'nullable|string|max:255',
            'level' => 'required|in:kalapas,eselon_4,eselon_5',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'quotes' => 'nullable|string|max:500',
            'order_index' => 'nullable|integer'
        ]);

        $data = $request->only(['nama', 'jabatan', 'seksi', 'level', 'quotes', 'order_index']);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $mime = $file->getMimeType();
            $fileData = file_get_contents($file->getRealPath());
            $data['foto'] = 'data:' . $mime . ';base64,' . base64_encode($fileData);
        }

        $pegawai->update($data);

        return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy(Pegawai $pegawai)
    {
        $pegawai->delete();
        return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai berhasil dihapus.');
    }
}
