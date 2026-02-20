<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SurveyController extends Controller
{
    /**
     * Tampilkan formulir survei IKM.
     */
    public function create(Request $request)
    {
        $kunjungan = null;
        if ($request->has('kunjungan_id')) {
            $kunjungan = Kunjungan::find($request->kunjungan_id);
        }

        return view('survey.create', compact('kunjungan'));
    }

    /**
     * Simpan hasil survei.
     */
    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:4',
            'saran' => 'nullable|string|max:1000',
        ]);

        Survey::create([
            'rating' => $request->rating,
            'saran' => $request->saran,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Terima kasih atas penilaian Anda!'], 200);
        }

        return redirect()->route('survey.create')->with('success', 'Terima kasih! Penilaian Anda sangat berarti bagi kami.');
    }
}
