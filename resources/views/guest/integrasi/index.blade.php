@extends('layouts.main')

@section('title', 'Alur dan Informasi Formulir Usulan Integrasi')

@section('content')

<style>
    :root {
        --navy:    #0a0f1e;
        --navy-2:  #0f172a;
        --navy-3:  #1e2a45;
        --gold:    #c9a227;
        --gold-lt: #e8c547;
        --plat:    #d0d6e0;
        --plat-dk: #8a9ab2;
    }

    .integrasi-hero {
        position: relative;
        overflow: hidden;
    }
    
    .gold-line {
        height: 3px;
        background: linear-gradient(90deg, transparent, var(--gold), var(--gold-lt), var(--gold), transparent);
    }

    .glass-doc-card {
        background: linear-gradient(145deg, rgba(30,42,69,0.9), rgba(15,23,42,0.95));
        border: 1px solid rgba(201,162,39,0.15);
        backdrop-filter: blur(8px);
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .glass-doc-card:hover {
        border-color: rgba(201,162,39,0.5);
    }

    .step-circle {
        background: linear-gradient(135deg, var(--gold), var(--gold-lt));
        box-shadow: 0 4px 15px rgba(201,162,39,0.4);
        color: var(--navy);
        width: 40px;
        height: 40px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        border-radius: 50%;
        position: relative;
        z-index: 2;
    }

    .flow-line {
        position: relative;
    }
    .flow-line::before {
        content: '';
        position: absolute;
        left: 20px;
        top: 40px;
        bottom: 0;
        width: 2px;
        background: linear-gradient(to bottom, var(--gold), transparent);
        opacity: 0.3;
        z-index: 1;
    }
    .flow-line:last-child::before {
        display: none;
    }

    .plat-text { color: var(--plat); }
    .plat-dk-text { color: var(--plat-dk); }
</style>

{{-- HERO --}}
<div class="integrasi-hero pt-32 pb-20 px-4 sm:px-6 bg-slate-900">
    {{-- Background Blur Image --}}
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=1920&q=80')] bg-cover bg-center blur-sm opacity-30"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-[#0a0f1e]/80 via-[#0f1b35]/80 to-[#101535]/90"></div>
    </div>

    <div class="max-w-5xl mx-auto text-center relative z-10">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-yellow-600/30 bg-yellow-500/10 text-yellow-400 text-xs font-black uppercase tracking-widest mb-6">
            <i class="fas fa-file-contract text-[10px]"></i> Layanan Integrasi
        </div>
        <h1 class="text-3xl md:text-5xl font-black text-white mb-4 tracking-tight">
            Alur dan Informasi Formulir <br class="hidden sm:block"> <span class="text-yellow-500">Usulan Integrasi</span>
        </h1>
        <div class="gold-line w-48 mx-auto mb-6"></div>
        <p class="plat-text text-lg max-w-3xl mx-auto leading-relaxed opacity-90">
            Berikut adalah panduan dan alur operasional untuk Formulir Usulan Integrasi yang mencakup Remisi Reguler, Pembebasan Bersyarat, dan Cuti Bersyarat.
        </p>
    </div>
</div>

{{-- MAIN CONTENT --}}
<section class="py-20 bg-[#0a0f1e] relative overflow-hidden">
    {{-- Decoration --}}
    <div class="absolute top-0 right-0 w-96 h-96 bg-yellow-500/5 rounded-full blur-[100px]"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-500/5 rounded-full blur-[100px]"></div>

    <div class="container mx-auto px-6 max-w-6xl relative z-10">

        {{-- 1. REMISI REGULER --}}
        <div class="mb-20">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 rounded-2xl bg-yellow-500/10 border border-yellow-500/30 flex items-center justify-center text-yellow-500 text-xl shadow-lg">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h2 class="text-2xl md:text-3xl font-black text-white uppercase tracking-wider">1. Alur Pengusulan REMISI REGULER</h2>
            </div>
            
            <div class="glass-doc-card p-8 rounded-[2rem] mb-10">
                <p class="plat-text leading-relaxed text-lg mb-8">
                    Ini merupakan prosedur operasional standar dalam pengusulan remisi. Pada alur ini, tidak terdapat batasan waktu spesifik yang ditetapkan untuk proses verifikasi di tingkat pusat. Selain itu, pihak UPT dan Kanwil cukup menerima data Surat Keputusan (SK) secara digital dari pusat tanpa adanya kewajiban untuk mencetak fisik dokumen tersebut melalui sistem.
                </p>

                <div class="space-y-0">
                    {{-- Steps Remisi --}}
                    @php
                        $remisiSteps = [
                            ['label' => 'Tahap 1 (UPT)', 'text' => 'Proses dimulai di tingkat Unit Pelaksana Teknis dengan mendata narapidana yang telah memenuhi syarat. Petugas kemudian melengkapi input data dan dokumen pendukung, membuat daftar usulan untuk sidang TPP (Tim Pengamat Pemasyarakatan), melaksanakan sidang, serta melakukan kontrol dan verifikasi hasil sidang. Setelah selesai, surat pengantar diunggah dan seluruh data dikirim ke Ditjenpas dengan memberikan tembusan kepada Kanwil.'],
                            ['label' => 'Tahap 2 (KANWIL)', 'text' => 'Pihak Kantor Wilayah bertugas melakukan verifikasi usulan terhitung sejak data dan dokumen usulan diterima dari UPT.'],
                            ['label' => 'Tahap 3 (DITJENPAS)', 'text' => 'Di tingkat pusat, dilakukan verifikasi usulan secara komprehensif, pembuatan persetujuan, proses penerbitan (generate) SK Kolektif, hingga pelaksanaan penandatanganan elektronik. (Catatan: Jika terdapat kekurangan atau perlu perbaikan, berkas akan langsung dikembalikan ke UPT).'],
                            ['label' => 'Tahap 4 (UPT)', 'text' => 'UPT menerima distribusi data SK yang telah diterbitkan oleh pusat.'],
                            ['label' => 'Tahap 5 (KANWIL)', 'text' => 'Kanwil menerima tembusan pengiriman SK dari pusat sebagai bentuk pelaporan dan arsip digital.']
                        ];
                    @endphp

                    @foreach($remisiSteps as $index => $step)
                    <div class="flow-line flex gap-6">
                        <div class="step-circle">{{ $index + 1 }}</div>
                        <div class="pb-10">
                            <h4 class="text-yellow-500 font-black text-lg mb-2">{{ $step['label'] }}</h4>
                            <p class="plat-text opacity-80 leading-relaxed">{{ $step['text'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- 2. PEMBEBASAN BERSYARAT --}}
        <div class="mb-20">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 rounded-2xl bg-yellow-500/10 border border-yellow-500/30 flex items-center justify-center text-yellow-500 text-xl shadow-lg">
                    <i class="fas fa-door-open"></i>
                </div>
                <h2 class="text-2xl md:text-3xl font-black text-white uppercase tracking-wider">2. Alur Pengusulan PEMBEBASAN BERSYARAT</h2>
            </div>
            
            <div class="glass-doc-card p-8 rounded-[2rem] mb-10">
                <p class="plat-text leading-relaxed text-lg mb-8">
                    Alur ini memiliki tingkat urgensi yang lebih tinggi dibandingkan Remisi Reguler. Perbedaan paling mendasar terletak pada adanya tenggat waktu verifikasi yang ketat di Ditjenpas (maksimal 3 hari kerja). Selain itu, terdapat kewajiban pencetakan SK secara fisik pada tahap akhir oleh pihak UPT maupun Kanwil.
                </p>

                <div class="space-y-0">
                    {{-- Steps PB --}}
                    @php
                        $pbSteps = [
                            ['label' => 'Tahap 1 (UPT)', 'text' => 'Menjalankan 8 langkah proses pengajuan yang sama persis dengan tahap awal pada alur Remisi Reguler.'],
                            ['label' => 'Tahap 2 (KANWIL)', 'text' => 'Melakukan verifikasi usulan segera setelah berkas pengajuan diterima dari UPT.'],
                            ['label' => 'Tahap 3 (DITJENPAS)', 'text' => 'Melakukan verifikasi kelayakan usulan dengan batas waktu maksimal 3 hari. Setelah diverifikasi, pusat akan membuat persetujuan, men-generate SK Kolektif, dan memproses penandatanganan elektronik secara langsung oleh Direktur Jenderal (Dirjen). (Catatan: Berkas yang memerlukan perbaikan akan dikembalikan ke UPT).'],
                            ['label' => 'Tahap 4 (UPT)', 'text' => 'Menerima data persetujuan dari pusat dan diwajibkan untuk Cetak SK pada H-3 pelaksanaan.'],
                            ['label' => 'Tahap 5 (KANWIL)', 'text' => 'Menerima tembusan pengiriman dari pusat dan bertugas untuk melakukan Cetak Surat Keputusan.']
                        ];
                    @endphp

                    @foreach($pbSteps as $index => $step)
                    <div class="flow-line flex gap-6">
                        <div class="step-circle">{{ $index + 1 }}</div>
                        <div class="pb-10">
                            <h4 class="text-yellow-500 font-black text-lg mb-2">{{ $step['label'] }}</h4>
                            <p class="plat-text opacity-80 leading-relaxed">{{ $step['text'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- 3. CUTI BERSYARAT --}}
        <div class="mb-20">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 rounded-2xl bg-yellow-500/10 border border-yellow-500/30 flex items-center justify-center text-yellow-500 text-xl shadow-lg">
                    <i class="fas fa-home"></i>
                </div>
                <h2 class="text-2xl md:text-3xl font-black text-white uppercase tracking-wider">3. Alur Pengusulan CUTI BERSYARAT</h2>
            </div>
            
            <div class="glass-doc-card p-8 rounded-[2rem] mb-10">
                <p class="plat-text leading-relaxed text-lg mb-8">
                    Secara sistematis dan operasional aplikasi, tahapan pengajuan Cuti Bersyarat memiliki alur yang identik dengan Pembebasan Bersyarat, baik dalam hal kedisiplinan waktu verifikasi maupun kewajiban administratif di tahap akhir.
                </p>

                <div class="space-y-0">
                    {{-- Steps CB --}}
                    @php
                        $cbSteps = [
                            ['label' => 'Tahap 1 (UPT)', 'text' => 'Menjalankan 8 langkah proses pengajuan awal yang sama dengan alur integrasi lainnya.'],
                            ['label' => 'Tahap 2 (KANWIL)', 'text' => 'Memproses verifikasi usulan sejak data diterima dari UPT.'],
                            ['label' => 'Tahap 3 (DITJENPAS)', 'text' => 'Melakukan verifikasi usulan secara cepat dengan batas waktu maksimal 3 hari. Proses berlanjut ke pembuatan persetujuan, generate SK Kolektif, dan penandatanganan elektronik oleh Dirjen. (Catatan: Berkas yang tidak lengkap akan dikembalikan ke UPT).'],
                            ['label' => 'Tahap 4 (UPT)', 'text' => 'Menerima data dari pusat dan wajib melakukan Cetak SK pada H-3.'],
                            ['label' => 'Tahap 5 (KANWIL)', 'text' => 'Menerima tembusan pengiriman data SK dan bertugas untuk Cetak Surat Keputusan.']
                        ];
                    @endphp

                    @foreach($cbSteps as $index => $step)
                    <div class="flow-line flex gap-6">
                        <div class="step-circle">{{ $index + 1 }}</div>
                        <div class="pb-10">
                            <h4 class="text-yellow-500 font-black text-lg mb-2">{{ $step['label'] }}</h4>
                            <p class="plat-text opacity-80 leading-relaxed">{{ $step['text'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- SUMMARY COMPARISON --}}
        <div class="mb-20">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 rounded-2xl bg-blue-500/10 border border-blue-500/30 flex items-center justify-center text-blue-400 text-xl shadow-lg">
                    <i class="fas fa-list-ul"></i>
                </div>
                <h2 class="text-2xl md:text-3xl font-black text-white uppercase tracking-wider">Ringkasan Perbedaan Utama</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="glass-doc-card p-6 rounded-2xl border-l-4 border-yellow-500">
                    <h5 class="text-yellow-500 font-black mb-2 uppercase text-xs tracking-widest">Waktu Verifikasi Pusat (Ditjenpas)</h5>
                    <p class="plat-text text-sm leading-relaxed">Pengusulan Remisi Reguler tidak mencantumkan batas waktu verifikasi yang kaku. Sebaliknya, Pembebasan dan Cuti Bersyarat dibatasi dengan ketat maksimal 3 hari penyelesaian.</p>
                </div>
                <div class="glass-doc-card p-6 rounded-2xl border-l-4 border-yellow-500">
                    <h5 class="text-yellow-500 font-black mb-2 uppercase text-xs tracking-widest">Tanda Tangan Pusat</h5>
                    <p class="plat-text text-sm leading-relaxed">SK Remisi Reguler cukup menggunakan "Penandatanganan Elektronik" standar. Namun, Pembebasan dan Cuti Bersyarat mensyaratkan otoritas yang spesifik berupa "Penandatanganan Elektronik Dirjen".</p>
                </div>
                <div class="glass-doc-card p-6 rounded-2xl border-l-4 border-yellow-500">
                    <h5 class="text-yellow-500 font-black mb-2 uppercase text-xs tracking-widest">Output UPT (Tahap 4)</h5>
                    <p class="plat-text text-sm leading-relaxed">Pada Remisi Reguler, UPT hanya bertindak sebagai penerima data SK. Pada Pembebasan dan Cuti Bersyarat, UPT memiliki kewajiban administratif ekstra untuk Cetak SK pada H-3.</p>
                </div>
                <div class="glass-doc-card p-6 rounded-2xl border-l-4 border-yellow-500">
                    <h5 class="text-yellow-500 font-black mb-2 uppercase text-xs tracking-widest">Output Kanwil (Tahap 5)</h5>
                    <p class="plat-text text-sm leading-relaxed">Pada Remisi Reguler, Kanwil hanya menerima tembusan SK sebagai informasi. Sedangkan pada Pembebasan dan Cuti Bersyarat, Kanwil diwajibkan untuk turut serta mencetak Surat Keputusan.</p>
                </div>
            </div>
        </div>

        {{-- CTA WA (BOTTOM) --}}
        <div class="text-center py-10" data-aos="zoom-in">
            <h3 class="text-2xl font-black text-white mb-6">Butuh Informasi Lebih Lanjut?</h3>
            <p class="plat-text opacity-70 mb-8 max-w-xl mx-auto text-sm">Hubungi petugas kami melalui layanan bantuan WhatsApp resmi untuk tanya jawab seputar usulan integrasi.</p>
            <a href="https://wa.me/6285733333400" target="_blank" class="inline-flex items-center gap-4 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white px-10 py-5 rounded-2xl font-black text-lg transition-all shadow-xl shadow-emerald-500/20 hover:scale-105 active:scale-95 group">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-white group-hover:rotate-12 transition-transform">
                    <i class="fab fa-whatsapp text-2xl"></i>
                </div>
                Layanan Bantuan Integrasi
            </a>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 800,
            once: true,
            offset: 50
        });
    });
</script>
@endpush
