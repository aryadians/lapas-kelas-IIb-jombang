<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\ProfilPengunjung;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the user's followers page.
     */
    public function pengikut(Request $request): View
    {
        $user = $request->user();
        $profil = ProfilPengunjung::firstOrCreate(['user_id' => $user->id]);
        $profil->load('pengikuts');

        return view('profile.pengikut', [
            'user' => $user,
            'profil' => $profil,
        ]);
    }

    public function storePengikut(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'identitas_type' => ['required', 'in:nik,lainnya'],
            'nik' => [
                $request->identitas_type === 'nik' ? 'required' : 'nullable',
                'string',
                $request->identitas_type === 'nik' ? 'digits:16' : 'max:16',
            ],
            'hubungan' => ['required', 'string', 'max:100'],
        ]);

        $user = $request->user();
        $profil = $user->profilPengunjung;

        $pengikut = \App\Models\Pengikut::create($request->only(['nama', 'nik', 'hubungan']));
        $profil->pengikuts()->attach($pengikut);

        return Redirect::route('profile.pengikut')->with('status', 'pengikut-saved');
    }

    public function destroyPengikut(Request $request, $id): RedirectResponse
    {
        $user = $request->user();
        $profil = $user->profilPengunjung;

        // Detach relationship and delete the pengikut record
        $profil->pengikuts()->detach($id);
        $pengikut = \App\Models\Pengikut::find($id);
        if ($pengikut) {
            $pengikut->delete();
        }

        return Redirect::route('profile.pengikut')->with('status', 'pengikut-deleted');
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
