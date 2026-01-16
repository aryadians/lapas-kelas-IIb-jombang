<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Antrian - Lapas Jombang</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@700,900&family=Orbitron:wght@900&display=swap" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://www.youtube.com/iframe_api"></script>
    <style>
        :root {
            --bg-color: #0d1117; /* Keep dark background */
            --primary-color: #FFD700; /* Gold */
            --secondary-color: #1a202c; /* Dark Blue-Gray */
            --accent-color: #00BFFF; /* Deep Sky Blue */
            --text-color: #E0E0E0; /* Lighter Gray for text */
            --glow-color-soft: rgba(0, 191, 255, 0.3); /* Soft blue glow based on accent */
            --glow-color-strong: rgba(0, 191, 255, 0.6); /* Stronger blue glow based on accent */
            --glow-color-primary: rgba(255, 215, 0, 0.4); /* Primary color glow based on gold */
        }
        html, body {
            margin: 0; padding: 0; width: 100%; height: 100%;
            overflow: hidden; background-color: var(--bg-color); color: var(--text-color);
            font-family: 'Exo 2', sans-serif;
        }
        .main-container {
            display: grid;
            grid-template-columns: 60fr 40fr;
            grid-template-rows: auto 1fr auto;
            grid-template-areas: "header header" "video queue" "footer footer";
            height: 100vh; width: 100vw;
        }
                .header {
                    grid-area: header; display: flex; align-items: center; padding: 1.5rem 2.5rem;
                    background: linear-gradient(to bottom, rgba(0,0,0,0.9), transparent); z-index: 100;
                    animation: header-fade-in 1s ease-out;
                }
                @keyframes header-fade-in {
                    from { opacity: 0; transform: translateY(-50px); }
                    to { opacity: 1; transform: translateY(0); }
                }
                .header img { height: 60px; margin-right: 1.5rem; filter: drop-shadow(0 0 10px var(--glow-color-primary)); }
                .header h1 {
                    font-size: 2.5rem; text-transform: uppercase; letter-spacing: 3px;
                    font-family: 'Orbitron', sans-serif; color: var(--text-color);
                    text-shadow: 0 0 8px var(--glow-color-strong);
                }        
        .video-container {
            grid-area: video; background-color: #000; position: relative;
            border-right: 4px solid var(--primary-color);
            box-shadow: 10px 0 35px -5px rgba(0,0,0,0.7);
            z-index: 50; /* Ensure overlay is below mute button */
            animation: video-slide-in 1s ease-out 0.5s forwards;
            opacity: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        @keyframes video-slide-in {
            from { opacity: 0; transform: translateX(-100px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .video-container #player { width: 100%; height: 100%; border: none; object-fit: cover; }
                #unmuteButton {
                    position: absolute; top: 25px; right: 25px; z-index: 150;
                    background: rgba(0,0,0,0.6); border: 2px solid var(--accent-color); color: var(--text-color);
                    width: 50px; height: 50px; border-radius: 50%; cursor: pointer;
                    display: flex; align-items: center; justify-content: center; font-size: 1.5rem;
                    backdrop-filter: blur(8px); transition: all 0.3s;
                    box-shadow: 0 0 10px var(--glow-color-strong); /* Softer shadow */
                }
                #unmuteButton:hover {
                    background: rgba(0, 191, 255, 0.7); /* Use new accent color */
                    transform: scale(1.1); /* Simpler hover effect */
                    box-shadow: 0 0 20px var(--glow-color-strong);
                }
        .queue-container {
            grid-area: queue; display: flex; flex-direction: column;
            padding: 1.5rem 2rem; gap: 1.8rem;
            background: radial-gradient(circle, var(--secondary-color) 0%, var(--bg-color) 100%);
            transform: translateZ(10px); /* Bring queue slightly forward */
            animation: queue-slide-in 1s ease-out 0.7s forwards;
            opacity: 0;
        }
        @keyframes queue-slide-in {
            from { opacity: 0; transform: translateX(100px) translateZ(10px); }
            to { opacity: 1; transform: translateX(0) translateZ(10px); }
        }
        .queue-boxes { display: flex; gap: 1.5rem; flex-grow: 1; }
        .queue-box {
            background: rgba(10, 42, 67, 0.4); /* Softer background */
            border: 1px solid var(--accent-color); /* Thinner border */
            border-radius: 15px; /* Softer corners */
            text-align: center; padding: 1.5rem;
            box-shadow: 0 0 15px var(--glow-color-strong), inset 0 0 10px rgba(0, 191, 255, 0.2); /* Softer shadows */
            flex: 1; transition: transform 0.3s ease-out;
            animation: box-appear 0.8s ease-out forwards;
            animation-delay: 1s;
        }
        @keyframes box-appear {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .queue-box:hover {
            transform: translateY(-5px) scale(1.02); /* Lift slightly on hover */
            box-shadow: 0 0 25px var(--glow-color-strong), inset 0 0 15px rgba(0, 191, 255, 0.3);
        }
        .queue-box h3 {
            font-size: 2.2rem; margin: 0; text-transform: uppercase; color: var(--primary-color);
            text-shadow: 0 0 10px var(--glow-color-primary); /* Softer text shadow */
        }
        .queue-number {
            font-family: 'Orbitron', sans-serif; font-size: 7rem; font-weight: 900; line-height: 1.2;
            color: var(--text-color); transition: transform 0.3s ease;
            text-shadow: 0 0 8px var(--text-color), 0 0 15px var(--glow-color-strong), 0 0 25px var(--glow-color-strong); /* Softer shadows */
        }
        .ping { animation: ping-effect 0.8s ease-out; }
        @keyframes ping-effect {
            0% { transform: scale3d(1, 1, 1); }
            30% { transform: scale3d(1.25, 0.75, 1); text-shadow: 0 0 10px var(--text-color), 0 0 35px var(--primary-color), 0 0 60px var(--primary-color); }
            40% { transform: scale3d(0.75, 1.25, 1); }
            50% { transform: scale3d(1.15, 0.85, 1); text-shadow: 0 0 10px var(--text-color), 0 0 30px var(--glow-color-strong); }
            65% { transform: scale3d(0.95, 1.05, 1); }
            75% { transform: scale3d(1.05, 0.95, 1); }
            100% { transform: scale3d(1, 1, 1); }
        }

        .visiting-container {
            background: rgba(10, 42, 67, 0.4); /* Softer background */
            border: 1px solid var(--accent-color); /* Thinner border */
            border-radius: 15px; /* Softer corners */
            padding: 1.5rem; flex: 1; display: flex; flex-direction: column;
            box-shadow: 0 0 15px var(--glow-color-strong); /* Softer shadow */
            animation: box-appear 0.8s ease-out forwards;
            animation-delay: 1.2s;
        }
        .visiting-container:hover {
            transform: translateY(-3px) scale(1.01); /* Lift slightly on hover */
            box-shadow: 0 0 25px var(--glow-color-strong), inset 0 0 15px rgba(0, 191, 255, 0.3);
        }
        .visiting-container h3 {
            font-size: 2.2rem; text-align: center; margin: 0 0 1rem 0;
            text-transform: uppercase; color: var(--primary-color);
            text-shadow: 0 0 10px var(--glow-color-primary); /* Softer text shadow */
        }
        .visiting-list { list-style: none; padding: 0; margin: 0; overflow-y: auto; flex: 1; }
        .visiting-item {
            background-color: rgba(0, 191, 255, 0.1); /* Softer background color */
            border-radius: 10px; /* Slightly smaller border-radius */
            padding: 1rem 1.5rem; margin-bottom: 0.7rem; /* Adjusted padding and margin */
            font-size: 1.6rem; display: flex; justify-content: space-between;
            border-left: 4px solid var(--accent-color); /* Thinner border */
            box-shadow: 0 0 8px var(--glow-color-soft); /* Softer shadow */
            transition: all 0.3s ease;
        }
        .visiting-item:hover {
            transform: translateX(3px) scale(1.005); /* Subtle lift and translate */
            box-shadow: 0 0 15px var(--glow-color-strong);
        }
        .visiting-item .visitor { font-weight: 700; text-transform: uppercase; color: var(--text-color); }
        .visiting-item .wbp { font-weight: 400; color: #B0B0B0; font-size: 1.2rem; } /* Slightly darker gray */

        .footer {
            grid-area: footer; background-color: var(--primary-color); color: #1a1a1a; /* Ensure good contrast */
            font-size: 2.5rem; font-weight: 700; padding: 0.7rem;
            white-space: nowrap; overflow: hidden; box-shadow: 0 0 20px var(--glow-color-primary); /* Softer shadow */
            z-index: 10;
        }
        .marquee { 
            display: inline-block; padding-left: 100%; 
            animation: marquee 40s linear infinite; /* Adjusted speed */
            text-shadow: 0 0 5px rgba(0,0,0,0.5);
            color: #1a1a1a; /* Darker text for contrast */
        }
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-100%); }
        }
    </style>
</head>
<body>
    <div class="main-container" x-data="mainController()" x-init="init()">
        
        <header class="header">
            <img src="{{ asset('img/logo.png') }}" alt="Logo">
            <h1>Lapas Kelas IIB Jombang</h1>
        </header>

        <section class="video-container">
            <div id="player"></div>
            <button id="unmuteButton" @click="toggleMute()">
                <i :class="isMuted ? 'fas fa-volume-mute' : 'fas fa-volume-up'"></i>
            </button>
        </section>

        <section class="queue-container">
            <div class="queue-boxes">
                <div class="queue-box">
                    <h3>Sesi Pagi</h3>
                    <div x-text="nomorPagi" :class="{ 'ping': pingPagi }" class="queue-number">0</div>
                </div>
                <div class="queue-box">
                    <h3>Sesi Siang</h3>
                    <div x-text="nomorSiang" :class="{ 'ping': pingSiang }" class="queue-number">0</div>
                </div>
            </div>
            <div class="visiting-container">
                <h3>Sedang Berkunjung</h3>
                <ul class="visiting-list">
                    <template x-for="item in visitingList" :key="item.id">
                         <li class="visiting-item" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-1/4" x-transition:enter-end="opacity-100 transform translate-x-0"
                                                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform translate-x-0" x-transition:leave-end="opacity-0 transform -translate-x-1/4">
                            <span class="visitor" x-text="item.nama_pengunjung"></span>
                            <span class="wbp" x-text="item.wbp.nama"></span>
                        </li>
                    </template>
                    <template x-if="visitingList.length === 0">
                        <li class="visiting-item" style="justify-content: center; background: none; border: none; font-size: 1.5rem; color: #bdc3c7;">Tidak ada kunjungan berlangsung.</li>
                    </template>
                </ul>
            </div>
        </section>

        <footer class="footer">
            <div class="marquee">
                <span>SELAMAT DATANG DI LAYANAN KUNJUNGAN LAPAS KELAS IIB JOMBANG. DILARANG MEMBAWA BARANG TERLARANG. PATUHI PROTOKOL KESEHATAN.</span>
            </div>
        </footer>
    </div>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script>
        // Global variable to signal YouTube API readiness
        window.YT_API_READY = false;
        function onYouTubeIframeAPIReady() {
            console.log('YouTube API Ready');
            console.log('Alpine mainComponent available:', !!window.mainAlpineComponent); // Debug log
            window.YT_API_READY = true;
            // If Alpine has already initialized, call its player init directly
            if (window.mainAlpineComponent && !window.mainAlpineComponent.youTubePlayerInitialized) {
                window.mainAlpineComponent.initPlayer();
            }
        }

        function mainController() {
            return {
                nomorPagi: 0,
                nomorSiang: 0,
                pingPagi: false,
                pingSiang: false,
                visitingList: [],
                player: null,
                isMuted: true,
                youTubePlayerInitialized: false, // New flag

                init() {
                    window.mainAlpineComponent = this; // Make this component globally accessible
                    console.log('Alpine mainController init. YT API ready?', window.YT_API_READY);

                    this.fetchQueueNumbers();
                    this.fetchVisitingStatus();
                    setInterval(() => this.fetchQueueNumbers(), 3000);
                    setInterval(() => this.fetchVisitingStatus(), 5000);

                    // If YouTube API is already ready by the time Alpine init runs
                    if (window.YT_API_READY && !this.youTubePlayerInitialized) {
                        this.initPlayer();
                    }
                },

                initPlayer() {
                    console.log('Attempting to initialize YouTube player...');
                    if (this.youTubePlayerInitialized) {
                        console.log('Player already initialized, skipping.');
                        return;
                    }

                    this.player = new YT.Player('player', {
                        height: '100%',
                        width: '100%',
                        videoId: 'H1vh3CZCie4',
                        playerVars: {
                            autoplay: 1,
                            loop: 1,
                            playlist: 'H1vh3CZCie4',
                            controls: 0,
                            modestbranding: 1,
                            showinfo: 0,
                            rel: 0,
                            mute: 0 // Ensure player starts unmuted from playerVars
                        },
                        events: {
                            'onReady': (event) => {
                                console.log('YouTube player ready. Attempting to unmute and play with max volume.');
                                event.target.playVideo();
                                event.target.unMute(); // Explicitly unmute
                                event.target.setVolume(100); // Set volume to max
                                this.isMuted = false; // Update Alpine state
                                this.youTubePlayerInitialized = true;
                            },
                            'onError': (error) => {
                                console.error('YouTube Player Error:', error);
                            }
                        }
                    });
                },

                toggleMute() {
                    console.log('ToggleMute button clicked.');
                    if (!this.player) {
                        console.warn('YouTube player not initialized when toggleMute was called.');
                        return;
                    }
                    if (this.player.isMuted()) {
                        this.player.unMute();
                        this.isMuted = false;
                        console.log('Player unmuted.');
                    } else {
                        this.player.mute();
                        this.isMuted = true;
                        console.log('Player muted.');
                    }
                },

                async fetchQueueNumbers() {
                    try {
                        const response = await fetch('{{ route("api.antrian.status") }}');
                        const data = await response.json();
                        console.log('Queue numbers fetched:', data); // Debug log
                        if (this.nomorPagi != data.pagi) {
                            this.pingPagi = true;
                            setTimeout(() => this.pingPagi = false, 800);
                        }
                        this.nomorPagi = data.pagi;
                        if (this.nomorSiang != data.siang) {
                            this.pingSiang = true;
                            setTimeout(() => this.pingSiang = false, 800);
                        }
                        this.nomorSiang = data.siang;
                    } catch (e) {
                        console.error('Gagal mengambil status antrian:', e);
                    }
                },
                
                async fetchVisitingStatus() {
                    try {
                        const response = await fetch('{{ route("admin.api.antrian.state") }}');
                        const data = await response.json();
                        console.log('Visiting status fetched:', data); // Debug log
                        this.visitingList = data.in_progress || [];
                    } catch (e) {
                        console.error('Gagal mengambil status kunjungan:', e);
                    }
                }
            }
        }
    </script>
</body>
</html>