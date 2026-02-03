<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Display Antrian - Lapas Kelas IIB Jombang</title>
    
    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&family=JetBrains+Mono:wght@700&display=swap" rel="stylesheet">
    
    {{-- Tailwind & Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { font-family: 'Outfit', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        
        /* Glassmorphism Utilities */
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }
        
        /* Animation Classes */
        .pop-in { animation: popIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        @keyframes popIn {
            0% { opacity: 0; transform: scale(0.5); }
            100% { opacity: 1; transform: scale(1); }
        }
        
        .pulse-ring { animation: pulse-ring 2s cubic-bezier(0.215, 0.61, 0.355, 1) infinite; }
        @keyframes pulse-ring {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(234, 179, 8, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 20px rgba(234, 179, 8, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(234, 179, 8, 0); }
        }

        /* Background Gradient Animation */
        .bg-animated {
            background: linear-gradient(-45deg, #0f172a, #1e293b, #0f172a, #172554);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
</head>
<body class="bg-animated h-screen w-screen overflow-hidden text-white selection:bg-yellow-500 selection:text-slate-900 flex flex-col">

    {{-- HEADER --}}
    <header class="h-24 px-8 flex justify-between items-center glass-card border-b-0 border-white/5 relative z-10 w-full mx-auto mt-4 rounded-2xl max-w-[98%]">
        {{-- Logo Section --}}
        <div class="flex items-center gap-4">
            <div class="relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-full blur opacity-40 group-hover:opacity-75 transition duration-1000 group-hover:duration-200"></div>
                <img src="{{ asset('img/logo.png') }}" alt="Logo Lapas" class="h-16 w-16 relative rounded-full border-2 border-yellow-500 bg-white/10 p-1">
            </div>
            <div>
                <h1 class="text-2xl font-bold tracking-wider text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-300">LAPAS KELAS IIB JOMBANG</h1>
                <p class="text-sm text-yellow-500 font-semibold tracking-[0.2em] uppercase">Kemenimipas RI</p>
            </div>
        </div>

        {{-- Center Title --}}
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
            <h2 class="text-1xl md:text-3xl font-extrabold tracking-widest uppercase text-white/10">Antrian Kunjungan</h2>
        </div>

        {{-- Realtime Clock --}}
        <div class="text-right">
            <div id="clock-time" class="text-4xl font-mono font-bold leading-none tracking-tighter text-white drop-shadow-[0_0_10px_rgba(255,255,255,0.3)]">--:--</div>
            <div id="clock-date" class="text-sm font-light text-slate-400 tracking-wide uppercase mt-1">...</div>
        </div>
    </header>

    {{-- MAIN CONTENT --}}
    <main class="flex-1 p-6 grid grid-cols-1 md:grid-cols-2 gap-8 items-center max-w-[98%] mx-auto w-full">
        
        {{-- CARD SESI PAGI --}}
        <div id="card-pagi" class="h-full max-h-[70vh] glass-card rounded-3xl p-8 flex flex-col items-center justify-center relative overflow-hidden group transition-all duration-500 hover:bg-white/5 border-t-4 border-t-blue-500">
            {{-- Background Decoration --}}
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity transform group-hover:scale-110 duration-700">
                <i class="fas fa-sun text-9xl text-blue-400"></i>
            </div>
            
            <div class="text-center z-10 w-full">
                <h3 class="text-2xl font-medium text-blue-300 uppercase tracking-widest mb-2 flex items-center justify-center gap-2">
                    <i class="fas fa-sun"></i> Sesi Pagi
                </h3>
                <div class="h-px w-24 bg-gradient-to-r from-transparent via-blue-500 to-transparent mx-auto mb-8"></div>
                
                {{-- Number Display --}}
                <div class="relative inline-block">
                    <span id="nomor-pagi" class="font-mono text-[10rem] md:text-[12rem] font-bold leading-none tracking-tighter drop-shadow-2xl bg-clip-text text-transparent bg-gradient-to-b from-white to-slate-400 transition-all duration-300">
                        -
                    </span>
                    <div class="absolute -inset-4 bg-blue-500/20 blur-3xl rounded-full -z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </div>

                <p class="text-slate-400 mt-6 text-lg font-light">Nomor Antrian</p>
            </div>
        </div>

        {{-- CARD SESI SIANG --}}
        <div id="card-siang" class="h-full max-h-[70vh] glass-card rounded-3xl p-8 flex flex-col items-center justify-center relative overflow-hidden group transition-all duration-500 hover:bg-white/5 border-t-4 border-t-yellow-500">
            {{-- Background Decoration --}}
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity transform group-hover:scale-110 duration-700">
                <i class="fas fa-cloud-sun text-9xl text-yellow-400"></i>
            </div>
            
            <div class="text-center z-10 w-full">
                <h3 class="text-2xl font-medium text-yellow-300 uppercase tracking-widest mb-2 flex items-center justify-center gap-2">
                    <i class="fas fa-cloud-sun"></i> Sesi Siang
                </h3>
                <div class="h-px w-24 bg-gradient-to-r from-transparent via-yellow-500 to-transparent mx-auto mb-8"></div>
                
                {{-- Number Display --}}
                <div class="relative inline-block">
                    <span id="nomor-siang" class="font-mono text-[10rem] md:text-[12rem] font-bold leading-none tracking-tighter drop-shadow-2xl bg-clip-text text-transparent bg-gradient-to-b from-white to-slate-400 transition-all duration-300">
                        -
                    </span>
                    <div class="absolute -inset-4 bg-yellow-500/20 blur-3xl rounded-full -z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </div>

                <p class="text-slate-400 mt-6 text-lg font-light">Nomor Antrian</p>
            </div>
        </div>

    </main>

    {{-- FOOTER / MARQUEE --}}
    <footer class="h-12 bg-black/40 backdrop-blur-md flex items-center border-t border-white/10 w-full mb-4 rounded-xl max-w-[98%] mx-auto overflow-hidden">
        <div class="bg-yellow-500 text-slate-900 px-6 h-full flex items-center font-bold text-sm tracking-wider z-20 shadow-lg">
            INFORMASI
        </div>
        <div class="flex-1 relative overflow-hidden h-full flex items-center">
            <marquee class="text-lg font-light text-slate-200 tracking-wide absolute w-full" scrollamount="6">
                Selamat Datang di Layanan Kunjungan Lapas Kelas IIB Jombang. Budayakan antri dan patuhi tata tertib yang berlaku. | Jadwal Kunjungan: Pagi 08.00 - 11.30 WIB, Siang 13.00 - 14.30 WIB. | Dilarang keras membawa barang terlarang!
            </marquee>
        </div>
        <div class="px-6 text-xs text-slate-500 font-mono hidden md:block">
            Last Update: <span id="last-updated" class="text-white">...</span>
        </div>
    </footer>

    {{-- SCRIPTS --}}
    <script>
        // DOM Elements
        const nomorPagiEl = document.getElementById('nomor-pagi');
        const nomorSiangEl = document.getElementById('nomor-siang');
        const lastUpdatedEl = document.getElementById('last-updated');
        const cardPagi = document.getElementById('card-pagi');
        const cardSiang = document.getElementById('card-siang');

        // State
        let initialLoad = true;
        let lastCallUuid = null;
        let voices = [];
        
        // --- 1. CLOCK LOGIC ---
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }); // Detik dihilangkan biar bersih
            const dateString = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
            
            document.getElementById('clock-time').textContent = timeString;
            document.getElementById('clock-date').textContent = dateString;
        }
        setInterval(updateClock, 1000);
        updateClock();

        // --- 2. SPEECH LOGIC ---
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
            window.speechSynthesis.cancel(); 
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'id-ID';
            utterance.rate = 0.9;
            utterance.volume = 1;
            if (voices.length > 0) utterance.voice = voices[0];
            window.speechSynthesis.speak(utterance);
        }

        // --- 3. QUEUE LOGIC ---
        function updateNumber(element, newNumber, cardElement) {
            if (element.textContent !== newNumber.toString()) {
                // Animation Pop
                element.parentElement.classList.remove('pop-in');
                void element.parentElement.offsetWidth; // trigger reflow
                element.parentElement.classList.add('pop-in');
                
                element.textContent = newNumber;
                
                // Highlight Card
                if(!initialLoad) {
                    cardElement.classList.add('ring-4', 'ring-white/50');
                    setTimeout(() => cardElement.classList.remove('ring-4', 'ring-white/50'), 1000);
                }
            }
        }

        function updateAntrian() {
            fetch('/api/antrian/status')
                .then(res => {
                    if (!res.ok) throw new Error('API Error');
                    return res.json();
                })
                .then(data => {
                    updateNumber(nomorPagiEl, data.pagi, cardPagi);
                    updateNumber(nomorSiangEl, data.siang, cardSiang);
                    
                    // Voice Trigger
                    if (data.call && data.call.uuid !== lastCallUuid) {
                        lastCallUuid = data.call.uuid;
                        
                        // Active Call Visuals
                        const targetCard = data.call.sesi === 'siang' ? cardSiang : cardPagi; // Fallback logic needed if sesi not in call data?
                        // Assuming call data might not have 'sesi', but we can infer or just generic highlight. 
                        // Actually our controller code saved: 'nomor', 'nama', 'loket'. Doesn't seem to have 'sesi' explicit in cache?
                        // Let's just flash based on where the number is? Or just generic flash.
                        // Ideally we add 'sesi' to the cache in QueueController.
                        
                        if (!initialLoad) {
                            const callText = `Panggilan undangan nomor antrian ${data.call.nomor}, atas nama ${data.call.nama}, silahkan menuju ke ${data.call.loket || 'Pintu Utama'}.`;
                            speak(callText);
                            
                            // Visual Pulse on Screen Overlay maybe? 
                            // Or just highlight both/active card if we knew it.
                        }
                    }
                    
                    lastUpdatedEl.textContent = new Date().toLocaleTimeString('id-ID');
                    initialLoad = false;
                })
                .catch(err => {
                    console.error(err);
                    if(initialLoad) {
                        nomorPagiEl.textContent = '-';
                        nomorSiangEl.textContent = '-';
                    }
                });
        }

        // Poll every 4 seconds (slightly faster to feel responsive)
        setInterval(updateAntrian, 4000);
        updateAntrian(); // Initial call
        
        // Speech Warning Fix (Autoplay policy)
        document.body.addEventListener('click', () => {
             // Unlock Audio Context if needed
             if ('speechSynthesis' in window) {
                 const u = new SpeechSynthesisUtterance(""); 
                 window.speechSynthesis.speak(u);
             }
        }, { once: true });

    </script>
</body>
</html>
