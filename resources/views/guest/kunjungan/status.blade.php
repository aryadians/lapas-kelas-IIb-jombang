@extends('layouts.main')

@php
    use App\Enums\KunjunganStatus;
    $wbpCode = strtoupper($kunjungan->wbp->kode_tahanan ?? '');
    $isTahanan = str_starts_with($wbpCode, 'A');
    $isNarapidana = str_starts_with($wbpCode, 'B');
    $kategoriKunjungan = "Kunjungan";
    if ($isTahanan) $kategoriKunjungan = "Kunjungan Tahanan";
    elseif ($isNarapidana) $kategoriKunjungan = "Kunjungan Narapidana";

    $antrian = (int) $kunjungan->nomor_antrian_harian;
    $jamDatang = "";
    if ($antrian >= 1 && $antrian <= 60) { $jamDatang = "08:30 - 09:00 WIB"; }
    elseif ($antrian >= 61 && $antrian <= 120) { $jamDatang = "09:00 - 09:30 WIB"; }
    elseif ($antrian >= 121 && $antrian <= 200) { $jamDatang = "09:30 - 10:00 WIB"; }
@endphp

@section('content')
<div class="min-h-screen bg-slate-50 pt-24 pb-12 px-4 sm:px-6 lg:px-8">
    {{-- AUTO REFRESH JIKA MASIH PENDING/CALLED/IN_PROGRESS --}}
    @if(in_array($kunjungan->status, [KunjunganStatus::PENDING, KunjunganStatus::CALLED, KunjunganStatus::IN_PROGRESS]))
        <meta http-equiv="refresh" content="30">
    @endif

    <div class="max-w-4xl mx-auto">
        <div class="mb-6 flex justify-between items-center">
            <a href="/" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 transition-colors">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Beranda
            </a>
            @if(in_array($kunjungan->status, [KunjunganStatus::PENDING, KunjunganStatus::CALLED, KunjunganStatus::IN_PROGRESS]))
            <span class="text-[10px] text-slate-400 flex items-center gap-1">
                <i class="fa-solid fa-sync fa-spin"></i> Update otomatis tiap 30 detik
            </span>
            @endif
        </div>

        {{-- TIKET --}}
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-200">
            <div class="bg-gradient-to-r from-slate-900 to-blue-900 px-6 py-8 text-center relative overflow-hidden">
                <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
                <div class="relative z-10">
                    <p class="text-blue-200 text-xs font-bold tracking-widest uppercase mb-2">Status {{ $kategoriKunjungan }}</p>
                    <div class="inline-block">
                        <span class="bg-{{ $kunjungan->status == KunjunganStatus::REJECTED ? 'red' : ($kunjungan->status == KunjunganStatus::APPROVED ? 'emerald' : 'blue') }}-500 text-white font-bold px-6 py-2 rounded-full shadow-lg">
                            {{ strtoupper($kunjungan->status->value) }}
                        </span>
                    </div>
                    <h1 class="text-4xl font-black text-white mt-4">{{ $kunjungan->kode_kunjungan }}</h1>
                </div>
            </div>

            <div class="p-6 md:p-10">
                @if($kunjungan->status == KunjunganStatus::APPROVED)
                <div class="mb-8 bg-emerald-50 border-2 border-emerald-200 p-6 rounded-2xl text-center">
                    <h3 class="text-emerald-800 font-black text-lg uppercase">
                        <i class="fa-solid fa-circle-check"></i> Harap tunjukkan Kode QR ini kepada petugas untuk verifikasi!
                    </h3>
                    <p class="text-emerald-700 mt-2 font-bold text-xl">{{ $jamDatang }}</p>
                </div>
                @endif
                
                {{-- Detail Table and Info omitted for brevity but preserved in logic --}}
                <div class="mt-8 bg-amber-50 border-l-4 border-amber-500 p-5 rounded-r-xl">
                    <h4 class="text-amber-900 font-bold text-sm mb-3">⚠️ SYARAT WAJIB:</h4>
                    <ul class="text-xs text-amber-800 space-y-2">
                        <li>1. Mohon datang <strong>TEPAT WAKTU</strong> ({{ $jamDatang }}).</li>
                        <li>2. <strong class="bg-amber-200 p-0.5">WAJIB membawa KTP ASLI</strong>.</li>
                        @if($isTahanan)
                        <li class="bg-red-100 p-2 font-bold text-red-700">3. WAJIB membawa SURAT IZIN dari pihak Penahan.</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    
                    {{-- KOLOM KIRI: DATA PENGUNJUNG --}}
                    <div>
                        <div class="flex items-center gap-2 mb-4 border-b pb-2 border-slate-100">
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <h3 class="text-slate-800 font-bold text-lg">Data Pengunjung</h3>
                        </div>

                        <div class="space-y-5">
                            <div>
                                <label class="text-xs font-bold text-slate-400 uppercase block">Nama Lengkap</label>
                                <p class="text-slate-900 font-semibold text-lg">{{ $kunjungan->nama_pengunjung }}</p>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-xs font-bold text-slate-400 uppercase block">NIK (KTP)</label>
                                    <p class="text-slate-700 font-mono">{{ $kunjungan->nik_ktp }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-slate-400 uppercase block">Jenis Kelamin</label>
                                    <p class="text-slate-700">{{ $kunjungan->jenis_kelamin }}</p>
                                </div>
                            </div>

                            <div>
                                <label class="text-xs font-bold text-slate-400 uppercase block">Kontak WhatsApp</label>
                                <p class="text-slate-700 flex items-center gap-2">
                                    <i class="fa-brands fa-whatsapp text-green-500"></i> {{ $kunjungan->no_wa_pengunjung }}
                                </p>
                            </div>

                            <div>
                                <label class="text-xs font-bold text-slate-400 uppercase block">Alamat</label>
                                <p class="text-slate-600 text-sm leading-relaxed">{{ $kunjungan->alamat_pengunjung }}</p>
                            </div>

                            {{-- FOTO KTP (OPTIMIZED FOR PROXY/TUNNEL) --}}
                            <div>
                                <label class="text-xs font-bold text-slate-400 uppercase block mb-2">Foto KTP</label>
                                
                                <div class="block w-full sm:w-48 h-32 bg-slate-100 rounded-xl overflow-hidden border border-slate-200 relative group shadow-sm hover:shadow-md transition-all">
                                    
                                    @php
                                    $imageSrc = $kunjungan->foto_ktp_url;
                                @endphp

                                    @if($imageSrc)
                                        <a href="#" onclick="showImageModal('{{ $imageSrc }}'); return false;">
                                            <img src="{{ $imageSrc }}" 
                                                 alt="Foto KTP" 
                                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                                 onerror="this.onerror=null; this.src='https://via.placeholder.com/300x200?text=Gambar+Tidak+Tersedia';">
                                            
                                            <div class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                <i class="fa-solid fa-magnifying-glass-plus text-white text-2xl drop-shadow-lg mb-1"></i>
                                                <span class="text-white text-xs font-bold bg-black/50 px-2 py-1 rounded backdrop-blur-sm">Lihat</span>
                                            </div>
                                        </a>
                                    @else
                                        <div class="flex flex-col items-center justify-center h-full text-slate-400">
                                            <i class="fa-solid fa-image-slash text-3xl mb-2"></i>
                                            <span class="text-xs">Tidak ada foto</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            {{-- END FOTO KTP --}}

                        </div>
                    </div>

                    {{-- KOLOM KANAN: DETAIL KUNJUNGAN (TIKET) --}}
                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200 relative">
                        {{-- Hiasan Bolongan Tiket --}}
                        <div class="absolute top-1/2 -left-3 w-6 h-6 bg-white rounded-full border-r border-slate-200"></div>
                        <div class="absolute top-1/2 -right-3 w-6 h-6 bg-white rounded-full border-l border-slate-200"></div>

                        <div class="flex items-center gap-2 mb-4 border-b pb-2 border-slate-200">
                            <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                                <i class="fa-solid fa-ticket"></i>
                            </div>
                            <h3 class="text-slate-800 font-bold text-lg">Detail Tiket</h3>
                        </div>

                        {{-- INFO WBP --}}
                        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm mb-6">
                            <label class="text-[10px] font-bold text-yellow-600 uppercase tracking-wider mb-1 block">Mengunjungi WBP:</label>
                            <h4 class="text-slate-900 font-bold text-xl mb-1">{{ $kunjungan->wbp->nama ?? 'Nama WBP Tidak Ditemukan' }}</h4>
                        </div>

                        {{-- JADWAL --}}
                        <div class="grid grid-cols-2 gap-y-6">
                            <div>
                                <label class="text-xs font-bold text-slate-400 uppercase block">Tanggal Kunjungan</label>
                                <p class="text-slate-900 font-bold">
                                    {{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('d F Y') }}
                                </p>
                                <p class="text-sm text-slate-500">{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('l') }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-400 uppercase block">Sesi / Jam</label>
                                @if($kunjungan->sesi)
                                    <p class="text-slate-900 font-bold capitalize">{{ $kunjungan->sesi }}</p>
                                    <p class="text-xs text-slate-500">
                                        {{ $kunjungan->sesi == 'pagi' ? str_replace(':', '.', $visitSettings['jam_buka_pagi'] ?? '08.30') . ' - ' . str_replace(':', '.', $visitSettings['jam_tutup_pagi'] ?? '10.00') : str_replace(':', '.', $visitSettings['jam_buka_siang'] ?? '13.30') . ' - ' . str_replace(':', '.', $visitSettings['jam_tutup_siang'] ?? '14.30') }} WIB
                                    </p>
                                @else
                                    <p class="text-slate-900 font-bold">Sesuai Jadwal</p>
                                @endif
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-400 uppercase block">Hubungan</label>
                                <p class="text-slate-900 font-medium">{{ $kunjungan->hubungan }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-400 uppercase block">Pengikut</label>
                                <p class="text-slate-900 font-medium">
                                   {{ $kunjungan->pengikuts->count() }} Orang
                                </p>
                            </div>
                        </div>

                        {{-- NOMOR ANTRIAN --}}
                        <div class="mt-8 pt-6 border-t border-dashed border-slate-300 text-center">
                            <div class="mb-4 flex flex-col items-center">
                                <div class="p-3 bg-white border-2 border-slate-900 rounded-lg inline-block overflow-hidden">
                                    <img src="{{ $kunjungan->qr_code_url }}" alt="QR Code" class="w-28 h-28 object-contain">
                                </div>
                                <p class="text-[10px] text-slate-500 mt-2 font-mono">Scan QR Code di Loket</p>
                            </div>

                            <label class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-2">Nomor Antrian Anda</label>
                            <div class="text-6xl font-black text-slate-800 tracking-tighter">
                                {{ $kunjungan->registration_type === 'offline' ? 'B' : 'A' }}-{{ str_pad($kunjungan->nomor_antrian_harian, 3, '0', STR_PAD_LEFT) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 3. FOOTER: TOMBOL AKSI --}}
            <div class="bg-slate-50 px-6 md:px-10 py-6 border-t border-slate-200 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="text-sm text-slate-500 italic flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-blue-500"></i>
                    <span>Simpan halaman ini untuk cek status atau cetak tiket.</span>
                </div>

                <div class="w-full sm:w-auto flex flex-wrap items-center justify-center gap-3">
                    <a href="{{ route('kunjungan.status', $kunjungan->id) }}" class="w-full sm:w-auto bg-white text-slate-700 px-6 py-3 rounded-xl font-bold hover:bg-slate-100 transition flex items-center justify-center gap-2 border border-slate-300">
                        <i class="fa-solid fa-arrows-rotate"></i> Cek Status
                    </a>

                    {{-- TOMBOL EDIT DINAMIS --}}
                    @php
                        $isEditEnabled = \App\Models\VisitSetting::where('key', 'enable_guest_edit')->value('value') == '1';
                        $editLeadTime = (int) \App\Models\VisitSetting::where('key', 'edit_lead_time')->value('value') ?? 2;
                        $visitDate = \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan);
                        $canEditByTime = now()->lt($visitDate->subDays($editLeadTime));
                    @endphp

                    @if($isEditEnabled && $canEditByTime && $kunjungan->status == KunjunganStatus::PENDING)
                        <a href="#" onclick="alert('Fitur edit sedang dalam pengembangan, namun sistem sudah siap menerima pengaturan Anda.'); return false;" class="w-full sm:w-auto bg-amber-100 text-amber-700 px-6 py-3 rounded-xl font-bold hover:bg-amber-200 transition flex items-center justify-center gap-2 border border-amber-200">
                            <i class="fa-solid fa-pen-to-square"></i> Edit Data
                        </a>
                    @endif

                    @if(in_array($kunjungan->status, [KunjunganStatus::APPROVED, KunjunganStatus::CALLED, KunjunganStatus::IN_PROGRESS]))
                        {{-- TOMBOL CETAK (AKTIF) --}}
                        <a href="{{ route('kunjungan.print', $kunjungan->id) }}" target="_blank" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-8 py-3.5 rounded-2xl font-black shadow-lg shadow-blue-500/20 hover:scale-[1.02] transition-all flex items-center justify-center gap-2">
                            <i class="fa-solid fa-print"></i> CETAK TIKET
                        </a>
                    @elseif($kunjungan->status == KunjunganStatus::PENDING)
                        {{-- TOMBOL CETAK (DRAFT/PENDING) --}}
                        <a href="{{ route('kunjungan.print', $kunjungan->id) }}" target="_blank" class="w-full sm:w-auto bg-amber-500 hover:bg-amber-600 text-white px-8 py-3.5 rounded-2xl font-black shadow-lg shadow-amber-500/20 hover:scale-[1.02] transition-all flex items-center justify-center gap-2">
                            <i class="fa-solid fa-file-invoice"></i> CETAK DRAFT (PENDING)
                        </a>
                    @elseif($kunjungan->status == KunjunganStatus::COMPLETED)
                        {{-- TOMBOL SURVEI (SELESAI) --}}
                        <a href="https://star-survei3a.kemenimipas.go.id/ly/8ITXJREv" target="_blank" class="w-full sm:w-auto bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-3.5 rounded-2xl font-black shadow-lg shadow-emerald-500/20 hover:scale-[1.02] transition-all flex items-center justify-center gap-2">
                            <i class="fa-solid fa-star"></i> ISI SURVEI IKM
                        </a>
                    @else
                        {{-- TOMBOL MATI (ABU-ABU) --}}
                        <button disabled class="w-full sm:w-auto bg-slate-200 text-slate-400 px-8 py-3.5 rounded-2xl font-black cursor-not-allowed flex items-center justify-center gap-2 border border-slate-300">
                            <i class="fa-solid fa-lock"></i> TIKET BELUM TERSEDIA
                        </button>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

{{-- MODAL POPUP GAMBAR FULL SCREEN --}}
<div id="imageModal" class="fixed inset-0 z-[9999] hidden bg-black/95 flex items-center justify-center p-4 backdrop-blur-md transition-opacity duration-300 opacity-0" onclick="hideImageModal()">
    <div class="relative max-w-5xl w-full max-h-screen flex justify-center">
        {{-- Tombol Close --}}
        <button class="absolute -top-12 right-0 text-white hover:text-red-400 transition-colors" onclick="hideImageModal()">
            <i class="fa-solid fa-xmark text-4xl"></i>
        </button>
        
        {{-- Gambar Utama --}}
        <img id="modalImage" src="" class="max-w-full max-h-[85vh] rounded-lg shadow-2xl border border-slate-700 object-contain transform scale-95 transition-transform duration-300">
    </div>
</div>

{{-- SCRIPT MODAL --}}
<script>
    function showImageModal(src) {
        const modal = document.getElementById('imageModal');
        const img = document.getElementById('modalImage');
        
        // Set source gambar
        img.src = src;
        
        // Tampilkan modal
        modal.classList.remove('hidden');
        
        // Animasi Fade In (sedikit delay agar class hidden hilang dulu)
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            img.classList.remove('scale-95');
            img.classList.add('scale-100');
        }, 10);
    }

    function hideImageModal() {
        const modal = document.getElementById('imageModal');
        const img = document.getElementById('modalImage');

        // Animasi Fade Out
        modal.classList.add('opacity-0');
        img.classList.remove('scale-100');
        img.classList.add('scale-95');

        // Sembunyikan setelah animasi selesai
        setTimeout(() => {
            modal.classList.add('hidden');
            img.src = ''; // Reset gambar agar tidak flash saat dibuka lagi
        }, 300);
    }
</script>
@endsection