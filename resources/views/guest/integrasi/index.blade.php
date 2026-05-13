@extends('layouts.main')

@section('title', 'Alur dan Informasi Formulir Usulan Integrasi')

@section('content')

@push('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    [x-cloak] { display: none !important; }
    .card-3d { background: white; border-radius: 2rem; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); transition: transform 0.3s; }
    .step-box { background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 1rem; padding: 1.5rem; text-align: center; }
    .arrow-down { font-size: 2rem; color: #cbd5e1; text-align: center; margin: 10px 0; }
</style>
@endpush

<section class="relative bg-gradient-to-br from-slate-900 via-blue-900 to-indigo-950 text-white pt-32 pb-24">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-4xl md:text-5xl font-black mb-6">Alur & Informasi Formulir Usulan Integrasi</h1>
        <p class="text-blue-200 max-w-2xl mx-auto">Panduan operasional untuk Remisi Reguler, PB, dan CB.</p>
    </div>
</section>

<section class="py-16 bg-slate-50" x-data="{ tab: 'remisi' }">
    <div class="container mx-auto px-6 max-w-6xl">
        <div class="flex flex-wrap justify-center gap-3 mb-16">
            <button @click="tab = 'remisi'" :class="tab === 'remisi' ? 'bg-blue-600 text-white shadow-xl' : 'bg-white text-slate-600 border'" class="px-8 py-4 rounded-full font-black transition">Remisi Reguler</button>
            <button @click="tab = 'pb'" :class="tab === 'pb' ? 'bg-amber-600 text-white shadow-xl' : 'bg-white text-slate-600 border'" class="px-8 py-4 rounded-full font-black transition">Pembebasan Bersyarat</button>
            <button @click="tab = 'cb'" :class="tab === 'cb' ? 'bg-indigo-600 text-white shadow-xl' : 'bg-white text-slate-600 border'" class="px-8 py-4 rounded-full font-black transition">Cuti Bersyarat</button>
        </div>

        <div class="card-3d p-8 md:p-12 mb-16" data-aos="fade-up">
            <h4 class="text-2xl font-black text-slate-800 mb-8 flex items-center gap-3">
                <i class="fas fa-layer-group text-blue-500"></i> Proses Pengajuan (8 Langkah UPT)
            </h4>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach(['Pendataan Napi', 'Input data & Dokumen', 'Sidang TPP', 'Pelaksanaan Sidang', 'Kontrol Sidang', 'Verifikasi Sidang', 'Upload Surat Pengantar', 'Kirim ke Ditjenpas'] as $index => $step)
                <div class="step-box hover:border-blue-500 transition-colors">
                    <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-black mb-3 mx-auto">{{ $index + 1 }}</div>
                    <p class="text-xs font-bold text-slate-700">{{ $step }}</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Dynamic Tab Content --}}
        <div class="space-y-8">
            <div x-show="tab === 'remisi'" class="card-3d p-10 border-l-8 border-blue-600">
                <h2 class="text-2xl font-black text-blue-900 mb-6 flex items-center gap-3"><i class="fas fa-calendar-alt"></i> 1. Alur Remisi Reguler</h2>
                <div class="text-slate-700 space-y-4">
                    <p>Remisi merupakan hak pengurangan masa pidana... (teks lengkap user)...</p>
                    <div class="flex flex-col gap-2 font-bold">
                        <div>Tahap 1 (UPT): <span class="font-normal">8 Langkah UPT.</span></div>
                        <div>Tahap 2 (KANWIL): <span class="font-normal">Verifikasi usulan.</span></div>
                        <div>Tahap 3 (DITJENPAS): <span class="font-normal">Verifikasi, Generate SK Kolektif, Tanda Tangan Elektronik.</span></div>
                        <div>Tahap 4 (UPT): <span class="font-normal">Menerima data SK (Tanpa Cetak).</span></div>
                        <div>Tahap 5 (KANWIL): <span class="font-normal">Menerima tembusan SK.</span></div>
                    </div>
                </div>
            </div>
            {{-- PB & CB --}}
            <div x-show="tab === 'pb' || tab === 'cb'" class="card-3d p-10 border-l-8 border-amber-600">
                <h2 class="text-2xl font-black text-amber-900 mb-6 flex items-center gap-3" x-text="tab === 'pb' ? '2. Pembebasan Bersyarat (PB)' : '3. Cuti Bersyarat (CB)'"></h2>
                <div class="bg-amber-50 p-6 rounded-2xl border-l-4 border-amber-400 mb-6 text-amber-900 font-black">
                    <i class="fas fa-exclamation-triangle mr-2"></i> Perbedaan: Verifikasi Ditjenpas Max 3 Hari, Tanda Tangan DIRJEN, UPT Cetak SK H-3, Kanwil Cetak SK.
                </div>
                <div class="text-slate-700 space-y-4">
                    <div class="flex flex-col gap-2 font-bold">
                        <div>Tahap 1 (UPT): <span class="font-normal">8 Langkah UPT.</span></div>
                        <div>Tahap 2 (KANWIL): <span class="font-normal">Verifikasi usulan.</span></div>
                        <div>Tahap 3 (DITJENPAS): <span class="font-normal">Verifikasi (Max 3 hari), Dirjen Sign.</span></div>
                        <div>Tahap 4 (UPT): <span class="font-normal">Menerima data & CETAK SK H-3.</span></div>
                        <div>Tahap 5 (KANWIL): <span class="font-normal">Menerima tembusan & CETAK SURAT KEPUTUSAN.</span></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CTA BOTTOM --}}
        <div class="text-center mt-20" data-aos="fade-up">
            <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center gap-4 bg-emerald-600 text-white px-10 py-5 rounded-full font-black text-lg hover:bg-emerald-700 transition shadow-2xl hover:scale-105">
                <i class="fab fa-whatsapp text-3xl"></i> Tanya Jawab Integrasi
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init();</script>
@endpush
