@extends('layouts.admin')

@section('title', 'Panggil Antrian Manual')

@section('content')
<div class="space-y-6 pb-12" x-data="panggilManual()">

    {{-- HERO HEADER --}}
    <div class="relative bg-gradient-to-br from-slate-900 via-blue-950 to-sky-950 rounded-3xl overflow-hidden shadow-2xl">
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute -top-16 -right-16 w-64 h-64 bg-sky-400 rounded-full blur-[80px] opacity-10"></div>
            <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-blue-400 rounded-full blur-[60px] opacity-10"></div>
        </div>
        <div class="relative z-10 px-8 py-7 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-sky-200 text-xs font-bold uppercase tracking-widest mb-3">
                    <i class="fas fa-bullhorn"></i> Sistem Antrian
                </div>
                <h1 class="text-3xl md:text-4xl font-black text-white tracking-tight">Panggil Antrian Manual</h1>
                <p class="text-sky-100/60 mt-1 text-sm">Klik nomor untuk melakukan panggilan suara TTS.</p>
            </div>
            {{-- Voice Status --}}
            <div class="flex items-center gap-3 bg-white/10 border border-white/20 rounded-2xl px-5 py-3">
                <div class="w-3 h-3 rounded-full transition-colors"
                    :class="voicesLoaded ? 'bg-emerald-400 shadow-[0_0_10px_rgba(52,211,153,0.6)]' : 'bg-red-400'"></div>
                <div>
                    <p class="text-[10px] text-sky-200 font-bold uppercase tracking-widest">Status Suara</p>
                    <p class="text-sm font-black text-white" x-text="voicesLoaded ? 'TTS Ready' : 'Loading...'"></p>
                </div>
            </div>
        </div>
    </div>

    {{-- KONTROL --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
        <div class="flex flex-wrap items-end gap-5">
            {{-- Prefix --}}
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Awalan (Prefix)</label>
                <div class="flex p-1 bg-slate-100 rounded-xl w-fit gap-1">
                    <button type="button" @click="prefix = 'A'"
                        :class="prefix === 'A' ? 'bg-blue-600 text-white shadow-md shadow-blue-500/30' : 'text-slate-500 hover:bg-slate-200'"
                        class="px-5 py-2 rounded-lg font-black text-sm transition-all">
                        <i class="fas fa-globe mr-1.5"></i> A – Online
                    </button>
                    <button type="button" @click="prefix = 'B'"
                        :class="prefix === 'B' ? 'bg-emerald-600 text-white shadow-md shadow-emerald-500/30' : 'text-slate-500 hover:bg-slate-200'"
                        class="px-5 py-2 rounded-lg font-black text-sm transition-all">
                        <i class="fas fa-user-clock mr-1.5"></i> B – Offline
                    </button>
                </div>
            </div>

            {{-- Range Antrian --}}
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Rentang Nomor Antrian</label>
                <div class="flex items-center gap-2">
                    <input type="number" x-model.number="startRange" min="1" 
                        class="w-20 px-3 py-2.5 bg-slate-50 border-2 border-slate-100 rounded-xl font-bold text-slate-700 focus:border-blue-400 focus:outline-none text-sm">
                    <span class="text-slate-400 font-bold">s/d</span>
                    <input type="number" x-model.number="endRange" min="1" 
                        class="w-20 px-3 py-2.5 bg-slate-50 border-2 border-slate-100 rounded-xl font-bold text-slate-700 focus:border-blue-400 focus:outline-none text-sm">
                </div>
            </div>

            {{-- Loket --}}
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tujuan Loket</label>
                <div class="relative">
                    <select x-model="loket" class="w-64 pl-4 pr-8 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl font-bold text-slate-700 focus:border-blue-400 focus:outline-none appearance-none cursor-pointer text-sm transition-all">
                        <option value="loket pendaftaran">Loket Pendaftaran</option>
                        <option value="ruang p2u">Ruang P2U (Masuk)</option>
                        <option value="ruang kunjungan">Ruang Kunjungan</option>
                        <option value="loket pengambilan barang">Loket Barang</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                </div>
            </div>

            {{-- Preset Buttons --}}
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Preset Range</label>
                <div class="flex flex-wrap gap-2">
                    <button @click="setRange(1, 5)" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 rounded-lg text-xs font-bold text-slate-600">1-5</button>
                    <button @click="setRange(1, 10)" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 rounded-lg text-xs font-bold text-slate-600">1-10</button>
                    <button @click="setRange(11, 20)" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 rounded-lg text-xs font-bold text-slate-600">11-20</button>
                    <button @click="setRange(21, 50)" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 rounded-lg text-xs font-bold text-slate-600">21-50</button>
                    <button @click="setRange(1, 300)" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 rounded-lg text-xs font-bold text-slate-600">Reset</button>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Aksi Massal</label>
                <div class="flex gap-2">
                    <button @click="panggilRange()" 
                        class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-black text-sm shadow-lg shadow-indigo-500/30 hover:bg-indigo-700 transition-all">
                        <i class="fas fa-users mr-2"></i> Panggil Range (<span x-text="startRange + ' s/d ' + endRange"></span>)
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- GRID NOMOR --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 xl:grid-cols-10 gap-3">
        <template x-for="n in getNumbers()" :key="n">
            <button @click="panggil(n)"
                class="group relative aspect-square bg-white rounded-2xl border-2 border-slate-100 flex flex-col items-center justify-center transition-all duration-200 overflow-hidden"
                :class="prefix === 'A'
                    ? 'hover:border-blue-500 hover:shadow-xl hover:shadow-blue-100 hover:-translate-y-1.5 active:scale-90'
                    : 'hover:border-emerald-500 hover:shadow-xl hover:shadow-emerald-100 hover:-translate-y-1.5 active:scale-90'">

                {{-- Bg corner --}}
                <div class="absolute top-0 right-0 w-8 h-8 rounded-bl-2xl transition-colors"
                    :class="prefix === 'A' ? 'bg-blue-50 group-hover:bg-blue-100' : 'bg-emerald-50 group-hover:bg-emerald-100'"></div>

                <span class="text-[9px] font-black uppercase tracking-widest mb-0.5 transition-colors"
                    :class="prefix === 'A' ? 'text-slate-300 group-hover:text-blue-400' : 'text-slate-300 group-hover:text-emerald-400'"
                    x-text="prefix"></span>
                <span class="text-2xl font-black text-slate-800 transition-colors"
                    :class="prefix === 'A' ? 'group-hover:text-blue-600' : 'group-hover:text-emerald-600'"
                    x-text="n"></span>

                <div class="absolute bottom-1.5 opacity-0 group-hover:opacity-100 transition-opacity">
                    <i class="fas fa-volume-up text-[9px]"
                        :class="prefix === 'A' ? 'text-blue-400' : 'text-emerald-400'"></i>
                </div>
            </button>
        </template>
    </div>

</div>

@push('scripts')
<script>
function panggilManual() {
    return {
        prefix: 'A',
        loket: 'loket pendaftaran',
        startRange: 1,
        endRange: 10,
        isCallingBatch: false,
        voicesLoaded: false,
        voices: [],
        init() {
            this.loadVoices();
            if (window.speechSynthesis.onvoiceschanged !== undefined) {
                window.speechSynthesis.onvoiceschanged = () => this.loadVoices();
            }
        },
        loadVoices() {
            this.voices = window.speechSynthesis.getVoices().filter(v => v.lang.includes('id-ID') || v.lang.includes('ind'));
            if (this.voices.length > 0) this.voicesLoaded = true;
        },
        setRange(start, end) {
            this.startRange = start;
            this.endRange = end;
        },
        getNumbers() {
            let nums = [];
            for (let i = this.startRange; i <= this.endRange; i++) {
                nums.push(i);
            }
            return nums;
        },
        async panggilRange() {
            const start = this.startRange;
            const end = this.endRange;
            const prefix = this.prefix;
            const type = prefix === 'A' ? 'online' : 'offline';

            // TTS Lokal
            if ('speechSynthesis' in window) {
                window.speechSynthesis.cancel();
                const text = `Nomor antrian ${prefix} ${start} sampai ${prefix} ${end} ${type}, silahkan menuju ke ${this.loket}.`;
                const utterance = new SpeechSynthesisUtterance(text);
                utterance.lang = 'id-ID';
                utterance.rate = 0.9;
                if (this.voices.length > 0) utterance.voice = this.voices[0];
                window.speechSynthesis.speak(utterance);
            }

            // Kirim ke Display via API
            try {
                await fetch('{{ route("admin.antrian.panggil-range") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        start: start,
                        end: end,
                        prefix: prefix,
                        loket: this.loket
                    })
                });
            } catch (error) {
                console.error('Gagal broadcast range:', error);
            }
        },
        async panggil(nomor) {
            return new Promise(async (resolve) => {
                // TTS Lokal
                if (!('speechSynthesis' in window)) { 
                    console.warn("Browser tidak mendukung suara.");
                    resolve();
                } else {
                    window.speechSynthesis.cancel();
                    const type = this.prefix === 'A' ? 'online' : 'offline';
                    const text = `Nomor antrian ${nomor} ${type}, silahkan menuju ke ${this.loket}.`;
                    const utterance = new SpeechSynthesisUtterance(text);
                    utterance.lang = 'id-ID';
                    utterance.rate = 0.9;
                    utterance.pitch = 1.0;
                    if (this.voices.length > 0) utterance.voice = this.voices[0];
                    
                    utterance.onend = () => resolve();
                    utterance.onerror = () => resolve();
                    
                    window.speechSynthesis.speak(utterance);
                    
                    // Safety timeout jika onend tidak terpanggil
                    setTimeout(resolve, 5000);
                }

                // Kirim ke Display via API (Fire and forget, don't wait for display)
                try {
                    fetch('{{ route("admin.antrian.panggil-spesifik") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            nomor: nomor,
                            prefix: this.prefix,
                            loket: this.loket
                        })
                    });
                } catch (error) {
                    console.error('Gagal broadcast panggilan:', error);
                }
            });
        }
    }
}
</script>
@endpush
@endsection
