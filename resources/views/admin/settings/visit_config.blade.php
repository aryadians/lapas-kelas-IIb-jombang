@extends('layouts.admin')

@section('content')
<div class="space-y-8 pb-12">
    {{-- HEADER --}}
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 animate__animated animate__fadeInDown">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">
                ⚙️ Konfigurasi Sistem Kunjungan
            </h1>
            <p class="text-slate-500 mt-1 font-medium">Kelola jadwal operasional, kuota, dan batasan pendaftaran.</p>
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

    <form action="{{ route('admin.settings.visit-config.update') }}" method="POST" class="space-y-8">
        @csrf
        
        {{-- SECTION 1: JADWAL HARIAN & KUOTA --}}
        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden animate__animated animate__fadeInUp">
            <div class="bg-slate-50 px-8 py-6 border-b border-slate-100 flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-200">
                    <i class="fas fa-calendar-alt text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-black text-slate-800 uppercase tracking-tight">Jadwal Operasional & Kuota</h2>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Atur ketersediaan hari dan jumlah pengunjung</p>
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
                                <td class="py-6">
                                    <span class="font-black text-lg text-slate-800">{{ $schedule->day_name }}</span>
                                </td>
                                <td class="py-6 text-center">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="schedules[{{ $schedule->id }}][is_open]" value="1" class="sr-only peer" {{ $schedule->is_open ? 'checked' : '' }}>
                                        <div class="w-14 h-7 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-emerald-500"></div>
                                    </label>
                                    <p class="text-[10px] mt-1 font-bold text-slate-400 peer-checked:text-emerald-600 uppercase">
                                        {{ $schedule->is_open ? 'Buka' : 'Tutup' }}
                                    </p>
                                </td>
                                <td class="py-6">
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
                                <td class="py-6">
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

        {{-- SECTION 2: PEMBATASAN GLOBAL & TIMING --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Batasan Frekuensi --}}
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden animate__animated animate__fadeInLeft">
                <div class="bg-slate-50 px-8 py-6 border-b border-slate-100 flex items-center gap-4">
                    <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                        <i class="fas fa-user-shield text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-slate-800 uppercase tracking-tight">Batasan Frekuensi</h2>
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
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden animate__animated animate__fadeInRight">
                <div class="bg-slate-50 px-8 py-6 border-b border-slate-100 flex items-center gap-4">
                    <div class="w-12 h-12 bg-rose-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-rose-200">
                        <i class="fas fa-history text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-slate-800 uppercase tracking-tight">Waktu & Fitur Edit</h2>
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
                        <div class="space-y-2" x-show="true"> {{-- Bisa ditambahkan logic x-show jika perlu --}}
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

        {{-- SECTION 3: ATURAN PENGUNJUNG & DURASI --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Pembatasan & Durasi --}}
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden animate__animated animate__fadeInUp">
                <div class="bg-slate-50 px-8 py-6 border-b border-slate-100 flex items-center gap-4">
                    <div class="w-12 h-12 bg-teal-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-teal-200">
                        <i class="fas fa-users-cog text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-slate-800 uppercase tracking-tight">Aturan Pengunjung & Durasi</h2>
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
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-red-200/30 border border-slate-100 ring-4 ring-slate-50 overflow-hidden animate__animated animate__fadeInUp delay-100">
                <div class="bg-red-50 px-8 py-6 border-b border-red-100 flex items-center gap-4">
                    <div class="w-12 h-12 bg-red-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-red-200">
                        <i class="fas fa-exclamation-triangle text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-red-800 uppercase tracking-tight">Mode Darurat & Tutup</h2>
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

        {{-- SAVE BUTTON --}}
        <div class="flex justify-center pt-4">
            <button type="submit" class="bg-slate-900 text-white font-black px-12 py-5 rounded-[2rem] shadow-2xl hover:bg-blue-600 hover:-translate-y-1 transition-all active:scale-95 flex items-center gap-3">
                <i class="fas fa-save text-xl"></i>
                <span class="text-xl uppercase tracking-tighter">Simpan Seluruh Konfigurasi</span>
            </button>
        </div>
    </form>
</div>
@endsection
