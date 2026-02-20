@extends('layouts.admin')

@push('styles')
<style>
    /* 3D Card Effect */
    .card-3d {
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        transform-style: preserve-3d;
        backface-visibility: hidden;
    }
    .card-3d:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        z-index: 10;
    }
    .timer-font {
        font-family: 'Roboto Mono', 'Courier New', monospace;
    }
    .animate-glow {
        animation: glow 1.5s ease-in-out infinite alternate;
    }
    @keyframes glow {
        from { box-shadow: 0 0 10px -5px #ef4444; }
        to { box-shadow: 0 0 20px 5px #ef4444; }
    }
    /* 3D Button Effect */
    .btn-3d {
        transition: all 0.2s cubic-bezier(0.25, 0.8, 0.25, 1);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .btn-3d:hover {
        transform: translateY(-2px) scale(1.03);
        box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    }
</style>
@endpush

@section('content')
<div class="space-y-8 pb-12" x-data="queueControl()">

    {{-- HEADER --}}
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 animate__animated animate__fadeInDown">
        <div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gradient">
                <i class="fas fa-desktop mr-2"></i> Ruang Kontrol Antrian
            </h1>
            <p class="text-slate-500 mt-2 font-medium">Manajemen alur kunjungan secara real-time untuk hari ini.</p>
        </div>
        <div class="flex items-center gap-2 text-sm font-bold text-slate-500 bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm">
            <div class="w-3 h-3 rounded-full" :class="isPolling ? 'bg-green-500 animate-pulse' : 'bg-red-500'"></div>
            <span x-text="isPolling ? 'Status: Real-time Aktif' : 'Status: Terputus'"></span>
        </div>
    </header>

    {{-- QUEUE GRID --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 animate__animated animate__fadeInUp">
        
        <!-- MAIN QUEUE (WAITING) - 2/3 width -->
        <div class="lg:col-span-2 bg-slate-100 rounded-2xl p-4 sm:p-6">
            <h2 class="font-bold text-slate-800 text-xl mb-4 p-2 rounded-lg bg-slate-200 flex items-center justify-between">
                <span><i class="fas fa-hourglass-half mr-2 text-slate-500"></i> Daftar Tunggu</span>
                <span class="bg-slate-600 text-white text-sm font-bold w-8 h-8 flex items-center justify-center rounded-full" x-text="queues.waiting.length"></span>
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4" id="waiting-list">
                <template x-for="kunjungan in queues.waiting" :key="kunjungan.id">
                    <div class="card-3d bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex flex-col">
                        <div class="flex-grow">
                             <div class="flex justify-between items-start">
                                <span class="font-extrabold text-slate-700 bg-slate-200 px-3 py-1 rounded-lg text-sm" x-text="(kunjungan.registration_type === 'offline' ? 'B-' : 'A-') + kunjungan.nomor_antrian_harian.toString().padStart(3, '0')"></span>
                                <span class="text-xs font-bold text-purple-600 uppercase" x-text="kunjungan.sesi"></span>
                            </div>
                            <div class="mt-3 text-center">
                                <p class="font-bold text-slate-800 text-lg" x-text="kunjungan.nama_pengunjung"></p>
                                <p class="text-xs text-slate-500">WBP: <span x-text="kunjungan.wbp ? kunjungan.wbp.nama : '-'"></span></p>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-100">
                            <div class="grid grid-cols-3 gap-2">
                                <button @click="speakVisitor(kunjungan)" title="Panggil Pengunjung & Antrian" class="btn-3d w-full h-12 bg-blue-100 text-blue-600 font-bold rounded-lg hover:bg-blue-200 active:scale-95 flex items-center justify-center">
                                    <i class="fas fa-bullhorn text-xl"></i>
                                </button>
                                <button @click="speakInmate(kunjungan)" title="Panggil WBP" class="btn-3d w-full h-12 bg-indigo-100 text-indigo-600 font-bold rounded-lg hover:bg-indigo-200 active:scale-95 flex items-center justify-center">
                                    <i class="fas fa-user-lock text-xl"></i>
                                </button>
                                <button @click="startVisit(kunjungan.id)" title="Mulai Kunjungan" class="btn-3d w-full h-12 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 active:scale-95 flex items-center justify-center">
                                    <i class="fas fa-play text-xl"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
                <template x-if="queues.waiting.length === 0">
                    <div class="col-span-full text-center py-20 text-slate-400">
                        <i class="fas fa-inbox text-5xl mb-3"></i>
                        <p class="text-lg font-medium">Tidak ada antrian menunggu.</p>
                    </div>
                </template>
            </div>
        </div>

        <!-- SIDEBAR (IN PROGRESS & COMPLETED) - 1/3 width -->
        <div class="lg:col-span-1 space-y-8">
            <!-- IN PROGRESS -->
            <div class="bg-green-50 rounded-2xl p-4 sm:p-6">
                <h2 class="font-bold text-green-800 text-xl mb-4 p-2 rounded-lg bg-green-200 flex items-center justify-between">
                    <span><i class="fas fa-comments mr-2 text-green-600"></i> Sedang Berkunjung</span>
                    <span class="bg-green-600 text-white text-sm font-bold w-8 h-8 flex items-center justify-center rounded-full" x-text="queues.in_progress.length"></span>
                </h2>
                <div class="space-y-4" id="in-progress-list">
                    <template x-for="kunjungan in queues.in_progress" :key="kunjungan.id">
                        <div class="card-3d bg-white p-4 rounded-xl border-2 shadow-lg" :class="timers[kunjungan.id] && timers[kunjungan.id].isEnding ? 'border-red-500 animate-glow' : 'border-green-300'">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <p class="font-bold text-slate-800" x-text="kunjungan.nama_pengunjung"></p>
                                    <p class="text-xs text-slate-500">WBP: <span x-text="kunjungan.wbp ? kunjungan.wbp.nama : '-'"></span></p>
                                </div>
                                <span class="font-extrabold text-green-700 bg-green-100 px-3 py-1 rounded-lg text-sm" x-text="(kunjungan.registration_type === 'offline' ? 'B-' : 'A-') + kunjungan.nomor_antrian_harian.toString().padStart(3, '0')"></span>
                            </div>
                            <div class="mt-3 text-center bg-gray-900 text-white rounded-lg p-3" :class="timers[kunjungan.id] && timers[kunjungan.id].isEnding ? 'bg-red-600' : 'bg-gray-900'">
                                <p class="text-xs uppercase text-gray-400" x-text="timers[kunjungan.id] && timers[kunjungan.id].isFinished ? 'Waktu Habis' : 'Sisa Waktu'"></p>
                                <p class="text-4xl font-bold timer-font tracking-wider" x-text="timers[kunjungan.id] ? timers[kunjungan.id].display : '30:00'"></p>
                            </div>
                             <button @click="finishVisit(kunjungan.id)" class="w-full mt-3 bg-red-100 text-red-600 font-bold py-2 rounded-lg hover:bg-red-200 transition-all active:scale-95 flex items-center justify-center gap-2 text-sm">
                                <i class="fas fa-stop-circle"></i> Selesaikan Sekarang
                            </button>
                        </div>
                    </template>
                     <template x-if="queues.in_progress.length === 0">
                        <div class="text-center py-20 text-green-400">
                            <i class="fas fa-inbox text-5xl mb-3"></i>
                            <p class="text-lg font-medium">Tidak ada kunjungan berlangsung.</p>
                        </div>
                    </template>
                </div>
            </div>
            <!-- COMPLETED -->
            <div class="bg-gray-800 rounded-2xl p-4 sm:p-6">
                <h2 class="font-bold text-white text-lg mb-4 p-2 rounded-lg bg-gray-700 flex items-center justify-between">
                    <span><i class="fas fa-check-circle mr-2 text-gray-400"></i> Selesai Hari Ini</span>
                    <span class="bg-gray-500 text-white text-xs font-bold w-8 h-8 flex items-center justify-center rounded-full" x-text="queues.completed.length"></span>
                </h2>
                <div class="space-y-2 max-h-48 overflow-y-auto pr-2">
                     <template x-for="kunjungan in queues.completed" :key="kunjungan.id">
                         <div class="bg-gray-700 p-2 rounded-lg flex justify-between items-center opacity-70">
                            <p class="font-medium text-gray-300 text-sm" x-text="kunjungan.nama_pengunjung"></p>
                            <span class="font-bold text-gray-400 bg-gray-600 px-2 py-0.5 rounded-md text-xs" x-text="(kunjungan.registration_type === 'offline' ? 'B-' : 'A-') + kunjungan.nomor_antrian_harian.toString().padStart(3, '0')"></span>
                        </div>
                    </template>
                     <template x-if="queues.completed.length === 0">
                        <div class="text-center py-10 text-gray-500">
                            <i class="fas fa-inbox text-3xl mb-2"></i>
                            <p class="text-sm">Belum ada kunjungan selesai.</p>
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
            
            // Re-load voices if they change (important for mobile)
            if (window.speechSynthesis.onvoiceschanged !== undefined) {
                window.speechSynthesis.onvoiceschanged = () => this.loadVoices();
            }

            // Start the queue processor check
            setInterval(() => this.processSpeechQueue(), 300);

            // Audio Unlocker for Mobile
            const unlock = () => {
                const silence = new SpeechSynthesisUtterance("");
                window.speechSynthesis.speak(silence);
                document.removeEventListener('click', unlock);
                console.log("Audio Unlocked for Mobile");
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
                console.error('Error starting visit:', error);
                Swal.fire('Error', `Terjadi kesalahan koneksi: ${error.message}`, 'error');
            }
        },

        async finishVisitApi(id) {
            if (this.finishing.includes(id)) {
                return;
            }
            try {
                this.finishing.push(id);
                const response = await this.postData(`{{ url('api/admin/antrian') }}/${id}/finish`);
                if (response.success) {
                    delete this.timers[id];
                } else {
                     Swal.fire('Gagal', response.error || 'Gagal menyelesaikan kunjungan via API.', 'error');
                }
                await this.fetchState();
            } catch (error) {
                console.error('Error finishing visit via API:', error);
                Swal.fire('Error', `Terjadi kesalahan koneksi: ${error.message}`, 'error');
            } finally {
                this.finishing = this.finishing.filter(i => i !== id);
            }
        },
        
        // Wrapper for manual finish button
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
                const visitDuration = 30 * 60;
                const remaining = visitDuration - elapsed;

                if (remaining <= 0) {
                    if (!this.timers[kunjungan.id] || !this.timers[kunjungan.id].isFinished) {
                        this.timers[kunjungan.id] = { display: 'WAKTU HABIS', isEnding: true, isFinished: true };
                        // Don't call finishVisit directly, queue it up
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

            // Now process all newly finished visits
            if (newlyFinished.length > 0) {
                newlyFinished.forEach(kunjungan => {
                    // Call the API to mark as finished
                    this.finishVisitApi(kunjungan.id);
                    // Add the notification to the speech queue
                    const visitorName = kunjungan.nama_pengunjung;
                    const prefix = kunjungan.registration_type === 'offline' ? 'B' : 'A';
                    const queueNumber = prefix + ' ' + kunjungan.nomor_antrian_harian;
                    const wbpName = kunjungan.wbp ? kunjungan.wbp.nama : 'Warga Binaan';
                    const message = `Waktu kunjungan untuk ${visitorName}, nomor antrian ${queueNumber}, dengan WBP ${wbpName} telah selesai. Silahkan meninggalkan tempat kunjungan.`;
                    this.speak(message);
                });
            }
        },

        // --- SPEECH SYNTHESIS QUEUE SYSTEM ---
        speak(text, priority = false) {
            if (!('speechSynthesis' in window)) return;
            
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'id-ID';
            utterance.rate = 1.0;
            utterance.pitch = 1.0;

            // Pastikan memilih suara Indonesia
            if (this.voices.length > 0) {
                utterance.voice = this.voices[0];
            } else {
                const allVoices = window.speechSynthesis.getVoices();
                const idVoice = allVoices.find(v => v.lang.includes('id-ID') || v.lang.includes('ind'));
                if (idVoice) utterance.voice = idVoice;
            }

            // Handle onend event to manage queue
            utterance.onend = () => {
                setTimeout(() => {
                    this.isSpeaking = false;
                }, 1500); 
            };
            
            if (priority) {
                window.speechSynthesis.cancel();
                this.speechQueue.unshift(utterance);
                this.isSpeaking = false;
            } else {
                this.speechQueue.push(utterance);
            }
        },

        processSpeechQueue() {
            if (this.isSpeaking || this.speechQueue.length === 0) {
                return;
            }
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
            const prefix = kunjungan.registration_type === 'offline' ? 'B' : 'A';
            const text = `Panggilan untuk pengunjung dengan nomor antrian ${prefix} ${kunjungan.nomor_antrian_harian}, atas nama ${kunjungan.nama_pengunjung}. silahkan untuk menuju ruang p2u.`;
            this.speak(text, true); // Priority call
            
            // Trigger Remote Call (TV Display)
            this.postData(`{{ url('api/admin/antrian') }}/${kunjungan.id}/call`)
                .catch(err => console.error('Gagal mengirim sinyal panggil ke server:', err));
        },

        speakInmate(kunjungan) {
            const wbpName = kunjungan.wbp ? kunjungan.wbp.nama : 'Warga Binaan';
            const text = `Panggilan untuk Warga Binaan atas nama ${wbpName}. Ditunggu di ruang kunjungan sekarang.`;
            this.speak(text, true); // Priority call
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
