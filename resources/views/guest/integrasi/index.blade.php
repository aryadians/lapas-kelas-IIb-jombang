@extends('layouts.main')

@section('title', 'Analisis dan Prosedur Pengusulan Hak Narapidana')

@section('content')

@push('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    [x-cloak] { display: none !important; }
    .glass-card { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border: 1px solid #e2e8f0; }
    .flow-step-icon { width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 12px; font-size: 1.2rem; }
</style>
@endpush

{{-- HERO SECTION --}}
<section class="relative bg-slate-900 text-white pt-32 pb-24">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-4xl md:text-5xl font-black mb-6">Analisis dan Prosedur <br class="hidden md:block"> Pengusulan Hak Narapidana</h1>
        <p class="text-slate-400 max-w-2xl mx-auto">Sistem operasional transparan dan akuntabel melalui Sistem Database Pemasyarakatan (SDP).</p>
    </div>
</section>

<section class="py-16 bg-slate-50">
    <div class="container mx-auto px-6 max-w-6xl">
        
        <div class="prose max-w-none mb-12">
            <p class="text-lg text-slate-700 leading-relaxed">
                Sistem operasional ini dirancang untuk memastikan pemenuhan hak narapidana berjalan secara transparan dan akuntabel melalui Sistem Database Pemasyarakatan (SDP). Berikut adalah rincian mendalam untuk masing-masing jalur:
            </p>
        </div>

        {{-- 1. REMISI REGULER --}}
        <div class="mb-12 glass-card p-8 rounded-3xl" data-aos="fade-up">
            <h2 class="text-2xl font-black text-blue-900 mb-4 flex items-center gap-3">
                <i class="fas fa-calendar-alt text-blue-500"></i> 1. Alur Pengusulan Remisi Reguler
            </h2>
            <p class="mb-6 text-slate-700">Remisi merupakan hak pengurangan masa pidana yang diberikan kepada narapidana yang telah memenuhi syarat administrasi dan substansi. Alur ini bersifat lebih fleksibel dalam hal waktu verifikasi pusat karena volume pengusulannya yang biasanya bersifat massal (seperti Remisi Umum Hari Kemerdekaan atau Remisi Khusus Keagamaan).</p>
            
            <div class="grid md:grid-cols-3 gap-6">
                <div class="border-l-4 border-blue-400 pl-4">
                    <h4 class="font-bold">Tahap 1 (UPT - Inisiasi)</h4>
                    <p class="text-sm">Petugas melakukan penyaringan data narapidana berdasarkan Letter C dan masa pidana. Setelah data lengkap, dilakukan Sidang Tim Pengamat Pemasyarakatan (TPP) untuk menentukan layak atau tidaknya narapidana diusulkan. Hasil sidang kemudian diunggah bersama surat pengantar ke tingkat pusat.</p>
                </div>
                <div class="border-l-4 border-blue-400 pl-4">
                    <h4 class="font-bold">Tahap 2 (Kanwil - Monitoring) & 3 (Ditjenpas - Validasi)</h4>
                    <p class="text-sm">Kanwil berperan sebagai filter pertama. Pusat melakukan verifikasi akhir. Keunikan pada remisi adalah penggunaan SK Kolektif yang mencakup banyak nama. Jika ditemukan ketidaksesuaian data (seperti remisi tahun sebelumnya yang belum terinput), berkas dikembalikan ke UPT.</p>
                </div>
                <div class="border-l-4 border-blue-400 pl-4">
                    <h4 class="font-bold">Tahap 4 & 5 (Output)</h4>
                    <p class="text-sm">Karena sifatnya kolektif dan massal, sistem tidak mewajibkan pencetakan SK secara mandiri oleh UPT/Kanwil sebagai syarat eksekusi segera, melainkan cukup sebagai basis data perubahan masa pidana di sistem.</p>
                </div>
            </div>
        </div>

        {{-- 2. PB & 3. CB --}}
        <div class="grid md:grid-cols-2 gap-8 mb-12">
            <div class="glass-card p-8 rounded-3xl" data-aos="fade-right">
                <h2 class="text-2xl font-black text-amber-900 mb-4 flex items-center gap-3">
                    <i class="fas fa-door-open text-amber-500"></i> 2. Alur Pengusulan Pembebasan Bersyarat (PB)
                </h2>
                <p class="text-slate-700 mb-4">Pembebasan Bersyarat adalah proses pengintegrasian narapidana kembali ke masyarakat setelah menjalani minimal 2/3 masa pidana. Alurnya memiliki standar waktu yang ketat (SLA).</p>
                <ul class="list-disc pl-5 space-y-2 text-sm text-slate-600">
                    <li><strong>Tahap 1 (UPT):</strong> Selain 8 langkah administrasi standar, UPT harus memastikan adanya Litmas dari Bapas dan jaminan keluarga.</li>
                    <li><strong>Tahap 2 (Kanwil):</strong> Pemeriksaan ketat dokumen jaminan dan hasil sidang TPP wilayah.</li>
                    <li><strong>Tahap 3 (Ditjenpas):</strong> Verifikasi Maksimal 3 Hari. SK ditandatangani Dirjen.</li>
                    <li><strong>Tahap 4 & 5:</strong> UPT wajib Cetak SK H-3. Kanwil wajib cetak salinan resmi.</li>
                </ul>
            </div>
            <div class="glass-card p-8 rounded-3xl" data-aos="fade-left">
                <h2 class="text-2xl font-black text-indigo-900 mb-4 flex items-center gap-3">
                    <i class="fas fa-home text-indigo-500"></i> 3. Alur Pengusulan Cuti Bersyarat (CB)
                </h2>
                <p class="text-slate-700 mb-4">Cuti Bersyarat diberikan kepada narapidana dengan masa pidana pendek (di bawah 1 tahun 6 bulan). Secara sistemik, prosedur CB mengadopsi ketatnya jalur PB.</p>
                <p class="text-sm text-slate-600 mb-4"><strong>Deskripsi Operasional:</strong> Sama seperti PB, alur CB mengedepankan kecepatan. Batas waktu 3 hari di pusat menjadi krusial karena selisih waktu yang sempit antara tanggal pengusulan dan tanggal jatuh tempo bebas.</p>
                <div class="p-4 bg-indigo-50 rounded-xl text-sm italic font-medium text-indigo-900">
                    <strong>Kewajiban Cetak:</strong> Tidak hanya menerima data digital, UPT dan Kanwil wajib memproduksi dokumen fisik (SK) sebagai bukti sah saat narapidana melapor ke Kejaksaan dan Bapas.
                </div>
            </div>
        </div>

        {{-- TABLE PERBANDINGAN --}}
        <div class="bg-white rounded-3xl shadow p-8 border border-slate-200">
            <h3 class="text-xl font-black mb-6 text-center">Ringkasan Perbandingan Strategis</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-100 text-slate-600 uppercase font-bold">
                        <tr>
                            <th class="p-4">Dimensi</th>
                            <th class="p-4">Remisi Reguler</th>
                            <th class="p-4">PB & CB</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr><td class="p-4 font-bold">Urgensi Waktu</td><td class="p-4">Standar (Periodik)</td><td class="p-4">Sangat Tinggi (Max 3 Hari)</td></tr>
                        <tr><td class="p-4 font-bold">Otoritas</td><td class="p-4">Pejabat Ditjenpas</td><td class="p-4">Dirjen (DIRJEN)</td></tr>
                        <tr><td class="p-4 font-bold">Cetak SK</td><td class="p-4">Tidak Wajib</td><td class="p-4">Wajib</td></tr>
                        <tr><td class="p-4 font-bold">Tujuan</td><td class="p-4">Pengurangan hukuman</td><td class="p-4">Integrasi ke Masyarakat</td></tr>
                    </tbody>
                </table>
            </div>
            <p class="mt-6 text-sm text-slate-500 italic text-center">"Kesimpulan: Remisi bersifat administratif, PB/CB bersifat eksekutif-operasional sebagai instrumen pengeluaran narapidana."</p>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init();</script>
@endpush
