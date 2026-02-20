<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Display Antrian - Lapas Kelas IIB Jombang</title>
    
    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&family=Orbitron:wght@700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    {{-- Tailwind & Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://www.youtube.com/iframe_api"></script>

    <style>
        body { font-family: 'Outfit', sans-serif; }
        .font-orbitron { font-family: 'Orbitron', sans-serif; }
        
        /* Premium Background Animation */
        .bg-animated {
            background: radial-gradient(circle at center, #1e293b, #0f172a, #020617);
            background-size: 200% 200%;
            animation: gradientPulse 15s ease infinite;
        }
        @keyframes gradientPulse {
            0% { background-position: 50% 50%; }
            50% { background-position: 50% 60%; }
            100% { background-position: 50% 50%; }
        }

        /* Glassmorphism */
        .glass-panel {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
        }

        /* Neon Glow Text */
        .text-glow-gold {
            text-shadow: 0 0 10px rgba(234, 179, 8, 0.5), 0 0 20px rgba(234, 179, 8, 0.3);
        }
        .text-glow-blue {
            text-shadow: 0 0 10px rgba(59, 130, 246, 0.5), 0 0 20px rgba(59, 130, 246, 0.3);
        }

        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: rgba(255, 255, 255, 0.05); }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.2); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.4); }

        /* Animation */
        .slide-in-right { animation: slideInRight 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        @keyframes slideInRight { from { opacity: 0; transform: translateX(50px); } to { opacity: 1; transform: translateX(0); } }
        
        .pop-card { transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        .pop-card:hover { transform: translateY(-5px); box-shadow: 0 15px 40px rgba(0,0,0,0.4); border-color: rgba(234, 179, 8, 0.3); }

        .ping-active { animation: pingSoft 1s cubic-bezier(0, 0, 0.2, 1) infinite; }
        @keyframes pingSoft {
            75%, 100% { transform: scale(1.05); opacity: 0; }
        }
    </style>
</head>
<body class="bg-animated h-screen w-screen overflow-hidden text-white selection:bg-yellow-500 selection:text-slate-900 flex flex-col p-4 md:p-6 gap-4 md:gap-6" x-data="displayController()" x-init="init()">

    {{-- HEADER --}}
    <header class="glass-panel h-20 md:h-24 rounded-2xl flex items-center justify-between px-8 z-50 shrink-0">
        <div class="flex items-center gap-6">
            <div class="relative">
                <div class="absolute inset-0 bg-yellow-500 blur-lg opacity-20 rounded-full"></div>
                <img src="{{ asset('img/logo.png') }}" class="h-14 md:h-16 w-auto relative drop-shadow-[0_0_10px_rgba(255,255,255,0.3)]" alt="Logo">
            </div>
            <div class="flex flex-col">
                <h1 class="text-2xl md:text-3xl font-bold tracking-wide uppercase bg-clip-text text-transparent bg-gradient-to-r from-white via-slate-200 to-slate-400">
                    Lapas Kelas IIB Jombang
                </h1>
                <p class="text-xs md:text-sm text-yellow-500 tracking-[0.2em] font-medium uppercase">Kementerian Imigrasi dan Pemasyarakatan</p>
            </div>
        </div>

        {{-- Clock --}}
        <div class="text-right">
            <div x-text="currentTime" class="text-3xl md:text-4xl font-orbitron font-bold tracking-widest text-white drop-shadow-lg">--:--</div>
            <div x-text="currentDate" class="text-xs md:text-sm text-slate-400 font-medium uppercase tracking-wide">...</div>
        </div>
    </header>

    {{-- MAIN CONTENT GRID --}}
    <main class="flex-1 grid grid-cols-12 gap-6 min-h-0">
        
        {{-- LEFT COLUMN: VIDEO PLAYER (60%) --}}
        <section class="col-span-12 lg:col-span-7 flex flex-col h-full min-h-0">
            <div class="glass-panel flex-1 rounded-2xl overflow-hidden relative group border border-slate-700/50 shadow-2xl">
                {{-- Video Placeholder/Player --}}
                <div id="player" class="w-full h-full object-cover"></div>
                
                {{-- Mute Controls Overlay --}}
                <div class="absolute top-4 right-4 z-20">
                    <button @click="toggleMute()" 
                        class="h-12 w-12 rounded-full bg-black/40 backdrop-blur-md border border-white/20 flex items-center justify-center text-white hover:bg-yellow-500 hover:text-black transition-all duration-300 group-hover:scale-110 shadow-lg">
                        <i class="fas" :class="isMuted ? 'fa-volume-mute' : 'fa-volume-up'"></i>
                    </button>
                </div>
                
                {{-- Video Overlay Gradient (Subtle) --}}
                <div class="absolute inset-0 pointer-events-none bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                <div class="absolute bottom-6 left-6 pointer-events-none">
                    <span class="px-3 py-1 rounded-full bg-red-600/80 text-white text-xs font-bold uppercase tracking-wider backdrop-blur-sm animate-pulse">
                        <i class="fas fa-circle text-[8px] mr-1 align-middle"></i> Official Broadcast
                    </span>
                    <h2 class="text-xl font-bold mt-2 text-white drop-shadow-md">Profil Lapas Jombang</h2>
                </div>
            </div>
        </section>

        {{-- RIGHT COLUMN: QUEUE INFO (40%) --}}
        <section class="col-span-12 lg:col-span-5 flex flex-col gap-6 h-full min-h-0">
            
            {{-- 1. QUEUE STATUS CARDS (Row) --}}
            <div class="grid grid-cols-2 gap-4 shrink-0 h-48 md:h-56">
                {{-- Card Pagi --}}
                <div class="glass-panel rounded-2xl p-4 flex flex-col items-center justify-center relative pop-card overflow-hidden">
                    <div class="absolute top-0 w-full h-1 bg-gradient-to-r from-transparent via-blue-500 to-transparent opacity-50"></div>
                    <span class="text-slate-400 text-sm font-bold uppercase tracking-widest mb-2"><i class="fas fa-sun text-blue-400 mr-2"></i> Pagi</span>
                    <div class="relative">
                        <span x-text="nomorPagi" class="font-orbitron text-6xl md:text-7xl font-bold text-white text-glow-blue transition-all duration-300" :class="{'scale-110 text-blue-300': pingPagi}">-</span>
                        <div class="absolute inset-0 bg-blue-500/20 blur-2xl rounded-full z-[-1] opacity-50"></div>
                    </div>
                </div>

                {{-- Card Siang --}}
                <div class="glass-panel rounded-2xl p-4 flex flex-col items-center justify-center relative pop-card overflow-hidden">
                    <div class="absolute top-0 w-full h-1 bg-gradient-to-r from-transparent via-yellow-500 to-transparent opacity-50"></div>
                    <span class="text-slate-400 text-sm font-bold uppercase tracking-widest mb-2"><i class="fas fa-cloud-sun text-yellow-400 mr-2"></i> Siang</span>
                    <div class="relative">
                        <span x-text="nomorSiang" class="font-orbitron text-6xl md:text-7xl font-bold text-white text-glow-gold transition-all duration-300" :class="{'scale-110 text-yellow-300': pingSiang}">-</span>
                        <div class="absolute inset-0 bg-yellow-500/20 blur-2xl rounded-full z-[-1] opacity-50"></div>
                    </div>
                </div>
            </div>

            {{-- 2. VISITING LIST (Remaining Height) --}}
            <div class="glass-panel flex-1 rounded-2xl flex flex-col min-h-0 overflow-hidden relative">
                <div class="bg-black/20 p-4 border-b border-white/5 flex justify-between items-center backdrop-blur-md sticky top-0 z-10">
                    <h3 class="text-lg font-bold text-slate-200 flex items-center gap-2">
                        <i class="fas fa-users text-green-400"></i> Sedang Berkunjung
                    </h3>
                    <span class="px-2 py-1 bg-green-500/20 text-green-400 text-xs rounded font-bold" x-text="visitingList.length + ' Orang'">0</span>
                </div>
                
                <div class="flex-1 overflow-y-auto custom-scrollbar p-3 space-y-2 relative">
                    <template x-for="item in visitingList" :key="item.id">
                        <div class="bg-white/5 hover:bg-white/10 border border-white/5 rounded-xl p-3 flex justify-between items-center slide-in-right transition-all group">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-slate-700 to-slate-800 flex items-center justify-center text-slate-300 font-bold border border-white/10 group-hover:border-yellow-500/50 transition-colors">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-white uppercase tracking-wide group-hover:text-yellow-400 transition-colors">
                                        <span x-text="(item.registration_type === 'offline' ? 'B-' : 'A-') + item.nomor_antrian_harian.toString().padStart(3, '0')"></span> - 
                                        <span x-text="item.nama_pengunjung"></span>
                                    </p>
                                    <p class="text-xs text-slate-400 flex items-center gap-1">
                                        <i class="fas fa-id-card text-[10px]"></i> <span x-text="item.wbp?.nama || 'WBP'"></span>
                                    </p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end">
                                <span class="px-2 py-0.5 rounded bg-blue-500/20 text-blue-300 text-[10px] font-bold border border-blue-500/30">
                                    ROOM A
                                </span>
                            </div>
                        </div>
                    </template>
                    
                    <div x-show="visitingList.length === 0" class="h-full flex flex-col items-center justify-center text-slate-500 opacity-60">
                        <i class="fas fa-coffee text-4xl mb-2"></i>
                        <p class="text-sm">Belum ada kunjungan.</p>
                    </div>
                </div>
            </div>

        </section>
    </main>

    {{-- FOOTER / MARQUEE --}}
    <footer class="h-12 md:h-14 shrink-0 glass-panel rounded-xl flex items-center overflow-hidden border-t-2 border-yellow-500/50">
        <div class="bg-yellow-500 text-slate-900 px-6 h-full flex items-center justify-center font-bold text-sm tracking-widest z-10 shadow-xl">
            INFO
        </div>
        <div class="flex-1 relative h-full flex items-center overflow-hidden">
            <div class="absolute whitespace-nowrap animate-marquee px-4">
                <span class="text-lg font-light text-slate-100 tracking-wider">
                    <i class="fas fa-bullhorn text-yellow-500 mx-2"></i> SELAMAT DATANG DI LAYANAN KUNJUNGAN LAPAS KELAS IIB JOMBANG. 
                    <i class="fas fa-circle text-[6px] align-middle mx-3 text-slate-500"></i> DILARANG MEMBAWA HP, NARKOBA, DAN BARANG TERLARANG LAINNYA. 
                    <i class="fas fa-circle text-[6px] align-middle mx-3 text-slate-500"></i> JADWAL KUNJUNGAN: PAGI 08.00 - 11.30 WIB | SIANG 13.00 - 14.30 WIB.
                </span>
            </div>
        </div>
    </footer>

    <style>
        .animate-marquee { animation: marquee 25s linear infinite; }
        @keyframes marquee { 0% { transform: translateX(100%); } 100% { transform: translateX(-100%); } }
    </style>

    {{-- LOGIC --}}
    <script>
        // --- YOUTUBE API HANDLING (Global Scope) ---
        var player;
        var isYouTubeReady = false;

        function onYouTubeIframeAPIReady() {
            console.log("YouTube API Ready");
            isYouTubeReady = true;
            
            player = new YT.Player('player', {
                height: '100%',
                width: '100%',
                videoId: 'H1vh3CZCie4', // ID Video Profil
                playerVars: {
                    autoplay: 1,
                    loop: 1,
                    playlist: 'H1vh3CZCie4', // Required for loop
                    controls: 0,
                    modestbranding: 1,
                    showinfo: 0,
                    rel: 0,
                    mute: 1 // Start muted to satisfy Autoplay Policy
                },
                events: {
                    'onReady': onPlayerReady,
                    'onError': onPlayerError
                }
            });
        }

        function onPlayerReady(event) {
            console.log("Player Ready");
            event.target.playVideo();
            // Try to unmute after a delay or user interaction
            setTimeout(() => {
                // event.target.unMute(); 
                // Browsers usually block unmuting without user interaction
            }, 1000);
        }

        function onPlayerError(event) {
            console.error("YouTube Player Error:", event.data);
            // Fallback: Use local video if YouTube fails (Optional)
            // document.getElementById('player').innerHTML = '<div class="flex items-center justify-center h-full text-white">Video tidak tersedia</div>';
        }

        // --- MAIN CONTROLLER ---
        function displayController() {
            return {
                nomorPagi: '-',
                nomorSiang: '-',
                pingPagi: false,
                pingSiang: false,
                visitingList: [],
                currentTime: '',
                currentDate: '',
                isMuted: true,
                lastCallUuid: null,
                voices: [],

                init() {
                    this.updateTime();
                    setInterval(() => this.updateTime(), 1000);
                    
                    this.fetchData();
                    setInterval(() => this.fetchData(), 3000);
                    
                    this.loadVoices();
                    
                    // Periodically check if video is playing just in case
                    setInterval(() => {
                        if(isYouTubeReady && player && player.getPlayerState() !== 1) {
                             player.playVideo();
                        }
                    }, 5000);
                },

                updateTime() {
                    const now = new Date();
                    this.currentTime = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                    this.currentDate = now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
                },

                toggleMute() {
                    if (isYouTubeReady && player) {
                        if (player.isMuted()) {
                            player.unMute();
                            this.isMuted = false;
                        } else {
                            player.mute();
                            this.isMuted = true;
                        }
                    }
                },

                fetchData() {
                    // 1. Queue Status
                    fetch('{{ route("api.antrian.status") }}')
                        .then(res => res.ok ? res.json() : null)
                        .then(data => {
                            if (!data) return;
                            
                            if (String(this.nomorPagi) !== String(data.pagi)) {
                                this.pingPagi = true; setTimeout(() => this.pingPagi = false, 1000);
                                this.nomorPagi = data.pagi;
                            }
                            if (String(this.nomorSiang) !== String(data.siang)) {
                                this.pingSiang = true; setTimeout(() => this.pingSiang = false, 1000);
                                this.nomorSiang = data.siang;
                            }

                            if (data.call && data.call.uuid !== this.lastCallUuid) {
                                this.lastCallUuid = data.call.uuid;
                                this.announce(data.call);
                            }
                        })
                        .catch(err => console.error("API Error (Queue):", err));

                    // 2. Visiting List
                    fetch('{{ route("admin.api.antrian.state") }}')
                        .then(res => res.ok ? res.json() : [])
                        .then(data => {
                            this.visitingList = data.in_progress || [];
                        })
                        .catch(err => console.error("API Error (Visits):", err));
                },

                loadVoices() {
                    if ('speechSynthesis' in window) {
                        const get = () => this.voices = window.speechSynthesis.getVoices().filter(v => v.lang.includes('id-ID') || v.lang.includes('ind'));
                        get();
                        window.speechSynthesis.onvoiceschanged = get;
                    }
                },

                announce(callData) {
                    if (!('speechSynthesis' in window)) return;
                    
                    // Ding dong
                    this.playChime();

                    setTimeout(() => {
                        window.speechSynthesis.cancel();
                        const text = `Panggilan nomor antrian ${callData.nomor}. Atas nama ${callData.nama}. Silahkan masuk ke ruang kunjungan.`;
                        const ut = new SpeechSynthesisUtterance(text);
                        ut.lang = 'id-ID';
                        ut.rate = 0.9;
                        ut.pitch = 1.0;
                        
                        // Cari suara Indonesia
                        if(this.voices.length) {
                            ut.voice = this.voices[0];
                        } else {
                            // Coba lagi ambil voices jika belum terload
                            const allVoices = window.speechSynthesis.getVoices();
                            const idVoice = allVoices.find(v => v.lang.includes('id-ID') || v.lang.includes('ind'));
                            if (idVoice) ut.voice = idVoice;
                        }
                        
                        window.speechSynthesis.speak(ut);
                    }, 1500); // Wait for chime
                },

                playChime() {
                    try {
                        const C = window.AudioContext || window.webkitAudioContext;
                        if(!C) return;
                        const ctx = new C();
                        const o = ctx.createOscillator();
                        const g = ctx.createGain();
                        o.connect(g); g.connect(ctx.destination);
                        o.type = 'sine'; 
                        o.frequency.setValueAtTime(500, ctx.currentTime);
                        o.frequency.exponentialRampToValueAtTime(1000, ctx.currentTime + 0.1);
                        o.frequency.exponentialRampToValueAtTime(500, ctx.currentTime + 0.6);
                        g.gain.setValueAtTime(0.1, ctx.currentTime);
                        g.gain.linearRampToValueAtTime(0, ctx.currentTime + 1.2);
                        o.start(); o.stop(ctx.currentTime + 1.2);
                    } catch(e){}
                }
            }
        }
        
        // Unmute on first interaction
        document.body.addEventListener('click', () => {
             if (isYouTubeReady && player) player.unMute();
        }, {once:true});
    </script>
</body>
</html>