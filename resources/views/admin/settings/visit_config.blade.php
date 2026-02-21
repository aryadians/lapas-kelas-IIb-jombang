@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<style>
    trix-toolbar [data-trix-button-group="file-tools"] { display: none !important; }
    trix-editor { min-height: 180px; border-radius: 1rem; border: 2px solid #e2e8f0; padding: 1rem; background: #f8fafc; }
    trix-editor:focus { border-color: #6366f1; outline: none; }
</style>

<div class="space-y-6 pb-12" x-data="{ tab: 'jadwal' }">
    {{-- HEADER --}}
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 animate__animated animate__fadeInDown">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">
                ⚙️ Konfigurasi Sistem Kunjungan
            </h1>
            <p class="text-slate-500 mt-1 font-medium">Kelola seluruh pengaturan sistem layanan kunjungan Lapas dari satu tempat.</p>
        </div>
    </header>

    @if(session('success'))
    <div class="animate__animated animate__fadeIn">
        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-xl shadow-sm">
            <div class="flex items-center gap-3">
                <i class="fas fa-check-circle text-emerald-500"></i>
                <p class="text-emerald-700 font-bold text-sm">{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif

    {{-- TAB NAVIGATION --}}
    <div class="bg-white rounded-2xl shadow-lg shadow-slate-200/50 border border-slate-100 p-1.5 flex flex-wrap gap-1 animate__animated animate__fadeInUp">
        <button type="button" @click="tab = 'jadwal'" :class="tab === 'jadwal' ? 'bg-slate-800 text-white shadow-lg shadow-slate-300' : 'text-slate-500 hover:bg-slate-50'" class="flex items-center gap-2 px-5 py-3 rounded-xl font-bold text-sm transition-all">
            <i class="fas fa-calendar-alt"></i> Jadwal & Kuota
        </button>
        <button type="button" @click="tab = 'aturan'" :class="tab === 'aturan' ? 'bg-slate-800 text-white shadow-lg shadow-slate-300' : 'text-slate-500 hover:bg-slate-50'" class="flex items-center gap-2 px-5 py-3 rounded-xl font-bold text-sm transition-all">
            <i class="fas fa-sliders-h"></i> Aturan & Batas
        </button>
        <button type="button" @click="tab = 'konten'" :class="tab === 'konten' ? 'bg-slate-800 text-white shadow-lg shadow-slate-300' : 'text-slate-500 hover:bg-slate-50'" class="flex items-center gap-2 px-5 py-3 rounded-xl font-bold text-sm transition-all">
            <i class="fas fa-file-alt"></i> Konten & Info Publik
        </button>
        <button type="button" @click="tab = 'operasional'" :class="tab === 'operasional' ? 'bg-slate-800 text-white shadow-lg shadow-slate-300' : 'text-slate-500 hover:bg-slate-50'" class="flex items-center gap-2 px-5 py-3 rounded-xl font-bold text-sm transition-all">
            <i class="fas fa-clock"></i> Jam Operasional
        </button>
        <button type="button" @click="tab = 'integrasi'" :class="tab === 'integrasi' ? 'bg-slate-800 text-white shadow-lg shadow-slate-300' : 'text-slate-500 hover:bg-slate-50'" class="flex items-center gap-2 px-5 py-3 rounded-xl font-bold text-sm transition-all">
            <i class="fas fa-plug"></i> Integrasi API
        </button>
    </div>

    <form action="{{ route('admin.settings.visit-config.update') }}" method="POST" class="space-y-8">
        @csrf

        {{-- ════════════════════════════════════════════ TAB 1: JADWAL & KUOTA ════════════════════════════════════════════ --}}
        <div x-show="tab === 'jadwal'" x-transition:enter="animate__animated animate__fadeIn" class="space-y-8">
            <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                <div class="bg-slate-50 px-8 py-5 border-b border-slate-100 flex items-center gap-4">
                    <div class="w-11 h-11 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-200">
                        <i class="fas fa-calendar-alt text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-black text-slate-800 uppercase tracking-tight">Jadwal Operasional & Kuota</h2>
                        <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Atur ketersediaan hari dan jumlah pengunjung per sesi</p>
                    </div>
                </div>
                <div class="p-8">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-slate-400 border-b border-slate-100">
                                    <th class="pb-4 font-black uppercase text-[10px] tracking-[0.2em] w-32">Hari</th>
                                    <th class="pb-4 font-black uppercase text-[10px] tracking-[0.2em] text-center">Status</th>
                                    <th class="pb-4 font-black uppercase text-[10px] tracking-[0.2em] text-center">Kuota Online (P/S)</th>
                                    <th class="pb-4 font-black uppercase text-[10px] tracking-[0.2em] text-center">Kuota Offline (P/S)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($schedules as $schedule)
                                <tr class="group">
                                    <td class="py-5"><span class="font-black text-lg text-slate-800">{{ $schedule->day_name }}</span></td>
                                    <td class="py-5 text-center">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="schedules[{{ $schedule->id }}][is_open]" value="1" class="sr-only peer" {{ $schedule->is_open ? 'checked' : '' }}>
                                            <div class="w-14 h-7 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-emerald-500"></div>
                                        </label>
                                        <p class="text-[10px] mt-1 font-bold text-slate-400 uppercase">{{ $schedule->is_open ? 'Buka' : 'Tutup' }}</p>
                                    </td>
                                    <td class="py-5">
                                        <div class="flex items-center justify-center gap-3">
                                            <div class="relative">
                                                <span class="absolute -top-4 left-1 text-[9px] font-black text-blue-400 uppercase">Pagi</span>
                                                <input type="number" name="schedules[{{ $schedule->id }}][online_morning]" value="{{ $schedule->quota_online_morning }}" class="w-20 p-2 bg-slate-50 border-2 border-slate-100 rounded-xl text-center font-bold text-slate-700 focus:border-blue-500 focus:ring-0">
                                            </div>
                                            <div class="relative">
                                                <span class="absolute -top-4 left-1 text-[9px] font-black text-amber-400 uppercase">Siang</span>
                                                <input type="number" name="schedules[{{ $schedule->id }}][online_afternoon]" value="{{ $schedule->quota_online_afternoon }}" class="w-20 p-2 bg-slate-50 border-2 border-slate-100 rounded-xl text-center font-bold text-slate-700 focus:border-blue-500 focus:ring-0">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-5">
                                        <div class="flex items-center justify-center gap-3">
                                            <div class="relative">
                                                <span class="absolute -top-4 left-1 text-[9px] font-black text-blue-400 uppercase">Pagi</span>
                                                <input type="number" name="schedules[{{ $schedule->id }}][offline_morning]" value="{{ $schedule->quota_offline_morning }}" class="w-20 p-2 bg-slate-50 border-2 border-slate-100 rounded-xl text-center font-bold text-slate-700 focus:border-blue-500 focus:ring-0">
                                            </div>
                                            <div class="relative">
                                                <span class="absolute -top-4 left-1 text-[9px] font-black text-amber-400 uppercase">Siang</span>
                                                <input type="number" name="schedules[{{ $schedule->id }}][offline_afternoon]" value="{{ $schedule->quota_offline_afternoon }}" class="w-20 p-2 bg-slate-50 border-2 border-slate-100 rounded-xl text-center font-bold text-slate-700 focus:border-blue-500 focus:ring-0">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- ════════════════════════════════════════════ TAB 2: ATURAN & BATAS ════════════════════════════════════════════ --}}
        <div x-show="tab === 'aturan'" x-transition:enter="animate__animated animate__fadeIn" class="space-y-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- Batasan Frekuensi --}}
                <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                    <div class="bg-slate-50 px-8 py-5 border-b border-slate-100 flex items-center gap-4">
                        <div class="w-11 h-11 bg-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                            <i class="fas fa-user-shield text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-black text-slate-800 uppercase tracking-tight">Batasan Frekuensi</h2>
                            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Kontrol intensitas kunjungan</p>
                        </div>
                    </div>
                    <div class="p-8 space-y-6">
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700">Maksimal Kunjungan per NIK (Mingguan)</label>
                            <div class="flex items-center gap-4">
                                <input type="number" name="limit_nik_per_week" value="{{ $settings['limit_nik_per_week'] ?? 1 }}" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-black text-slate-700 focus:border-indigo-500 focus:ring-0">
                                <span class="text-slate-400 font-bold uppercase text-xs w-16">Kali</span>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700">Maksimal Kunjungan per WBP (Mingguan)</label>
                            <div class="flex items-center gap-4">
                                <input type="number" name="limit_wbp_per_week" value="{{ $settings['limit_wbp_per_week'] ?? 1 }}" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-black text-slate-700 focus:border-amber-500 focus:ring-0">
                                <span class="text-slate-400 font-bold uppercase text-xs w-16">Kali</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pengaturan Waktu & Edit --}}
                <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                    <div class="bg-slate-50 px-8 py-5 border-b border-slate-100 flex items-center gap-4">
                        <div class="w-11 h-11 bg-rose-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-rose-200">
                            <i class="fas fa-history text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-black text-slate-800 uppercase tracking-tight">Waktu & Fitur Edit</h2>
                            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Kontrol pendaftaran dan perubahan data</p>
                        </div>
                    </div>
                    <div class="p-8 space-y-6">
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700">Batas Minimal Pendaftaran (H-N Hari)</label>
                            <div class="flex items-center gap-4">
                                <input type="number" name="registration_lead_time" value="{{ $settings['registration_lead_time'] ?? 1 }}" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-black text-slate-700 focus:border-rose-500 focus:ring-0">
                                <span class="text-slate-400 font-bold uppercase text-xs w-16">Hari</span>
                            </div>
                            <p class="text-[10px] text-slate-400 italic">Contoh: Jika diisi 1, maka pengunjung tidak bisa mendaftar untuk besok (minimal lusa).</p>
                        </div>
                        <div class="h-px bg-slate-100"></div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <label class="text-sm font-bold text-slate-700">Fitur Edit Pendaftaran (Guest)</label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="enable_guest_edit" value="1" class="sr-only peer" {{ ($settings['enable_guest_edit'] ?? '0') == '1' ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-500 uppercase">Batas Maksimal Edit (H-N Hari)</label>
                                <div class="flex items-center gap-4">
                                    <input type="number" name="edit_lead_time" value="{{ $settings['edit_lead_time'] ?? 2 }}" class="w-full p-3 bg-slate-50 border-2 border-slate-100 rounded-xl font-bold text-slate-700 focus:ring-0">
                                    <span class="text-slate-400 font-bold uppercase text-[10px] w-16">Hari</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- Pembatasan & Durasi --}}
                <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                    <div class="bg-slate-50 px-8 py-5 border-b border-slate-100 flex items-center gap-4">
                        <div class="w-11 h-11 bg-teal-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-teal-200">
                            <i class="fas fa-users-cog text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-black text-slate-800 uppercase tracking-tight">Aturan Pengunjung & Durasi</h2>
                            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Kapasitas rombongan dan sesi temu</p>
                        </div>
                    </div>
                    <div class="p-8 space-y-6">
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700">Maksimal Total Rombongan Pengikut</label>
                            <div class="flex items-center gap-4">
                                <input type="number" name="max_followers_allowed" value="{{ $settings['max_followers_allowed'] ?? 4 }}" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-black text-slate-700 focus:border-teal-500 focus:ring-0">
                                <span class="text-slate-400 font-bold uppercase text-xs w-16">Orang</span>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700">Durasi Waktu Kunjungan</label>
                            <div class="flex items-center gap-4">
                                <input type="number" name="visit_duration_minutes" value="{{ $settings['visit_duration_minutes'] ?? 30 }}" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-black text-slate-700 focus:border-teal-500 focus:ring-0">
                                <span class="text-slate-400 font-bold uppercase text-xs w-16">Menit</span>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700">Toleransi Keterlambatan Panggilan</label>
                            <div class="flex items-center gap-4">
                                <input type="number" name="arrival_tolerance_minutes" value="{{ $settings['arrival_tolerance_minutes'] ?? 15 }}" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-black text-slate-700 focus:border-orange-500 focus:ring-0">
                                <span class="text-slate-400 font-bold uppercase text-xs w-16">Menit</span>
                            </div>
                            <p class="text-[10px] text-slate-400 italic">Batas waktu sebelum auto-batal/dilewati.</p>
                        </div>
                    </div>
                </div>

                {{-- Mode Darurat --}}
                <div class="bg-white rounded-[2rem] shadow-xl shadow-red-200/30 border border-slate-100 ring-4 ring-slate-50 overflow-hidden">
                    <div class="bg-red-50 px-8 py-5 border-b border-red-100 flex items-center gap-4">
                        <div class="w-11 h-11 bg-red-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-red-200">
                            <i class="fas fa-exclamation-triangle text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-black text-red-800 uppercase tracking-tight">Mode Darurat & Tutup</h2>
                            <p class="text-red-400/80 text-xs font-bold uppercase tracking-widest">Pengumuman & Lock Pendaftaran</p>
                        </div>
                    </div>
                    <div class="p-8 space-y-6">
                        <div class="flex items-center justify-between bg-red-50 p-4 rounded-2xl border border-red-100">
                            <div>
                                <h3 class="font-black text-red-900 leading-tight">Aktifkan Kunci Darurat</h3>
                                <p class="text-[10px] text-red-600 font-medium">Tutup paksa form kunjungan publik saat ini</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_emergency_closed" value="1" class="sr-only peer" {{ ($settings['is_emergency_closed'] ?? '0') == '1' ? 'checked' : '' }}>
                                <div class="w-14 h-7 bg-red-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-red-600 shadow-inner"></div>
                            </label>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-red-800">Teks Pengumuman/Banner Darurat</label>
                            <textarea name="announcement_guest_page" rows="3" class="w-full p-4 bg-white border-2 border-red-100 focus:border-red-500 rounded-2xl font-medium text-slate-700 focus:ring-0 placeholder-slate-300 text-sm" placeholder="Contoh: Mohon maaf, layanan kunjungan ditutup sementara karena ada sidak mendadak...">{{ $settings['announcement_guest_page'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ════════════════════════════════════════════ TAB 3: KONTEN & INFO PUBLIK ════════════════════════════════════════════ --}}
        <div x-show="tab === 'konten'" x-transition:enter="animate__animated animate__fadeIn" class="space-y-8">
            {{-- Syarat & Ketentuan --}}
            <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                <div class="bg-slate-50 px-8 py-5 border-b border-slate-100 flex items-center gap-4">
                    <div class="w-11 h-11 bg-violet-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-violet-200">
                        <i class="fas fa-file-contract text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-black text-slate-800 uppercase tracking-tight">Syarat & Ketentuan Kunjungan</h2>
                        <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Teks aturan yang tampil di halaman pendaftaran pengunjung</p>
                    </div>
                </div>
                <div class="p-8" x-data="{ termsContent: @js($settings['terms_conditions'] ?? '') }">
                    <input id="terms_conditions" type="hidden" name="terms_conditions" :value="termsContent">
                    <trix-editor input="terms_conditions" class="trix-content" x-on:trix-change="termsContent = $event.target.value"></trix-editor>
                    <p class="text-[10px] text-slate-400 italic mt-3"><i class="fas fa-info-circle mr-1"></i> Gunakan toolbar di atas untuk format tebal, miring, list, dll. Teks ini akan ditampilkan di halaman pendaftaran guest.</p>
                </div>
            </div>

            {{-- Kontak & Helpdesk --}}
            <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                <div class="bg-slate-50 px-8 py-5 border-b border-slate-100 flex items-center gap-4">
                    <div class="w-11 h-11 bg-emerald-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                        <i class="fab fa-whatsapp text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-black text-slate-800 uppercase tracking-tight">Kontak Layanan & Helpdesk</h2>
                        <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Nomor yang ditampilkan ke publik untuk pengaduan</p>
                    </div>
                </div>
                <div class="p-8 space-y-5">
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700">Nomor WhatsApp Helpdesk / Pengaduan</label>
                        <div class="flex items-center gap-3">
                            <span class="bg-emerald-100 text-emerald-700 font-black px-4 py-4 rounded-l-2xl border-2 border-r-0 border-emerald-200 text-sm">+62</span>
                            <input type="text" name="helpdesk_whatsapp" value="{{ $settings['helpdesk_whatsapp'] ?? '' }}" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-r-2xl font-bold text-slate-700 focus:border-emerald-500 focus:ring-0" placeholder="81234567890">
                        </div>
                        <p class="text-[10px] text-slate-400 italic"><i class="fas fa-info-circle mr-1"></i> Format: 62XXXXXXXXXX (tanpa +). Nomor ini akan ditampilkan di halaman publik dan footer website.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ════════════════════════════════════════════ TAB 4: JAM OPERASIONAL ════════════════════════════════════════════ --}}
        <div x-show="tab === 'operasional'" x-transition:enter="animate__animated animate__fadeIn" class="space-y-8">
            <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                <div class="bg-slate-50 px-8 py-5 border-b border-slate-100 flex items-center gap-4">
                    <div class="w-11 h-11 bg-amber-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-amber-200">
                        <i class="fas fa-business-time text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-black text-slate-800 uppercase tracking-tight">Jam Operasional Pelayanan</h2>
                        <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Atur jam buka dan tutup untuk setiap sesi kunjungan</p>
                    </div>
                </div>
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Sesi Pagi --}}
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100/50 space-y-5">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-9 h-9 bg-blue-500 rounded-xl flex items-center justify-center text-white shadow-md">
                                    <i class="fas fa-sun text-sm"></i>
                                </div>
                                <h3 class="font-black text-blue-900 text-lg uppercase tracking-tight">Sesi Pagi</h3>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-blue-800">Jam Buka</label>
                                <input type="time" name="jam_buka_pagi" value="{{ $settings['jam_buka_pagi'] ?? '08:00' }}" class="w-full p-4 bg-white border-2 border-blue-100 rounded-2xl font-black text-slate-700 focus:border-blue-500 focus:ring-0">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-blue-800">Jam Tutup</label>
                                <input type="time" name="jam_tutup_pagi" value="{{ $settings['jam_tutup_pagi'] ?? '11:00' }}" class="w-full p-4 bg-white border-2 border-blue-100 rounded-2xl font-black text-slate-700 focus:border-blue-500 focus:ring-0">
                            </div>
                        </div>

                        {{-- Sesi Siang --}}
                        <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl p-6 border border-amber-100/50 space-y-5">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-9 h-9 bg-amber-500 rounded-xl flex items-center justify-center text-white shadow-md">
                                    <i class="fas fa-cloud-sun text-sm"></i>
                                </div>
                                <h3 class="font-black text-amber-900 text-lg uppercase tracking-tight">Sesi Siang</h3>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-amber-800">Jam Buka</label>
                                <input type="time" name="jam_buka_siang" value="{{ $settings['jam_buka_siang'] ?? '13:00' }}" class="w-full p-4 bg-white border-2 border-amber-100 rounded-2xl font-black text-slate-700 focus:border-amber-500 focus:ring-0">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-amber-800">Jam Tutup</label>
                                <input type="time" name="jam_tutup_siang" value="{{ $settings['jam_tutup_siang'] ?? '15:00' }}" class="w-full p-4 bg-white border-2 border-amber-100 rounded-2xl font-black text-slate-700 focus:border-amber-500 focus:ring-0">
                            </div>
                        </div>
                    </div>
                    <p class="text-[10px] text-slate-400 italic mt-4"><i class="fas fa-info-circle mr-1"></i> Perubahan jam operasional akan berdampak langsung pada jadwal auto-panggil antrian dan logika engine Auto-Batal.</p>
                </div>
            </div>
        </div>

        {{-- ════════════════════════════════════════════ TAB 5: INTEGRASI API ════════════════════════════════════════════ --}}
        <div x-show="tab === 'integrasi'" x-transition:enter="animate__animated animate__fadeIn" class="space-y-8">
            <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                <div class="bg-slate-50 px-8 py-5 border-b border-slate-100 flex items-center gap-4">
                    <div class="w-11 h-11 bg-cyan-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-cyan-200">
                        <i class="fas fa-key text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-black text-slate-800 uppercase tracking-tight">Kredensial API WhatsApp (Fonnte)</h2>
                        <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Token autentikasi untuk pengiriman pesan otomatis</p>
                    </div>
                </div>
                <div class="p-8 space-y-5">
                    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 flex items-start gap-3">
                        <i class="fas fa-shield-alt text-amber-500 mt-0.5"></i>
                        <div>
                            <p class="text-sm font-bold text-amber-800">Hanya untuk Superadmin / Petugas IT</p>
                            <p class="text-xs text-amber-600 mt-1">Perubahan token API dapat menyebabkan pengiriman pesan WhatsApp tergangu. Pastikan token yang dimasukkan valid dan aktif.</p>
                        </div>
                    </div>
                    <div class="space-y-2" x-data="{ showToken: false }">
                        <label class="text-sm font-bold text-slate-700">API Token Fonnte</label>
                        <div class="relative">
                            <input :type="showToken ? 'text' : 'password'" name="api_token_fonnte" value="{{ $settings['api_token_fonnte'] ?? '' }}" class="w-full p-4 pr-14 bg-slate-50 border-2 border-slate-100 rounded-2xl font-mono text-sm text-slate-700 focus:border-cyan-500 focus:ring-0" placeholder="Masukkan token API Fonnte Anda...">
                            <button type="button" @click="showToken = !showToken" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                                <i :class="showToken ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                            </button>
                        </div>
                        <p class="text-[10px] text-slate-400 italic"><i class="fas fa-info-circle mr-1"></i> Token ini digunakan untuk mengirim notifikasi WhatsApp (persetujuan kunjungan, kode QR, pengingat) melalui API Fonnte. Dapatkan dari <a href="https://fonnte.com" target="_blank" class="text-cyan-600 underline">fonnte.com</a>.</p>
                    </div>
                </div>
            </div>

            {{-- EMAIL GMAIL SMTP --}}
            <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                <div class="bg-slate-50 px-8 py-5 border-b border-slate-100 flex items-center gap-4">
                    <div class="w-11 h-11 bg-red-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-red-200">
                        <i class="fas fa-envelope text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-black text-slate-800 uppercase tracking-tight">Konfigurasi Email (Gmail SMTP)</h2>
                        <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Pengaturan pengirim email notifikasi sistem</p>
                    </div>
                </div>
                <div class="p-8 space-y-5">
                    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 flex items-start gap-3">
                        <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                        <div>
                            <p class="text-sm font-bold text-blue-800">Cara Mendapatkan App Password Gmail</p>
                            <p class="text-xs text-blue-600 mt-1">Buka <a href="https://myaccount.google.com/apppasswords" target="_blank" class="underline font-bold">Google App Passwords</a> → Pilih "Mail" → Generate. Pastikan 2-Step Verification aktif di akun Gmail.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700">SMTP Host</label>
                            <input type="text" name="mail_host" value="{{ $settings['mail_host'] ?? 'smtp.gmail.com' }}" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-mono text-sm text-slate-700 focus:border-red-500 focus:ring-0" placeholder="smtp.gmail.com">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700">SMTP Port</label>
                            <input type="number" name="mail_port" value="{{ $settings['mail_port'] ?? '587' }}" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-mono text-sm text-slate-700 focus:border-red-500 focus:ring-0" placeholder="587">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700">Email Pengirim (Username SMTP)</label>
                            <input type="email" name="mail_username" value="{{ $settings['mail_username'] ?? '' }}" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-sm text-slate-700 focus:border-red-500 focus:ring-0" placeholder="email@gmail.com">
                        </div>
                        <div class="space-y-2" x-data="{ showMailPass: false }">
                            <label class="text-sm font-bold text-slate-700">App Password Gmail</label>
                            <div class="relative">
                                <input :type="showMailPass ? 'text' : 'password'" name="mail_password" value="{{ $settings['mail_password'] ?? '' }}" class="w-full p-4 pr-14 bg-slate-50 border-2 border-slate-100 rounded-2xl font-mono text-sm text-slate-700 focus:border-red-500 focus:ring-0" placeholder="xxxx xxxx xxxx xxxx">
                                <button type="button" @click="showMailPass = !showMailPass" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                                    <i :class="showMailPass ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700">Enkripsi</label>
                            <select name="mail_encryption" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-sm font-bold text-slate-700 focus:border-red-500 focus:ring-0">
                                <option value="tls" {{ ($settings['mail_encryption'] ?? 'tls') === 'tls' ? 'selected' : '' }}>TLS (Port 587)</option>
                                <option value="ssl" {{ ($settings['mail_encryption'] ?? '') === 'ssl' ? 'selected' : '' }}>SSL (Port 465)</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700">Alamat Email Pengirim (From)</label>
                            <input type="email" name="mail_from_address" value="{{ $settings['mail_from_address'] ?? '' }}" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-sm text-slate-700 focus:border-red-500 focus:ring-0" placeholder="noreply@gmail.com">
                        </div>
                    </div>

                    <div class="h-px bg-slate-100"></div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700">Email Admin / Penerima Notifikasi</label>
                        <input type="email" name="admin_email" value="{{ $settings['admin_email'] ?? '' }}" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-sm text-slate-700 focus:border-red-500 focus:ring-0" placeholder="admin@gmail.com">
                        <p class="text-[10px] text-slate-400 italic"><i class="fas fa-info-circle mr-1"></i> Email ini digunakan untuk menerima notifikasi pendaftaran baru dan laporan harian.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- SAVE BUTTON (Always Visible) --}}
        <div class="flex justify-center pt-4 animate__animated animate__fadeInUp">
            <button type="submit" class="bg-slate-900 text-white font-black px-12 py-5 rounded-[2rem] shadow-2xl hover:bg-blue-600 hover:-translate-y-1 transition-all active:scale-95 flex items-center gap-3">
                <i class="fas fa-save text-xl"></i>
                <span class="text-xl uppercase tracking-tighter">Simpan Seluruh Konfigurasi</span>
            </button>
        </div>
    </form>
</div>

{{-- LOAD TRIX --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/2.0.10/trix.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/2.0.10/trix.umd.min.js"></script>
@endsection
