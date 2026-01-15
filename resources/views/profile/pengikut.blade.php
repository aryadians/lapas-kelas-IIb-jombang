@extends('layouts.admin')

@section('content')
    <div class="space-y-8">
        {{-- Page Header --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-slate-800">Profil Pengikut</h1>
            <p class="text-slate-500">Simpan data pengikut untuk mempermudah pendaftaran kunjungan di masa mendatang.</p>
        </div>

        {{-- Manage Followers Form --}}
        <div class="bg-white rounded-2xl shadow-xl p-8 border-t-4 border-blue-500">
            @include('profile.partials.manage-followers-form')
        </div>
    </div>
@endsection
