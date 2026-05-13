@extends('layouts.main')

@section('title', 'Alur & Usulan Integrasi')

@section('content')

@push('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    [x-cloak] { display: none !important; }
    .flow-step-wrapper { display: flex; flex-direction: column; align-items: center; gap: 0.5rem; flex: 1; position: relative; }
    .step-icon-box { width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; background: white; border: 3px solid #e2e8f0; border-radius: 15px; font-size: 1.5rem; }
</style>
@endpush

<section class="relative bg-gradient-to-br from-slate-900 via-blue-900 to-indigo-950 text-white pt-32 pb-24 overflow-hidden">
    <div class="container mx-auto px-6 relative z-10 text-center max-w-4xl" data-aos="zoom-in">
        <h1 class="text-4xl md:text-6xl font-black mb-6">Alur & Informasi Integrasi</h1>
    </div>
</section>

<section class="py-16 bg-slate-50" x-data="{ tab: 'remisi' }">
    <div class="container mx-auto px-6 max-w-6xl">
        <div class="flex flex-wrap justify-center gap-3 mb-16">
            <button @click="tab = 'remisi'" :class="tab === 'remisi' ? 'bg-blue-600 text-white shadow-lg' : 'bg-white text-slate-600'" class="px-8 py-3 rounded-full font-bold transition">Remisi Reguler</button>
            <button @click="tab = 'pb'" :class="tab === 'pb' ? 'bg-blue-600 text-white shadow-lg' : 'bg-white text-slate-600'" class="px-8 py-3 rounded-full font-bold transition">Pembebasan Bersyarat</button>
            <button @click="tab = 'cb'" :class="tab === 'cb' ? 'bg-blue-600 text-white shadow-lg' : 'bg-white text-slate-600'" class="px-8 py-3 rounded-full font-bold transition">Cuti Bersyarat</button>
        </div>

        {{-- 8 STEP UPT DETAIL --}}
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 mb-12">
            <h4 class="text-xl font-black text-slate-800 mb-6">Proses Pengajuan (8 Langkah UPT)</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-4 bg-blue-50 rounded-xl text-sm font-semibold text-slate-700">1. Pendataan Narapidana syarat</div>
                <div class="p-4 bg-blue-50 rounded-xl text-sm font-semibold text-slate-700">2. Melengkapi data & dokumen</div>
                <div class="p-4 bg-blue-50 rounded-xl text-sm font-semibold text-slate-700">3. Sidang TPP</div>
                <div class="p-4 bg-blue-50 rounded-xl text-sm font-semibold text-slate-700">4. Pelaksanaan Sidang</div>
                <div class="p-4 bg-blue-50 rounded-xl text-sm font-semibold text-slate-700">5. Kontrol sidang</div>
                <div class="p-4 bg-blue-50 rounded-xl text-sm font-semibold text-slate-700">6. Verifikasi sidang</div>
                <div class="p-4 bg-blue-50 rounded-xl text-sm font-semibold text-slate-700">7. Upload surat pengantar</div>
                <div class="p-4 bg-blue-50 rounded-xl text-sm font-semibold text-slate-700">8. Kirim ke Ditjenpas & Kanwil</div>
            </div>
        </div>

        {{-- Dynamic Tab Content --}}
        <div class="bg-white p-8 rounded-3xl shadow border border-slate-100">
            <div x-show="tab === 'remisi'" x-cloak>
                <h3 class="text-xl font-black mb-4">Alur Remisi Reguler</h3>
                <ul class="list-decimal pl-5 space-y-2 text-slate-700">
                    <li>Tahap 1 (UPT): 8 Langkah UPT.</li>
                    <li>Tahap 2 (Kanwil): Verifikasi usulan.</li>
                    <li>Tahap 3 (Ditjenpas): Verifikasi, Persetujuan, Generate SK Kolektif, Tanda Tangan Elektronik.</li>
                    <li>Tahap 4 (UPT): Menerima data SK (Tanpa Cetak).</li>
                    <li>Tahap 5 (Kanwil): Menerima tembusan (Tanpa Cetak).</li>
                </ul>
            </div>
            
            <div x-show="tab === 'pb' || tab === 'cb'" x-cloak>
                <h3 class="text-xl font-black mb-4" x-text="tab === 'pb' ? 'Alur Pembebasan Bersyarat (PB)' : 'Alur Cuti Bersyarat (CB)'"></h3>
                <div class="bg-amber-50 p-4 rounded-xl border border-amber-200 text-amber-800 mb-4 font-bold italic">
                    Perbedaan: Verifikasi Ditjenpas Max 3 Hari, Tanda Tangan Elektronik DIRJEN, UPT wajib Cetak SK H-3, Kanwil wajib Cetak SK.
                </div>
                <ul class="list-decimal pl-5 space-y-2 text-slate-700">
                    <li>Tahap 1 (UPT): 8 Langkah UPT.</li>
                    <li>Tahap 2 (Kanwil): Verifikasi usulan.</li>
                    <li>Tahap 3 (Ditjenpas): Verifikasi (MAX 3 HARI), Persetujuan, Generate SK Kolektif, Tanda Tangan Elektronik DIRJEN.</li>
                    <li>Tahap 4 (UPT): Menerima data & CETAK SK H-3.</li>
                    <li>Tahap 5 (Kanwil): Menerima tembusan & CETAK SURAT KEPUTUSAN.</li>
                </ul>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init();</script>
@endpush
