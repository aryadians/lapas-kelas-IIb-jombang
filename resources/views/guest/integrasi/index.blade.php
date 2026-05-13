@extends('layouts.main')

@section('title', 'Alur & Usulan Integrasi')

@section('content')

@push('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    [x-cloak] { display: none !important; }
    .flow-step-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
        flex: 1;
        position: relative;
    }
    .step-icon-box {
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        border: 3px solid #e2e8f0;
        border-radius: 20px;
        font-size: 1.8rem;
        transition: all 0.3s ease;
        position: relative;
        z-index: 2;
    }
    .flow-step-wrapper:not(:last-child)::after {
        content: "\f061";
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        position: absolute;
        top: 30px;
        right: -15px;
        color: #cbd5e1;
        font-size: 1.2rem;
    }
    @media (max-width: 768px) {
        .flow-step-wrapper:not(:last-child)::after {
            content: "\f063";
            right: auto;
            top: 80px;
            left: 50%;
        }
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
<section class="py-16 bg-white" x-data="{ tab: 'remisi' }">
    <div class="container mx-auto px-6 max-w-6xl">
        <div class="flex flex-wrap justify-center gap-3 mb-16">
            <button @click="tab = 'remisi'" :class="tab === 'remisi' ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'bg-slate-100 text-slate-600'" class="px-8 py-3 rounded-full font-bold transition">Remisi Reguler</button>
            <button @click="tab = 'pb'" :class="tab === 'pb' ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'bg-slate-100 text-slate-600'" class="px-8 py-3 rounded-full font-bold transition">Pembebasan Bersyarat</button>
            <button @click="tab = 'cb'" :class="tab === 'cb' ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'bg-slate-100 text-slate-600'" class="px-8 py-3 rounded-full font-bold transition">Cuti Bersyarat</button>
        </div>

        {{-- Alur Remisi --}}
        <div x-show="tab === 'remisi'" x-cloak class="space-y-16">
            <h3 class="text-2xl font-black text-slate-800 text-center uppercase tracking-widest">Alur Remisi Reguler</h3>
            
            <div class="flex flex-col md:flex-row gap-8 justify-center items-center">
                <div class="flow-step-wrapper"><div class="step-icon-box text-blue-500 border-blue-500"><i class="fas fa-building"></i></div><p class="font-bold text-slate-700">UPT<br><span class="text-[11px] font-normal">Pendataan</span></p></div>
                <div class="flow-step-wrapper"><div class="step-icon-box text-blue-500 border-blue-500"><i class="fas fa-landmark"></i></div><p class="font-bold text-slate-700">KANWIL<br><span class="text-[11px] font-normal">Verifikasi</span></p></div>
                <div class="flow-step-wrapper"><div class="step-icon-box text-blue-500 border-blue-500"><i class="fas fa-server"></i></div><p class="font-bold text-slate-700">DITJENPAS<br><span class="text-[11px] font-normal">SK Kolektif</span></p></div>
            </div>
            
            <div class="flex flex-col md:flex-row gap-8 justify-center items-center">
                <div class="flow-step-wrapper"><div class="step-icon-box text-emerald-600 border-emerald-600"><i class="fas fa-file-alt"></i></div><p class="font-bold text-slate-700">UPT<br><span class="text-[11px] font-normal">Terima Data</span></p></div>
                <div class="flow-step-wrapper"><div class="step-icon-box text-emerald-600 border-emerald-600"><i class="fas fa-file-check"></i></div><p class="font-bold text-slate-700">KANWIL<br><span class="text-[11px] font-normal">Tembusan</span></p></div>
            </div>
        </div>

        {{-- Alur PB/CB --}}
        <div x-show="tab === 'pb' || tab === 'cb'" x-cloak class="space-y-16">
            <h3 class="text-2xl font-black text-slate-800 text-center uppercase tracking-widest" x-text="tab === 'pb' ? 'Alur Pembebasan Bersyarat (PB)' : 'Alur Cuti Bersyarat (CB)'"></h3>
            
            <div class="bg-amber-50 p-6 rounded-2xl text-center border-2 border-amber-200">
                <p class="font-bold text-amber-800"><i class="fas fa-exclamation-triangle mr-2"></i> Verifikasi Ditjenpas Max 3 Hari | Wajib Cetak SK H-3 (UPT) & SK (Kanwil)</p>
            </div>

            <div class="flex flex-col md:flex-row gap-8 justify-center items-center">
                <div class="flow-step-wrapper"><div class="step-icon-box text-blue-500 border-blue-500"><i class="fas fa-building"></i></div><p class="font-bold text-slate-700">UPT<br><span class="text-[11px] font-normal">Pendataan</span></p></div>
                <div class="flow-step-wrapper"><div class="step-icon-box text-blue-500 border-blue-500"><i class="fas fa-landmark"></i></div><p class="font-bold text-slate-700">KANWIL<br><span class="text-[11px] font-normal">Verifikasi</span></p></div>
                <div class="flow-step-wrapper"><div class="step-icon-box text-blue-500 border-blue-500"><i class="fas fa-user-tie"></i></div><p class="font-bold text-slate-700">DITJENPAS<br><span class="text-[11px] font-normal">Dirjen Sign</span></p></div>
            </div>
            
            <div class="flex flex-col md:flex-row gap-8 justify-center items-center">
                <div class="flow-step-wrapper"><div class="step-icon-box text-red-600 border-red-600"><i class="fas fa-print"></i></div><p class="font-bold text-slate-700">UPT<br><span class="text-[11px] font-normal">Cetak SK H-3</span></p></div>
                <div class="flow-step-wrapper"><div class="step-icon-box text-red-600 border-red-600"><i class="fas fa-print"></i></div><p class="font-bold text-slate-700">KANWIL<br><span class="text-[11px] font-normal">Cetak SK</span></p></div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init();</script>
@endpush
