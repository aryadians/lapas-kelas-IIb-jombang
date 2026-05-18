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

    <div class="max-w-4xl mx-auto">
        <div class="mb-6 flex justify-between items-center">
            <a href="/" class="inline-flex items-center text-sm font-bold text-slate-500 hover:text-blue-600 transition-colors group">
                <i class="fa-solid fa-arrow-left mr-2 transform group-hover:-translate-x-1 transition-transform"></i> Kembali ke Beranda
            </a>
        </div>

        {{-- TIKET UTAMA --}}
        <div class="bg-white rounded-[2rem] shadow-2xl overflow-hidden border border-slate-200">
            {{-- HEADER TIKET --}}
            <div class="bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 px-6 py-10 text-center relative overflow-hidden">
                <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
                <div class="absolute -top-24 -left-24 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-slate-500/20 rounded-full blur-3xl"></div>
                
                <div class="relative z-10">
                    <p class="text-blue-300 text-[10px] font-black tracking-[0.3em] uppercase mb-4">Layanan Kunjungan Lapas Jombang</p>
                    <div class="inline-block mb-6">
                        @php
                            $statusColor = match($kunjungan->status) {
                                KunjunganStatus::APPROVED => 'emerald',
                                KunjunganStatus::REJECTED => 'rose',
                                KunjunganStatus::COMPLETED => 'slate',
                                default => 'blue',
                            };
                            $isPending = $kunjungan->status === KunjunganStatus::PENDING;
                        @endphp
                        <span class="bg-{{ $statusColor }}-500 {{ $isPending ? 'animate-pulse' : '' }} text-white font-black px-8 py-2.5 rounded-full shadow-lg shadow-{{ $statusColor }}-900/40 text-sm tracking-wider">
                            <i class="fa-solid {{ $kunjungan->status == KunjunganStatus::APPROVED ? 'fa-check-circle' : ($kunjungan->status == KunjunganStatus::REJECTED ? 'fa-times-circle' : 'fa-clock') }} mr-2"></i>
                            {{ strtoupper($kunjungan->status->value) }}
                        </span>
                    </div>
                    <h1 class="text-4xl md:text-5xl font-black text-white mt-2 tracking-tight">{{ $kunjungan->kode_kunjungan }}</h1>
                    <p class="text-blue-200/60 text-xs mt-4 font-mono">Kode Booking ini bersifat rahasia</p>
                </div>
            </div>

            <div class="p-6 md:p-10">
                @if($kunjungan->status == KunjunganStatus::APPROVED)
                <div class="mb-10 bg-emerald-50 border-2 border-emerald-100 p-6 rounded-2xl text-center transform hover:scale-[1.01] transition-transform">
                    <h3 class="text-emerald-800 font-black text-lg uppercase flex items-center justify-center gap-2">
                        <i class="fa-solid fa-circle-check text-2xl"></i> Registrasi Disetujui!
                    </h3>
                    <p class="text-emerald-600 mt-2 font-medium">Silakan datang sesuai estimasi jam kedatangan berikut:</p>
                    <div class="bg-white border border-emerald-200 inline-block px-8 py-3 rounded-xl mt-4 shadow-sm">
                        <span class="text-emerald-700 font-black text-2xl">{{ $jamDatang }}</span>
                    </div>
                </div>
                @elseif($kunjungan->status == KunjunganStatus::REJECTED)
                <div class="mb-10 bg-rose-50 border-2 border-rose-100 p-6 rounded-2xl">
                    <h3 class="text-rose-800 font-black text-lg uppercase flex items-center gap-2 justify-center">
                        <i class="fa-solid fa-circle-xmark text-2xl"></i> Registrasi Ditolak
                    </h3>
                    <p class="text-rose-600 mt-2 text-center font-medium">Mohon maaf, pendaftaran Anda tidak dapat kami proses karena:</p>
                    <div class="bg-white border border-rose-200 p-4 rounded-xl mt-4 text-rose-800 text-sm italic text-center font-bold">
                        "{{ $kunjungan->keterangan ?? 'Data tidak sesuai atau syarat belum terpenuhi.' }}"
                    </div>
                </div>
                @endif
                
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                    
                    {{-- KOLOM KIRI: DATA PENGUNJUNG --}}
                    <div class="lg:col-span-7 space-y-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white shadow-lg shadow-blue-200">
                                <i class="fa-solid fa-user-tie text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-slate-900 font-black text-xl leading-tight">Profil Pengunjung</h3>
                                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Informasi Terdaftar</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 bg-slate-50/50 p-6 rounded-2xl border border-slate-100">
                            <div class="sm:col-span-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Nama Lengkap</label>
                                <p class="text-slate-900 font-bold text-lg leading-tight">{{ $kunjungan->nama_pengunjung }}</p>
                            </div>
                            
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">NIK (KTP)</label>
                                <p class="text-slate-700 font-mono font-bold">{{ $kunjungan->nik_ktp }}</p>
                            </div>
                            
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Jenis Kelamin</label>
                                <p class="text-slate-700 font-bold">{{ $kunjungan->jenis_kelamin }}</p>
                            </div>

                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Kontak WhatsApp</label>
                                <p class="text-slate-700 font-bold flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center">
                                        <i class="fa-brands fa-whatsapp text-green-600 text-sm"></i>
                                    </span>
                                    {{ $kunjungan->no_wa_pengunjung }}
                                </p>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Alamat Domisili</label>
                                <p class="text-slate-600 text-sm leading-relaxed font-medium">{{ $kunjungan->alamat_pengunjung }}</p>
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Verifikasi Identitas</label>
                            <div class="relative inline-block group">
                                <div class="w-full sm:w-64 h-40 bg-slate-200 rounded-2xl overflow-hidden border-2 border-white shadow-md transition-all duration-300 group-hover:shadow-xl group-hover:border-blue-400">
                                    @php $imageSrc = $kunjungan->foto_ktp_url; @endphp
                                    @if($imageSrc)
                                        <a href="javascript:void(0)" onclick="showImageModal('{{ $imageSrc }}')">
                                            <img src="{{ $imageSrc }}" alt="Foto KTP" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onerror="this.onerror=null; this.src='https://via.placeholder.com/300x200?text=Gambar+Tidak+Tersedia';">
                                            <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center text-white backdrop-blur-[2px]">
                                                <i class="fa-solid fa-expand text-2xl mb-2"></i>
                                                <span class="text-[10px] font-black uppercase tracking-widest">Perbesar KTP</span>
                                            </div>
                                        </a>
                                    @else
                                        <div class="flex flex-col items-center justify-center h-full text-slate-400 italic">
                                            <i class="fa-solid fa-image-slash text-4xl mb-2 opacity-20"></i>
                                            <span class="text-[10px]">Foto tidak ditemukan</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: DETAIL TIKET (STUB) --}}
                    <div class="lg:col-span-5">
                        <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white relative shadow-2xl shadow-blue-900/20 overflow-hidden border-4 border-slate-800">
                            {{-- ORNAMEN TIKET --}}
                            <div class="absolute top-1/2 -left-5 w-10 h-10 bg-white rounded-full"></div>
                            <div class="absolute top-1/2 -right-5 w-10 h-10 bg-white rounded-full"></div>
                            <div class="absolute top-1/2 left-8 right-8 border-t-2 border-dashed border-slate-700"></div>

                            <div class="relative z-10 space-y-8">
                                <div class="flex items-center justify-between mb-6 pb-6 border-b border-white/5">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 bg-blue-500 rounded-full shadow-[0_0_8px_rgba(59,130,246,0.6)]"></div>
                                        <span class="text-[11px] font-black uppercase tracking-[0.2em] text-white">Lapas Jombang</span>
                                    </div>
                                    <div class="flex flex-col items-end">
                                        <span class="text-[10px] font-black text-blue-400 uppercase tracking-widest leading-none">{{ $kunjungan->registration_type }}</span>
                                        <span class="text-[8px] font-bold text-slate-600 uppercase tracking-[0.2em] mt-1">Registration</span>
                                    </div>
                                </div>

                                {{-- INFO WBP --}}
                                <div class="bg-slate-800/50 p-5 rounded-2xl border border-slate-700/50">
                                    <p class="text-[10px] font-black text-blue-400 uppercase tracking-[0.2em] mb-2">Mengunjungi WBP:</p>
                                    <h4 class="text-xl font-black tracking-tight leading-tight">{{ $kunjungan->wbp->nama ?? 'Nama WBP Tidak Ditemukan' }}</h4>
                                    <p class="text-[10px] text-slate-400 mt-1 font-mono uppercase">{{ $kunjungan->wbp->kode_tahanan ?? 'NO-ID' }} / {{ $kategoriKunjungan }}</p>
                                </div>

                                {{-- JADWAL --}}
                                <div class="grid grid-cols-2 gap-6 pt-4">
                                    <div>
                                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Tanggal</p>
                                        <p class="font-bold text-sm">{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('d F Y') }}</p>
                                        <p class="text-[10px] text-blue-400 font-bold uppercase tracking-widest">{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->translatedFormat('l') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Sesi / Jam</p>
                                        <p class="font-bold text-sm capitalize">{{ $kunjungan->sesi ?? 'Default' }}</p>
                                        <p class="text-[10px] text-slate-400 leading-tight">
                                            {{ $kunjungan->sesi == 'pagi' ? ($visitSettings['jam_buka_pagi'] ?? '08.30') . '-' . ($visitSettings['jam_tutup_pagi'] ?? '10.00') : ($visitSettings['jam_buka_siang'] ?? '13.30') . '-' . ($visitSettings['jam_tutup_siang'] ?? '14.30') }} WIB
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Hubungan</p>
                                        <p class="font-bold text-sm">{{ $kunjungan->hubungan }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Pengikut</p>
                                        <p class="font-bold text-sm">+{{ $kunjungan->pengikuts->count() }} Orang</p>
                                    </div>
                                </div>

                                {{-- QR & ANTRIAN --}}
                                <div class="mt-8 pt-10 text-center flex flex-col items-center">
                                    <div class="relative group">
                                        <div class="absolute -inset-4 bg-white/5 rounded-[2rem] blur-xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                        <div class="bg-white p-3 rounded-2xl shadow-xl shadow-blue-900/50 relative">
                                            <img src="{{ $kunjungan->qr_code_url }}" alt="QR Code" class="w-32 h-32 object-contain filter contrast-125">
                                        </div>
                                    </div>
                                    
                                    <div class="mt-6">
                                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-1">Nomor Antrian</p>
                                        <div class="text-6xl font-black text-white tracking-tighter drop-shadow-lg">
                                            {{ $kunjungan->registration_type === 'offline' ? 'B' : 'A' }}<span class="text-blue-500 text-5xl">-</span>{{ str_pad($kunjungan->nomor_antrian_harian, 3, '0', STR_PAD_LEFT) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- SYARAT WAJIB (DIBAWAH TIKET) --}}
                        <div class="mt-6 bg-amber-50 border-2 border-amber-100 p-5 rounded-2xl">
                            <h4 class="text-amber-900 font-black text-xs mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-triangle-exclamation text-amber-600"></i> SYARAT WAJIB:
                            </h4>
                            <ul class="text-[11px] text-amber-800 space-y-2.5 font-bold">
                                <li class="flex items-start gap-2">
                                    <span class="text-amber-500 mt-0.5">•</span>
                                    <span>Datang tepat waktu pukul <span class="text-slate-900">{{ $jamDatang }}</span></span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-amber-500 mt-0.5">•</span>
                                    <span>Wajib membawa <span class="bg-amber-200/50 px-1.5 rounded">KTP ASLI</span> yang terdaftar</span>
                                </li>
                                @if($isTahanan)
                                <li class="flex items-start gap-2 bg-rose-100/50 p-2 rounded-lg text-rose-800">
                                    <i class="fa-solid fa-file-contract mt-0.5"></i>
                                    <span>Wajib membawa SURAT IZIN dari pihak Penahan</span>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- FOOTER AKSI --}}
            <div class="bg-slate-50 px-6 md:px-10 py-8 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-6">
                <div class="text-xs text-slate-400 font-medium flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-blue-500"></i>
                    <span>Screenshot halaman ini untuk akses cepat saat di loket.</span>
                </div>

                <div class="w-full sm:w-auto flex flex-wrap items-center justify-center gap-4">
                    <a href="{{ route('kunjungan.status', $kunjungan->id) }}" class="w-full sm:w-auto bg-white text-slate-700 px-6 py-3.5 rounded-2xl font-black hover:bg-slate-100 transition shadow-sm border border-slate-200 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-arrows-rotate text-blue-500"></i> Refresh
                    </a>

                    @php
                        $isEditEnabled = \App\Models\VisitSetting::where('key', 'enable_guest_edit')->value('value') == '1';
                        $editLeadTime = (int) (\App\Models\VisitSetting::where('key', 'edit_lead_time')->value('value') ?? 2);
                        $visitDate = \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan);
                        $canEditByTime = now()->lt($visitDate->subDays($editLeadTime));
                    @endphp

                    @if($isEditEnabled && $canEditByTime && $kunjungan->status == KunjunganStatus::PENDING)
                        <a href="javascript:void(0)" onclick="Swal.fire('Fitur Segera Hadir', 'Fitur edit sedang dikalibrasi oleh tim IT.', 'info')" class="w-full sm:w-auto bg-amber-500 text-white px-6 py-3.5 rounded-2xl font-black hover:bg-amber-600 transition shadow-lg shadow-amber-500/20 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-pen-to-square"></i> Edit Data
                        </a>
                    @endif

                    @if(in_array($kunjungan->status, [KunjunganStatus::APPROVED, KunjunganStatus::CALLED, KunjunganStatus::IN_PROGRESS]))
                        <a href="{{ route('kunjungan.print', $kunjungan->id) }}" target="_blank" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-8 py-3.5 rounded-2xl font-black shadow-xl shadow-blue-600/30 hover:scale-[1.02] transition-all flex items-center justify-center gap-2">
                            <i class="fa-solid fa-print"></i> CETAK TIKET
                        </a>
                    @elseif($kunjungan->status == KunjunganStatus::PENDING)
                        <a href="{{ route('kunjungan.print', $kunjungan->id) }}" target="_blank" class="w-full sm:w-auto bg-slate-800 hover:bg-slate-900 text-white px-8 py-3.5 rounded-2xl font-black shadow-xl shadow-slate-900/30 hover:scale-[1.02] transition-all flex items-center justify-center gap-2">
                            <i class="fa-solid fa-file-invoice text-blue-400"></i> CETAK DRAFT
                        </a>
                    @elseif($kunjungan->status == KunjunganStatus::COMPLETED)
                        <a href="https://star-survei3a.kemenimipas.go.id/ly/8ITXJREv" target="_blank" class="w-full sm:w-auto bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-3.5 rounded-2xl font-black shadow-xl shadow-emerald-600/30 hover:scale-[1.02] transition-all flex items-center justify-center gap-2 text-center">
                            <i class="fa-solid fa-star text-yellow-300"></i> ISI SURVEI IKM
                        </a>
                    @else
                        <button disabled class="w-full sm:w-auto bg-slate-200 text-slate-400 px-8 py-3.5 rounded-2xl font-black cursor-not-allowed border border-slate-200">
                            <i class="fa-solid fa-lock mr-2"></i> Tiket Terkunci
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <p class="text-center mt-10 text-[10px] font-black text-slate-400 uppercase tracking-[0.4em]">Sistem Informasi Kunjungan © 2024</p>
    </div>
</div>

{{-- MODAL GAMBAR --}}
<div id="imageModal" class="fixed inset-0 z-[9999] hidden bg-slate-900/95 flex items-center justify-center p-4 backdrop-blur-md transition-opacity duration-300 opacity-0" onclick="hideImageModal()">
    <div class="relative max-w-4xl w-full max-h-[90vh] flex flex-col items-center justify-center gap-4" onclick="event.stopPropagation()">
        <button class="absolute -top-12 right-0 text-white hover:text-rose-500 transition-colors" onclick="hideImageModal()">
            <i class="fa-solid fa-xmark text-4xl"></i>
        </button>
        <img id="modalImage" src="" class="max-w-full max-h-[80vh] rounded-2xl shadow-2xl border border-slate-700 object-contain transform scale-95 transition-transform duration-300">
        <p class="text-white/50 text-xs font-mono bg-black/40 px-4 py-1.5 rounded-full backdrop-blur-sm">Klik di luar gambar untuk menutup</p>
    </div>
</div>

<script>
    function showImageModal(src) {
        const modal = document.getElementById('imageModal');
        const img = document.getElementById('modalImage');
        img.src = src;
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            img.classList.remove('scale-95');
            img.classList.add('scale-100');
        }, 10);
    }
    function hideImageModal() {
        const modal = document.getElementById('imageModal');
        const img = document.getElementById('modalImage');
        modal.classList.add('opacity-0');
        img.classList.remove('scale-100');
        img.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            img.src = '';
        }, 300);
    }
</script>
@endsection