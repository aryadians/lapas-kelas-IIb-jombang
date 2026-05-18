<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\InstitutionalInfo;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        
        // Load institutional info data
        $institutionalData = InstitutionalInfo::pluck('content', 'key')->toArray();
        
        return view('admin.profile.edit', [
            'user' => $user,
            'institutionalData' => $institutionalData
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            
            // Institutional info fields
            'visi_misi' => ['nullable', 'string'],
            'tujuan_fungsi' => ['nullable', 'string'],
            'sasaran_program' => ['nullable', 'string'],
            'tugas_fungsi' => ['nullable', 'string'],
            'hak_kewajiban' => ['nullable', 'string'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $imageData = base64_encode(file_get_contents($image));
            $data['avatar'] = 'data:' . $image->getMimeType() . ';base64,' . $imageData;
        }

        $user->update($data);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        // Update institutional info
        $institutionalFields = [
            'visi_misi' => 'Visi & Misi',
            'tujuan_fungsi' => 'Tujuan & Fungsi',
            'sasaran_program' => 'Sasaran & Program',
            'tugas_fungsi' => 'Tugas & Fungsi',
            'hak_kewajiban' => 'Hak & Kewajiban',
        ];

        foreach ($institutionalFields as $key => $title) {
            if ($request->has($key)) {
                InstitutionalInfo::updateOrCreate(
                    ['key' => $key],
                    [
                        'title' => $title,
                        'content' => $request->input($key),
                        'type' => 'html'
                    ]
                );
            }
        }

        return redirect()->route('admin.profile.edit')->with('success', 'Profil dan informasi lembaga berhasil diperbarui.');
    }
}
