@extends('layouts.main')

@section('title', 'Alur & Usulan Integrasi')

@section('content')

@push('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    [x-cloak] { display: none !important; }
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(226, 232, 240, 0.8);
        transition: all 0.3s ease;
    }
    .flow-container {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .flow-step {
        width: 160px;
        text-align: center;
        padding: 1rem;
        background: white;
        border-radius: 1rem;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
    }
    .flow-arrow {
        font-size: 1.5rem;
        color: #64748b;
    }
</style>
@endpush

{{-- HERO SECTION --}}
<section class="relative bg-gradient-to-br from-slate-900 via-blue-900 to-indigo-950 text-white pt-32 pb-24 overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=1920&q=80')] bg-cover bg-center blur-sm opacity-20"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-transparent to-slate-900/90"></div>
    <div class="container mx-auto px-6 relative z-10 text-center max-w-4xl" data-aos="zoom-in">
        <h1 class="text-4xl md:text-6xl font-black mb-6">Alur & Informasi Integrasi</h1>
    </div>
</section>

{{-- TABS AREA --}}
<section class="py-12 bg-slate-50" x-data="{ tab: 'remisi' }">
    <div class="container mx-auto px-6 max-w-6xl">
        <div class="flex flex-wrap justify-center gap-2 mb-12">
            <button @click="tab = 'remisi'" :class="tab === 'remisi' ? 'bg-blue-600 text-white' : 'bg-white text-slate-600'" class="px-6 py-3 rounded-full font-bold shadow transition">Remisi Reguler</button>
            <button @click="tab = 'pb'" :class="tab === 'pb' ? 'bg-blue-600 text-white' : 'bg-white text-slate-600'" class="px-6 py-3 rounded-full font-bold shadow transition">Pembebasan Bersyarat</button>
            <button @click="tab = 'cb'" :class="tab === 'cb' ? 'bg-blue-600 text-white' : 'bg-white text-slate-600'" class="px-6 py-3 rounded-full font-bold shadow transition">Cuti Bersyarat</button>
        </div>

        {{-- Alur Remisi --}}
        <div x-show="tab === 'remisi'" x-cloak class="space-y-8">
            <h3 class="text-2xl font-black text-slate-800 text-center">Alur Remisi Reguler</h3>
            <div class="flow-container">
                <div class="flow-step"><i class="fas fa-building text-blue-500 mb-2"></i><p class="font-bold text-sm">UPT<br>(Pendataan)</p></div>
                <div class="flow-arrow"><i class="fas fa-arrow-right"></i></div>
                <div class="flow-step"><i class="fas fa-landmark text-blue-500 mb-2"></i><p class="font-bold text-sm">KANWIL<br>(Verifikasi)</p></div>
                <div class="flow-arrow"><i class="fas fa-arrow-right"></i></div>
                <div class="flow-step"><i class="fas fa-server text-blue-500 mb-2"></i><p class="font-bold text-sm">DITJENPAS<br>(SK Kolektif)</p></div>
            </div>
            <div class="flow-container pt-4">
                <div class="flow-step border-emerald-500"><i class="fas fa-file-alt text-emerald-500 mb-2"></i><p class="font-bold text-sm">UPT<br>(Terima Data)</p></div>
                <div class="flow-arrow"><i class="fas fa-arrow-down"></i></div>
                <div class="flow-step border-emerald-500"><i class="fas fa-file-check text-emerald-500 mb-2"></i><p class="font-bold text-sm">KANWIL<br>(Tembusan)</p></div>
            </div>
        </div>

        {{-- Alur PB/CB --}}
        <div x-show="tab === 'pb' || tab === 'cb'" x-cloak class="space-y-8">
            <h3 class="text-2xl font-black text-slate-800 text-center" x-text="tab === 'pb' ? 'Alur Pembebasan Bersyarat (PB)' : 'Alur Cuti Bersyarat (CB)'"></h3>
            <div class="bg-amber-100 p-4 rounded-xl text-center font-bold text-amber-800">
                <i class="fas fa-exclamation-triangle"></i> Verifikasi Ditjenpas Max 3 Hari | Wajib Cetak SK H-3 (UPT) & SK (Kanwil)
            </div>
            <div class="flow-container">
                <div class="flow-step"><i class="fas fa-building text-blue-500 mb-2"></i><p class="font-bold text-sm">UPT<br>(Pendataan)</p></div>
                <div class="flow-arrow"><i class="fas fa-arrow-right"></i></div>
                <div class="flow-step"><i class="fas fa-landmark text-blue-500 mb-2"></i><p class="font-bold text-sm">KANWIL<br>(Verifikasi)</p></div>
                <div class="flow-arrow"><i class="fas fa-arrow-right"></i></div>
                <div class="flow-step"><i class="fas fa-user-tie text-blue-500 mb-2"></i><p class="font-bold text-sm">DITJENPAS<br>(Dirjen Sign)</p></div>
            </div>
            <div class="flow-container pt-4">
                <div class="flow-step border-red-500"><i class="fas fa-print text-red-500 mb-2"></i><p class="font-bold text-sm">UPT<br>(Cetak SK H-3)</p></div>
                <div class="flow-arrow"><i class="fas fa-arrow-down"></i></div>
                <div class="flow-step border-red-500"><i class="fas fa-print text-red-500 mb-2"></i><p class="font-bold text-sm">KANWIL<br>(Cetak SK)</p></div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init();</script>
@endpush
