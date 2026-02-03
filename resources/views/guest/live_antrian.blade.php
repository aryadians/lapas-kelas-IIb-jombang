@extends('layouts.main')

@section('content')
<section class="relative bg-slate-900 text-white min-h-screen flex items-center justify-center overflow-hidden">
    {{-- Background Pattern --}}
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900 via-blue-900 to-slate-900"></div>
    </div>

    <div class="container mx-auto px-6 text-center relative z-10">

        <div class="max-w-4xl mx-auto">
            {{-- Header --}}
            <div class="mb-12 animate-fade-in-down">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-2xl shadow-lg mb-6 border-2 border-yellow-300/50">
                    <i class="fa-solid fa-satellite-dish text-4xl text-white"></i>
                </div>
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-black mb-4 tracking-tight">
                    Monitor Antrian <span class="text-yellow-400">Live</span>
                </h1>
                <p class="text-lg sm:text-xl text-slate-300 max-w-2xl mx-auto">
                    Nomor antrian yang sedang dipanggil saat ini. Halaman akan diperbarui secara otomatis.
                </p>
            </div>

            {{-- Queue Display Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 animate-fade-in-up" style="animation-delay: 0.2s;">
                {{-- Sesi Pagi --}}
                <div class="bg-white/10 backdrop-blur-sm border-2 border-white/20 rounded-3xl p-8 shadow-2xl card-3d">
                    <div class="flex items-center justify-center mb-6">
                        <i class="fa-solid fa-sun text-3xl text-yellow-300 mr-4"></i>
                        <h2 class="text-3xl font-bold text-white">Sesi Pagi</h2>
                    </div>
                    <div id="nomor-pagi" class="text-8xl md:text-9xl font-black text-yellow-400 mb-2 transition-all duration-300 transform">
                        ...
                    </div>
                    <div class="text-slate-400">Nomor Antrian Dipanggil</div>
                </div>

                {{-- Sesi Siang --}}
                <div class="bg-white/10 backdrop-blur-sm border-2 border-white/20 rounded-3xl p-8 shadow-2xl card-3d">
                    <div class="flex items-center justify-center mb-6">
                        <i class="fa-solid fa-cloud-sun text-3xl text-sky-300 mr-4"></i>
                        <h2 class="text-3xl font-bold text-white">Sesi Siang</h2>
                    </div>
                    <div id="nomor-siang" class="text-8xl md:text-9xl font-black text-sky-400 mb-2 transition-all duration-300 transform">
                        ...
                    </div>
                    <div class="text-slate-400">Nomor Antrian Dipanggil</div>
                </div>
            </div>

            {{-- Last Updated --}}
            <div class="mt-12 text-slate-500 text-sm animate-fade-in-up" style="animation-delay: 0.4s;">
                <i class="fa-solid fa-clock-rotate-left mr-2"></i>
                Terakhir diperbarui: <span id="last-updated">memuat...</span>
            </div>

        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const nomorPagiEl = document.getElementById('nomor-pagi');
        const nomorSiangEl = document.getElementById('nomor-siang');
        const lastUpdatedEl = document.getElementById('last-updated');

        let initialLoad = true;
        let lastCallUuid = null;
        let voices = [];
        
        // Load Voices
        function loadVoices() {
            if ('speechSynthesis' in window) {
                const getVoices = () => {
                    voices = window.speechSynthesis.getVoices().filter(v => v.lang === 'id-ID');
                };
                getVoices();
                if (window.speechSynthesis.onvoiceschanged !== undefined) {
                    window.speechSynthesis.onvoiceschanged = getVoices;
                }
            }
        }
        loadVoices();

        function speak(text) {
            if (!('speechSynthesis' in window)) return;
            // Cancel previous to avoid backlog on refresh
            window.speechSynthesis.cancel(); 
            
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'id-ID';
            utterance.rate = 0.9;
            utterance.volume = 1;
            if (voices.length > 0) {
                utterance.voice = voices[0];
            }
            window.speechSynthesis.speak(utterance);
        }

        function updateAntrian() {
            // Add a loading indicator effect
            if (initialLoad) {
                nomorPagiEl.textContent = '...';
                nomorSiangEl.textContent = '...';
            }
            
            fetch('/api/antrian/status')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Animate update
                    updateNumber(nomorPagiEl, data.pagi);
                    updateNumber(nomorSiangEl, data.siang);
                    
                    // VOICE ANNOUNCEMENT LOGIC
                    if (data.call && data.call.uuid !== lastCallUuid) {
                        lastCallUuid = data.call.uuid;
                        
                        // Prevent speaking on first load to avoid noise bomb
                        if (!initialLoad) {
                            const callText = `Panggilan untuk nomor antrian ${data.call.nomor}, atas nama ${data.call.nama}. silahkan menuju ke ${data.call.loket}.`;
                            speak(callText);
                            
                            // Visual cue? Maybe flash the number?
                            // For now just sound.
                        }
                    }
                    
                    lastUpdatedEl.textContent = new Date().toLocaleTimeString('id-ID');
                    initialLoad = false;
                })
                .catch(error => {
                    console.error('Error fetching antrian status:', error);
                    // Only show error on text if it persists
                    if(initialLoad) {
                         nomorPagiEl.textContent = 'Error';
                         nomorSiangEl.textContent = 'Error';
                         lastUpdatedEl.textContent = 'Gagal memuat';
                    }
                });
        }
        
        function updateNumber(element, newNumber) {
            if (element.textContent !== String(newNumber)) {
                element.style.transform = 'translateY(-10px)';
                element.style.opacity = '0';
                setTimeout(() => {
                    element.textContent = newNumber;
                    element.style.transform = 'translateY(0)';
                    element.style.opacity = '1';
                }, 300);
            }
        }

        // Update every 5 seconds
        setInterval(updateAntrian, 5000);

        // Initial update
        updateAntrian();
    });
</script>
@endpush
