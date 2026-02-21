@extends('layouts.admin')

@php
    $visitDuration = (int) \App\Models\VisitSetting::where('key', 'visit_duration_minutes')->value('value') ?? 30;
@endphp

@push('styles')
<style>
    .timer-font { font-family: 'Roboto Mono', 'Courier New', monospace; }

    @keyframes pulse-glow {
        0%, 100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); }
        50%       { box-shadow: 0 0 0 12px rgba(239, 68, 68, 0); }
    }
    .animate-glow { animation: pulse-glow 1.5s ease-in-out infinite; }

    @keyframes card-in {
        from { opacity: 0; transform: translateY(12px) scale(0.97); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }
    .card-in { animation: card-in 0.35s ease forwards; }

    .queue-card {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .queue-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 32px -8px rgba(0,0,0,0.12);
    }

    /* Custom scrollbar for completed list */
    .thin-scroll::-webkit-scrollbar { width: 4px; }
    .thin-scroll::-webkit-scrollbar-track { background: transparent; }
    .thin-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 2px; }
</style>
@endpush

@section('content')
<div class="space-y-6 pb-12" x-data="queueControl()">

    {{-- HERO HEADER --}}
    <div class="relative bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 rounded-3xl overflow-hidden shadow-2xl">
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-500 rounded-full blur-[100px] opacity-10"></div>
            <div class="absolute -bottom-16 -left-16 w-64 h-64 bg-indigo-400 rounded-full blur-[80px] opacity-10"></div>
        </div>
        <div class="relative z-10 px-8 py-7 flex flex-col md:flex-row items-start md:items-center justify-between gap-5">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-blue-200 text-xs font-bold uppercase tracking-widest mb-3">
                    <i class="fas fa-tower-broadcast"></i> Real-time Queue Control
                </div>
                <h1 class="text-3xl md:text-4xl font-black text-white tracking-tight">
                    Ruang Kontrol Antrian
                </h1>
                <p class="text-blue-100/60 mt-1 text-sm">Manajemen alur kunjungan secara real-time untuk hari ini.</p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                {{-- Live Status --}}
                <div class="flex items-center gap-2 bg-white/10 border border-white/20 rounded-2xl px-4 py-2.5">
                    <div class="w-2.5 h-2.5 rounded-full" :class="isPolling ? 'bg-emerald-400 animate-pulse' : 'bg-red-400'"></div>
                    <span class="text-sm font-bold text-white" x-text="isPolling ? 'Real-time Aktif' : 'Terputus'"></span>
                </div>
                {{-- Queue summary badges --}}
                <div class="flex items-center gap-2">
                    <div class="bg-white/10 border border-white/20 rounded-2xl px-4 py-2.5 text-center min-w-16">
                        <p class="text-xl font-black text-white" x-text="queues.waiting.length">0</p>
                        <p class="text-[10px] text-blue-200 font-bold uppercase tracking-widest">Tunggu</p>
                    </div>
                    <div class="bg-emerald-500/20 border border-emerald-400/30 rounded-2xl px-4 py-2.5 text-center min-w-16">
                        <p class="text-xl font-black text-emerald-300" x-text="queues.in_progress.length">0</p>
                        <p class="text-[10px] text-emerald-300 font-bold uppercase tracking-widest">Berlangsung</p>
                    </div>
                    <div class="bg-slate-700/50 border border-slate-600/30 rounded-2xl px-4 py-2.5 text-center min-w-16">
                        <p class="text-xl font-black text-slate-300" x-text="queues.completed.length">0</p>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Selesai</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- QUEUE GRID --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- ═══ DAFTAR TUNGGU (2/3) ═══ --}}
        <div class="xl:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            {{-- Header --}}
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600">
                        <i class="fas fa-hourglass-half text-sm"></i>
                    </div>
                    <div>
                        <h2 class="font-black text-slate-800 text-sm">Daftar Tunggu</h2>
                        <p class="text-xs text-slate-400">Kunjungan antre masuk ruangan</p>
                    </div>
                </div>
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-amber-100 text-amber-700 font-black text-sm" x-text="queues.waiting.length">0</span>
            </div>

            {{-- Cards Grid --}}
            <div class="p-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" id="waiting-list">
                    <template x-for="kunjungan in queues.waiting" :key="kunjungan.id">
                        <div class="queue-card card-in bg-slate-50 border border-slate-200 rounded-2xl p-4 flex flex-col gap-3">

                            {{-- Number & Session --}}
                            <div class="flex items-center justify-between">
                                <span class="font-black text-slate-800 bg-white border border-slate-200 px-3 py-1.5 rounded-xl text-sm shadow-sm tracking-widest"
                                    x-text="(kunjungan.registration_type === 'offline' ? 'B' : 'A') + '-' + kunjungan.nomor_antrian_harian.toString().padStart(3, '0')">
                                </span>
                                <span class="text-[10px] font-black uppercase tracking-widest px-2.5 py-1 rounded-full"
                                    :class="kunjungan.sesi === 'pagi'
                                        ? 'bg-orange-100 text-orange-600'
                                        : 'bg-sky-100 text-sky-600'"
                                    x-text="kunjungan.sesi === 'pagi' ? '☀ Pagi' : '🌤 Siang'">
                                </span>
                            </div>

                            {{-- Visitor Info --}}
                            <div class="text-center py-1">
                                <p class="font-black text-slate-800 text-base leading-tight" x-text="kunjungan.nama_pengunjung"></p>
                                <p class="text-xs text-slate-400 mt-1">
                                    <i class="fas fa-user-lock mr-1"></i>
                                    <span x-text="kunjungan.wbp ? kunjungan.wbp.nama : '-'"></span>
                                </p>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="grid grid-cols-3 gap-2 pt-2 border-t border-slate-200">
                                {{-- Panggil Pengunjung --}}
                                <button @click="speakVisitor(kunjungan)"
                                    class="flex flex-col items-center justify-center gap-1 py-2.5 rounded-xl bg-blue-50 hover:bg-blue-500 border-2 border-blue-100 hover:border-blue-500 text-blue-600 hover:text-white transition-all duration-200 hover:shadow-lg hover:shadow-blue-500/30 active:scale-95"
                                    title="Panggil Pengunjung">
                                    <i class="fas fa-bullhorn text-base"></i>
                                    <span class="text-[9px] font-black uppercase tracking-widest leading-none">Panggil</span>
                                </button>
                                {{-- Panggil WBP --}}
                                <button @click="speakInmate(kunjungan)"
                                    class="flex flex-col items-center justify-center gap-1 py-2.5 rounded-xl bg-indigo-50 hover:bg-indigo-500 border-2 border-indigo-100 hover:border-indigo-500 text-indigo-600 hover:text-white transition-all duration-200 hover:shadow-lg hover:shadow-indigo-500/30 active:scale-95"
                                    title="Panggil WBP">
                                    <i class="fas fa-user-lock text-base"></i>
                                    <span class="text-[9px] font-black uppercase tracking-widest leading-none">WBP</span>
                                </button>
                                {{-- Mulai Kunjungan --}}
                                <button @click="startVisit(kunjungan.id)"
                                    class="flex flex-col items-center justify-center gap-1 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 border-2 border-emerald-600 text-white transition-all duration-200 hover:shadow-lg hover:shadow-emerald-500/30 active:scale-95"
                                    title="Mulai Kunjungan">
                                    <i class="fas fa-play text-base"></i>
                                    <span class="text-[9px] font-black uppercase tracking-widest leading-none">Mulai</span>
                                </button>
                            </div>
                        </div>
                    </template>

                    {{-- Empty State --}}
                    <template x-if="queues.waiting.length === 0">
                        <div class="col-span-full py-20 text-center">
                            <div class="w-16 h-16 bg-slate-100 rounded-3xl flex items-center justify-center text-slate-300 text-3xl mx-auto mb-3">
                                <i class="fas fa-inbox"></i>
                            </div>
                            <h3 class="font-black text-slate-600 text-sm">Tidak Ada Antrian</h3>
                            <p class="text-xs text-slate-400 mt-1">Tidak ada kunjungan yang menunggu saat ini.</p>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        {{-- ═══ SIDEBAR (1/3) ═══ --}}
        <div class="xl:col-span-1 space-y-5">

            {{-- IN PROGRESS PANEL --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600">
                            <i class="fas fa-comments text-sm"></i>
                        </div>
                        <div>
                            <h2 class="font-black text-slate-800 text-sm">Sedang Berlangsung</h2>
                            <p class="text-xs text-slate-400">Di dalam ruang kunjungan</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 font-black text-sm" x-text="queues.in_progress.length">0</span>
                </div>

                <div class="p-4 space-y-3" id="in-progress-list">
                    <template x-for="kunjungan in queues.in_progress" :key="kunjungan.id">
                        <div class="queue-card card-in rounded-2xl border-2 p-4 transition-all"
                            :class="timers[kunjungan.id] && timers[kunjungan.id].isEnding
                                ? 'border-red-400 bg-red-50 animate-glow'
                                : 'border-emerald-200 bg-emerald-50'">

                            {{-- Header row --}}
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <p class="font-black text-slate-800 text-sm leading-tight" x-text="kunjungan.nama_pengunjung"></p>
                                    <p class="text-[11px] text-slate-500 mt-0.5">
                                        <i class="fas fa-user-lock mr-1"></i>
                                        <span x-text="kunjungan.wbp ? kunjungan.wbp.nama : '-'"></span>
                                    </p>
                                </div>
                                <span class="font-black text-emerald-700 bg-white border border-emerald-200 px-2.5 py-1 rounded-xl text-xs shadow-sm"
                                    x-text="(kunjungan.registration_type === 'offline' ? 'B' : 'A') + '-' + kunjungan.nomor_antrian_harian.toString().padStart(3, '0')">
                                </span>
                            </div>

                            {{-- Timer --}}
                            <div class="rounded-xl p-3 text-center mb-3 transition-colors"
                                :class="timers[kunjungan.id] && timers[kunjungan.id].isEnding ? 'bg-red-600' : 'bg-slate-900'">
                                <p class="text-[10px] uppercase tracking-widest mb-1"
                                    :class="timers[kunjungan.id] && timers[kunjungan.id].isEnding ? 'text-red-200' : 'text-slate-400'"
                                    x-text="timers[kunjungan.id] && timers[kunjungan.id].isFinished ? 'Waktu Habis!' : 'Sisa Waktu'">
                                </p>
                                <p class="text-3xl font-black timer-font tracking-widest text-white"
                                    x-text="timers[kunjungan.id] ? timers[kunjungan.id].display : '{{ str_pad($visitDuration, 2, '0', STR_PAD_LEFT) }}:00'">
                                </p>
                            </div>

                            {{-- Finish Button --}}
                            <button @click="finishVisit(kunjungan.id)"
                                class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl bg-red-100 hover:bg-red-500 border-2 border-red-200 hover:border-red-500 text-red-600 hover:text-white font-bold text-sm transition-all duration-200 active:scale-95 hover:shadow-lg hover:shadow-red-500/30">
                                <i class="fas fa-stop-circle"></i>
                                Selesaikan Kunjungan
                            </button>
                        </div>
                    </template>

                    <template x-if="queues.in_progress.length === 0">
                        <div class="py-10 text-center">
                            <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-300 text-xl mx-auto mb-2">
                                <i class="fas fa-door-open"></i>
                            </div>
                            <p class="text-xs font-bold text-slate-400">Tidak ada kunjungan berlangsung</p>
                        </div>
                    </template>
                </div>
            </div>

            {{-- COMPLETED PANEL --}}
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl overflow-hidden shadow-sm border border-slate-700/50">
                <div class="px-5 py-4 border-b border-white/10 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-white/10 rounded-xl flex items-center justify-center text-slate-300">
                            <i class="fas fa-flag-checkered text-sm"></i>
                        </div>
                        <div>
                            <h2 class="font-black text-white text-sm">Selesai Hari Ini</h2>
                            <p class="text-xs text-slate-400">Kunjungan telah rampung</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white/10 text-slate-300 font-black text-sm" x-text="queues.completed.length">0</span>
                </div>

                <div class="p-4 space-y-2 max-h-56 overflow-y-auto thin-scroll">
                    <template x-for="kunjungan in queues.completed" :key="kunjungan.id">
                        <div class="flex items-center justify-between p-2.5 rounded-xl bg-white/5 hover:bg-white/10 transition-colors group">
                            <div class="flex items-center gap-2 min-w-0">
                                <div class="w-6 h-6 rounded-lg bg-emerald-500/20 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check text-emerald-400 text-[9px]"></i>
                                </div>
                                <p class="text-sm font-semibold text-slate-300 truncate" x-text="kunjungan.nama_pengunjung"></p>
                            </div>
                            <span class="font-black text-slate-500 bg-white/10 px-2 py-0.5 rounded-lg text-[11px] flex-shrink-0 ml-2"
                                x-text="(kunjungan.registration_type === 'offline' ? 'B' : 'A') + '-' + kunjungan.nomor_antrian_harian.toString().padStart(3, '0')">
                            </span>
                        </div>
                    </template>

                    <template x-if="queues.completed.length === 0">
                        <div class="py-8 text-center">
                            <i class="fas fa-moon text-2xl text-slate-600 mb-2 block"></i>
                            <p class="text-sm text-slate-500">Belum ada kunjungan selesai.</p>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function queueControl() {
    return {
        queues: { waiting: [], in_progress: [], completed: [] },
        timers: {},
        isPolling: false,
        voices: [],
        finishing: [],
        speechQueue: [],
        isSpeaking: false,

        init() {
            this.fetchState();
            setInterval(() => this.fetchState(), 5000);
            setInterval(() => this.updateTimers(), 1000);
            this.loadVoices();
            
            if (window.speechSynthesis.onvoiceschanged !== undefined) {
                window.speechSynthesis.onvoiceschanged = () => this.loadVoices();
            }

            setInterval(() => this.processSpeechQueue(), 300);

            const unlock = () => {
                const silence = new SpeechSynthesisUtterance("");
                window.speechSynthesis.speak(silence);
                document.removeEventListener('click', unlock);
            };
            document.addEventListener('click', unlock);
        },

        async fetchState() {
            this.isPolling = true;
            try {
                const response = await fetch('{{ route("admin.api.antrian.state") }}');
                if (!response.ok) throw new Error(`Server error: ${response.statusText}`);
                const data = await response.json();
                this.queues.waiting = data.waiting;
                this.queues.in_progress = data.in_progress;
                this.queues.completed = data.completed;
            } catch (error) {
                console.error('Error fetching queue state:', error);
                this.isPolling = false;
            }
        },

        async startVisit(id) {
            try {
                const response = await this.postData(`{{ url('api/admin/antrian') }}/${id}/start`);
                if (!response.success) {
                    Swal.fire('Gagal', response.error || 'Gagal memulai kunjungan.', 'error');
                }
                await this.fetchState();
            } catch(error) {
                Swal.fire('Error', `Terjadi kesalahan koneksi: ${error.message}`, 'error');
            }
        },

        async finishVisitApi(id) {
            if (this.finishing.includes(id)) return;
            try {
                this.finishing.push(id);
                const response = await this.postData(`{{ url('api/admin/antrian') }}/${id}/finish`);
                if (response.success) {
                    delete this.timers[id];
                } else {
                    Swal.fire('Gagal', response.error || 'Gagal menyelesaikan kunjungan.', 'error');
                }
                await this.fetchState();
            } catch (error) {
                Swal.fire('Error', `Terjadi kesalahan koneksi: ${error.message}`, 'error');
            } finally {
                this.finishing = this.finishing.filter(i => i !== id);
            }
        },

        finishVisit(id) {
            const kunjungan = this.queues.in_progress.find(k => k.id === id);
            if (kunjungan) {
                this.speak(`Kunjungan atas nama ${kunjungan.nama_pengunjung} telah diselesaikan secara manual.`, true);
            }
            this.finishVisitApi(id);
        },

        updateTimers() {
            const newlyFinished = [];
            this.queues.in_progress.forEach(kunjungan => {
                if (!kunjungan.visit_started_at) return;
                const startTime = new Date(kunjungan.visit_started_at).getTime();
                const now = new Date().getTime();
                const elapsed = Math.floor((now - startTime) / 1000);
                const visitDuration = {{ $visitDuration }} * 60;
                const remaining = visitDuration - elapsed;

                if (remaining <= 0) {
                    if (!this.timers[kunjungan.id] || !this.timers[kunjungan.id].isFinished) {
                        this.timers[kunjungan.id] = { display: 'WAKTU HABIS', isEnding: true, isFinished: true };
                        newlyFinished.push(kunjungan);
                    }
                } else {
                    const minutes = Math.floor(remaining / 60).toString().padStart(2, '0');
                    const seconds = (remaining % 60).toString().padStart(2, '0');
                    this.timers[kunjungan.id] = {
                        display: `${minutes}:${seconds}`,
                        isEnding: remaining < 120,
                        isFinished: false
                    };
                }
            });

            if (newlyFinished.length > 0) {
                newlyFinished.forEach(kunjungan => {
                    this.finishVisitApi(kunjungan.id);
                    const prefix = kunjungan.registration_type === 'offline' ? 'B' : 'A';
                    const queueNumber = prefix + ' ' + kunjungan.nomor_antrian_harian;
                    const wbpName = kunjungan.wbp ? kunjungan.wbp.nama : 'Warga Binaan';
                    const message = `Waktu kunjungan untuk ${kunjungan.nama_pengunjung}, nomor antrian ${queueNumber}, dengan WBP ${wbpName} telah selesai. Silahkan meninggalkan tempat kunjungan.`;
                    this.speak(message);
                });
            }
        },

        speak(text, priority = false) {
            if (!('speechSynthesis' in window)) return;
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'id-ID';
            utterance.rate = 1.0;
            utterance.pitch = 1.0;
            if (this.voices.length > 0) {
                utterance.voice = this.voices[0];
            } else {
                const allVoices = window.speechSynthesis.getVoices();
                const idVoice = allVoices.find(v => v.lang.includes('id-ID') || v.lang.includes('ind'));
                if (idVoice) utterance.voice = idVoice;
            }
            utterance.onend = () => { setTimeout(() => { this.isSpeaking = false; }, 1500); };
            if (priority) {
                window.speechSynthesis.cancel();
                this.speechQueue.unshift(utterance);
                this.isSpeaking = false;
            } else {
                this.speechQueue.push(utterance);
            }
        },

        processSpeechQueue() {
            if (this.isSpeaking || this.speechQueue.length === 0) return;
            this.isSpeaking = true;
            const utteranceToSpeak = this.speechQueue.shift();
            window.speechSynthesis.speak(utteranceToSpeak);
        },

        loadVoices() {
            if ('speechSynthesis' in window) {
                const getVoices = () => {
                    this.voices = window.speechSynthesis.getVoices().filter(v => v.lang === 'id-ID');
                };
                getVoices();
                if (window.speechSynthesis.onvoiceschanged !== undefined) {
                    window.speechSynthesis.onvoiceschanged = getVoices;
                }
            }
        },

        speakVisitor(kunjungan) {
            const type = kunjungan.registration_type === 'offline' ? 'offline' : 'online';
            const text = `Panggilan untuk pengunjung dengan nomor antrian ${kunjungan.nomor_antrian_harian} ${type}, atas nama ${kunjungan.nama_pengunjung}. silahkan untuk menuju ruang p2u.`;
            this.speak(text, true);
            this.postData(`{{ url('api/admin/antrian') }}/${kunjungan.id}/call`)
                .catch(err => console.error('Gagal mengirim sinyal panggil:', err));
        },

        speakInmate(kunjungan) {
            const wbpName = kunjungan.wbp ? kunjungan.wbp.nama : 'Warga Binaan';
            const text = `Panggilan untuk Warga Binaan atas nama ${wbpName}. Ditunggu di ruang kunjungan sekarang.`;
            this.speak(text, true);
        },

        async postData(url = '', data = {}) {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            });
            if (!response.ok) {
                const errorText = await response.text();
                try {
                    const errorJson = JSON.parse(errorText);
                    throw new Error(errorJson.error || 'Terjadi error di server.');
                } catch (e) {
                    throw new Error(errorText || `HTTP error! status: ${response.status}`);
                }
            }
            return response.json();
        }
    }
}
</script>
@endpush
