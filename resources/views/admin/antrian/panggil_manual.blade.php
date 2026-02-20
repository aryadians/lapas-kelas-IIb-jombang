@extends('layouts.admin')

@section('content')
<div class="space-y-8 pb-12" x-data="panggilManual()">
    
    {{-- HEADER --}}
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 animate__animated animate__fadeInDown">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">
                <i class="fas fa-bullhorn mr-2 text-blue-600"></i> Panggil Antrian Manual
            </h1>
            <p class="text-slate-500 mt-1 font-medium">Klik pada nomor untuk melakukan panggilan suara.</p>
        </div>
        
        <div class="flex items-center gap-4 bg-white p-2 rounded-2xl shadow-sm border border-slate-200">
            <div class="flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-xl font-bold text-sm">
                <i class="fas fa-cog fa-spin mr-2 opacity-50"></i>
                Konfigurasi Suara Aktif
            </div>
        </div>
    </header>

    {{-- KONTROL PREFIX --}}
    <div class="bg-white p-6 rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 animate__animated animate__fadeInUp">
        <div class="flex flex-wrap items-center gap-6">
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Pilih Awalan (Prefix)</label>
                <div class="flex p-1 bg-slate-100 rounded-xl w-fit">
                    <button @click="prefix = 'A'" :class="prefix === 'A' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'" class="px-6 py-2 rounded-lg font-black text-sm transition-all">A (Online)</button>
                    <button @click="prefix = 'B'" :class="prefix === 'B' ? 'bg-white text-emerald-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'" class="px-6 py-2 rounded-lg font-black text-sm transition-all">B (Offline)</button>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Tujuan Loket</label>
                <select x-model="loket" class="block w-64 p-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-blue-500 focus:ring-0 font-bold text-slate-700 transition-all">
                    <option value="loket pendaftaran">Loket Pendaftaran</option>
                    <option value="ruang p2u">Ruang P2U (Masuk)</option>
                    <option value="ruang kunjungan">Ruang Kunjungan</option>
                    <option value="loket pengambilan barang">Loket Barang</option>
                </select>
            </div>

            <div class="flex-grow"></div>

            <div class="text-right">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Status Suara</p>
                <div class="flex items-center gap-2 justify-end">
                    <div class="w-3 h-3 rounded-full" :class="voicesLoaded ? 'bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.5)]' : 'bg-red-500'"></div>
                    <span class="text-sm font-bold text-slate-700" x-text="voicesLoaded ? 'Ready' : 'Loading Voices...'"></span>
                </div>
            </div>
        </div>
    </div>

    {{-- GRID NOMOR --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 xl:grid-cols-10 gap-4 animate__animated animate__fadeInUp">
        <template x-for="n in 300" :key="n">
            <button @click="panggil(n)" 
                class="group relative aspect-square bg-white rounded-3xl border-2 border-slate-100 flex flex-col items-center justify-center transition-all duration-300 hover:border-blue-500 hover:shadow-2xl hover:shadow-blue-100 hover:-translate-y-2 active:scale-90 overflow-hidden">
                
                {{-- Decorative bg --}}
                <div class="absolute top-0 right-0 w-12 h-12 bg-slate-50 rounded-bl-[2rem] group-hover:bg-blue-50 transition-colors"></div>
                
                <span class="text-[10px] font-black text-slate-300 uppercase tracking-tighter mb-1 group-hover:text-blue-400 transition-colors" x-text="prefix"></span>
                <span class="text-3xl font-black text-slate-800 group-hover:text-blue-600 transition-colors" x-text="n"></span>
                
                {{-- Hover Icon --}}
                <div class="absolute bottom-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <i class="fas fa-volume-up text-blue-500 text-xs"></i>
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
            if (this.voices.length > 0) {
                this.voicesLoaded = true;
            }
        },

        panggil(nomor) {
            if (!('speechSynthesis' in window)) {
                alert("Browser tidak mendukung suara.");
                return;
            }

            // Cancel any current speech
            window.speechSynthesis.cancel();

            const type = this.prefix === 'A' ? 'online' : 'offline';
            const text = `Nomor antrian ${nomor} ${type}, silahkan menuju ke ${this.loket}.`;
            
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'id-ID';
            utterance.rate = 0.9;
            utterance.pitch = 1.0;

            if (this.voices.length > 0) {
                utterance.voice = this.voices[0];
            }

            window.speechSynthesis.speak(utterance);

            // Optional: Kirim juga ke server agar tercatat di log/display jika diperlukan
            // Namun karena ini manual, kita fokus di suara lokal dulu.
        }
    }
}
</script>
@endpush
@endsection
