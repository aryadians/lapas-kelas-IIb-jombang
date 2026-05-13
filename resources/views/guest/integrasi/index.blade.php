@extends('layouts.main')

@section('title', 'Alur dan Informasi Formulir Usulan Integrasi')

@section('content')

@push('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    [x-cloak] { display: none !important; }
    .glass-card { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border: 1px solid #e2e8f0; }
</style>
@endpush

{{-- HERO SECTION --}}
<section class="relative bg-slate-900 text-white pt-32 pb-24">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-4xl md:text-5xl font-black mb-6">Alur dan Informasi Formulir<br class="hidden md:block"> Usulan Integrasi</h1>
        <p class="text-slate-400 max-w-2xl mx-auto">Panduan operasional untuk Remisi Reguler, Pembebasan Bersyarat, dan Cuti Bersyarat.</p>
    </div>
</section>

<section class="py-16 bg-slate-50" x-data="{ tab: 'remisi' }">
    <div class="container mx-auto px-6 max-w-6xl">
        
        {{-- CTA WA --}}
        <div class="bg-gradient-to-r from-emerald-600 to-teal-700 rounded-3xl p-8 mb-16 text-white text-center shadow-lg" data-aos="fade-up">
            <h3 class="text-2xl font-black mb-4">Butuh Tanya Jawab Seputar Integrasi?</h3>
            <p class="text-emerald-100 mb-6 max-w-xl mx-auto">Kami siap membantu Anda. Klik tombol di bawah ini untuk terhubung langsung dengan admin layanan integrasi melalui WhatsApp.</p>
            <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center gap-3 bg-white text-emerald-700 px-8 py-4 rounded-full font-black text-lg hover:bg-emerald-50 transition-all shadow-xl hover:scale-105">
                <i class="fab fa-whatsapp text-2xl"></i> Chat Layanan Integrasi
            </a>
        </div>

        <div class="prose max-w-none mb-12">
            <p class="text-lg text-slate-700 leading-relaxed">
                Berikut adalah panduan dan alur operasional untuk Formulir Usulan Integrasi yang mencakup Remisi Reguler, Pembebasan Bersyarat, dan Cuti Bersyarat.
            </p>
        </div>

        {{-- TABS NAVIGATION --}}
        <div class="flex flex-wrap justify-center gap-3 mb-12">
            <button @click="tab = 'remisi'" :class="tab === 'remisi' ? 'bg-blue-600 text-white' : 'bg-white text-slate-600'" class="px-6 py-3 rounded-full font-bold shadow transition border">1. Remisi Reguler</button>
            <button @click="tab = 'pb'" :class="tab === 'pb' ? 'bg-blue-600 text-white' : 'bg-white text-slate-600'" class="px-6 py-3 rounded-full font-bold shadow transition border">2. Pembebasan Bersyarat</button>
            <button @click="tab = 'cb'" :class="tab === 'cb' ? 'bg-blue-600 text-white' : 'bg-white text-slate-600'" class="px-6 py-3 rounded-full font-bold shadow transition border">3. Cuti Bersyarat</button>
        </div>

        {{-- TAB CONTENTS --}}
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-200">
            
            {{-- REMISI --}}
            <div x-show="tab === 'remisi'" x-cloak>
                <h2 class="text-2xl font-black text-blue-900 mb-6 flex items-center gap-3"><i class="fas fa-calendar-alt"></i> 1. Alur Pengusulan Remisi Reguler</h2>
                <p class="mb-6 text-slate-700 leading-relaxed">Ini merupakan prosedur operasional standar dalam pengusulan remisi. Pada alur ini, tidak terdapat batasan waktu spesifik yang ditetapkan untuk proses verifikasi di tingkat pusat. Selain itu, pihak UPT dan Kanwil cukup menerima data Surat Keputusan (SK) secara digital dari pusat tanpa adanya kewajiban untuk mencetak fisik dokumen tersebut melalui sistem.</p>
                
                <div class="space-y-4 text-sm">
                    <p><strong>Tahap 1 (UPT):</strong> Proses dimulai di tingkat Unit Pelaksana Teknis dengan mendata narapidana yang telah memenuhi syarat. Petugas kemudian melengkapi input data dan dokumen pendukung, membuat daftar usulan untuk sidang TPP (Tim Pengamat Pemasyarakatan), melaksanakan sidang, serta melakukan kontrol dan verifikasi hasil sidang. Setelah selesai, surat pengantar diunggah dan seluruh data dikirim ke Ditjenpas dengan memberikan tembusan kepada Kanwil.</p>
                    <p><strong>Tahap 2 (KANWIL):</strong> Pihak Kantor Wilayah bertugas melakukan verifikasi usulan terhitung sejak data dan dokumen usulan diterima dari UPT.</p>
                    <p><strong>Tahap 3 (DITJENPAS):</strong> Di tingkat pusat, dilakukan verifikasi usulan secara komprehensif, pembuatan persetujuan, proses penerbitan (generate) SK Kolektif, hingga pelaksanaan penandatanganan elektronik. (Catatan: Jika terdapat kekurangan atau perlu perbaikan, berkas akan langsung dikembalikan ke UPT).</p>
                    <p><strong>Tahap 4 (UPT):</strong> UPT menerima distribusi data SK yang telah diterbitkan oleh pusat.</p>
                    <p><strong>Tahap 5 (KANWIL):</strong> Kanwil menerima tembusan pengiriman SK dari pusat sebagai bentuk pelaporan dan arsip digital.</p>
                </div>
            </div>

            {{-- PB --}}
            <div x-show="tab === 'pb'" x-cloak>
                <h2 class="text-2xl font-black text-amber-900 mb-6 flex items-center gap-3"><i class="fas fa-door-open"></i> 2. Alur Pengusulan Pembebasan Bersyarat (PB)</h2>
                <p class="mb-6 text-slate-700 leading-relaxed">Alur ini memiliki tingkat urgensi yang lebih tinggi dibandingkan Remisi Reguler. Perbedaan paling mendasar terletak pada adanya tenggat waktu verifikasi yang ketat di Ditjenpas (maksimal 3 hari kerja). Selain itu, terdapat kewajiban pencetakan SK secara fisik pada tahap akhir oleh pihak UPT maupun Kanwil.</p>
                
                <div class="space-y-4 text-sm">
                    <p><strong>Tahap 1 (UPT):</strong> Menjalankan 8 langkah proses pengajuan yang sama persis dengan tahap awal pada alur Remisi Reguler.</p>
                    <p><strong>Tahap 2 (KANWIL):</strong> Melakukan verifikasi usulan segera setelah berkas pengajuan diterima dari UPT.</p>
                    <p><strong>Tahap 3 (DITJENPAS):</strong> Melakukan verifikasi kelayakan usulan dengan batas waktu maksimal 3 hari. Setelah diverifikasi, pusat akan membuat persetujuan, men-generate SK Kolektif, dan memproses penandatanganan elektronik secara langsung oleh Direktur Jenderal (Dirjen). (Catatan: Berkas yang memerlukan perbaikan akan dikembalikan ke UPT).</p>
                    <p><strong>Tahap 4 (UPT):</strong> Menerima data persetujuan dari pusat dan diwajibkan untuk Cetak SK pada H-3 pelaksanaan.</p>
                    <p><strong>Tahap 5 (KANWIL):</strong> Menerima tembusan pengiriman dari pusat dan bertugas untuk melakukan Cetak Surat Keputusan.</p>
                </div>
            </div>

            {{-- CB --}}
            <div x-show="tab === 'cb'" x-cloak>
                <h2 class="text-2xl font-black text-indigo-900 mb-6 flex items-center gap-3"><i class="fas fa-home"></i> 3. Alur Pengusulan Cuti Bersyarat (CB)</h2>
                <p class="mb-6 text-slate-700 leading-relaxed">Secara sistematis dan operasional aplikasi, tahapan pengajuan Cuti Bersyarat memiliki alur yang identik dengan Pembebasan Bersyarat, baik dalam hal kedisiplinan waktu verifikasi maupun kewajiban administratif di tahap akhir.</p>
                
                <div class="space-y-4 text-sm">
                    <p><strong>Tahap 1 (UPT):</strong> Menjalankan 8 langkah proses pengajuan awal yang sama dengan alur integrasi lainnya.</p>
                    <p><strong>Tahap 2 (KANWIL):</strong> Memproses verifikasi usulan sejak data diterima dari UPT.</p>
                    <p><strong>Tahap 3 (DITJENPAS):</strong> Melakukan verifikasi usulan secara cepat dengan batas waktu maksimal 3 hari. Proses berlanjut ke pembuatan persetujuan, generate SK Kolektif, dan penandatanganan elektronik oleh Dirjen. (Catatan: Berkas yang tidak lengkap akan dikembalikan ke UPT).</p>
                    <p><strong>Tahap 4 (UPT):</strong> Menerima data dari pusat dan wajib melakukan Cetak SK pada H-3.</p>
                    <p><strong>Tahap 5 (KANWIL):</strong> Menerima tembusan pengiriman data SK dan bertugas untuk Cetak Surat Keputusan.</p>
                </div>
            </div>
        </div>

        {{-- RINGKASAN PERBANDINGAN --}}
        <div class="mt-12 bg-slate-900 text-white p-8 rounded-3xl shadow-xl">
            <h3 class="text-xl font-black mb-6">Ringkasan Perbedaan Utama:</h3>
            <div class="space-y-4 text-sm text-slate-300">
                <p>• <strong>Waktu Verifikasi Pusat (Ditjenpas):</strong> Pengusulan Remisi Reguler tidak mencantumkan batas waktu verifikasi yang kaku. Sebaliknya, Pembebasan dan Cuti Bersyarat dibatasi dengan ketat maksimal 3 hari penyelesaian.</p>
                <p>• <strong>Tanda Tangan Pusat:</strong> SK Remisi Reguler cukup menggunakan "Penandatanganan Elektronik" standar. Namun, Pembebasan dan Cuti Bersyarat mensyaratkan otoritas yang spesifik berupa "Penandatanganan Elektronik Dirjen".</p>
                <p>• <strong>Output UPT (Tahap 4):</strong> Pada Remisi Reguler, UPT hanya bertindak sebagai penerima data SK. Pada Pembebasan dan Cuti Bersyarat, UPT memiliki kewajiban administratif ekstra untuk Cetak SK pada H-3.</p>
                <p>• <strong>Output Kanwil (Tahap 5):</strong> Pada Remisi Reguler, Kanwil hanya menerima tembusan SK sebagai informasi. Sedangkan pada Pembebasan dan Cuti Bersyarat, Kanwil diwajibkan untuk turut serta mencetak Surat Keputusan.</p>
            </div>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init();</script>
@endpush
