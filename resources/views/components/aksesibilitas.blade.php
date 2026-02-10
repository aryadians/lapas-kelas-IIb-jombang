@once
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/opendyslexic@latest/open-dyslexic.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="//unpkg.com/alpinejs" defer></script>
@endonce

<script>
    window.accessibilityWidget = function() {
        return {
            open: false,
            textSize: 100,
            isGrayscale: false,
            isDyslexia: false,
            isCursorBig: false,
            volume: 1,
            isSpeaking: false,
            synth: window.speechSynthesis,
            utterance: null,

            initWidget() {
                const saved = JSON.parse(localStorage.getItem('acc_settings'));
                if (saved) {
                    this.textSize = saved.textSize || 100;
                    this.isGrayscale = saved.isGrayscale || false;
                    this.isDyslexia = saved.isDyslexia || false;
                    this.isCursorBig = saved.isCursorBig || false;
                }
                this.applyStyles();
            },
            saveSettings() {
                localStorage.setItem('acc_settings', JSON.stringify({
                    textSize: this.textSize,
                    isGrayscale: this.isGrayscale,
                    isDyslexia: this.isDyslexia,
                    isCursorBig: this.isCursorBig
                }));
            },
            applyStyles() {
                const html = document.documentElement;
                const body = document.body;
                html.style.fontSize = this.textSize + '%';
                html.style.filter = this.isGrayscale ? 'grayscale(100%)' : 'none';

                if (this.isDyslexia) {
                    body.setAttribute('style', (body.getAttribute('style') || '') + '; font-family: "OpenDyslexic", sans-serif !important;');
                } else {
                    if (body.getAttribute('style') && body.getAttribute('style').includes('OpenDyslexic')) {
                        let newStyle = body.getAttribute('style').replace('; font-family: "OpenDyslexic", sans-serif !important;', '');
                        body.setAttribute('style', newStyle);
                    }
                }

                const cursorStyleId = 'acc-cursor-style';
                let cursorStyle = document.getElementById(cursorStyleId);
                if (this.isCursorBig) {
                    if (!cursorStyle) {
                        cursorStyle = document.createElement('style');
                        cursorStyle.id = cursorStyleId;
                        cursorStyle.innerHTML = `body, a, button, input { cursor: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="%23EAB308" stroke="%23000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3l7.07 16.97 2.51-7.39 7.39-2.51L3 3z"/><path d="M13 13l6 6"/></svg>'), auto !important; }`;
                        document.head.appendChild(cursorStyle);
                    }
                } else {
                    if (cursorStyle) cursorStyle.remove();
                }
                this.saveSettings();
            },
            changeSize(amount) {
                this.textSize = Math.min(Math.max(this.textSize + amount, 80), 150);
                this.applyStyles();
            },
            toggleGrayscale() {
                this.isGrayscale = !this.isGrayscale;
                this.applyStyles();
            },
            toggleDyslexia() {
                this.isDyslexia = !this.isDyslexia;
                this.applyStyles();
            },
            toggleCursor() {
                this.isCursorBig = !this.isCursorBig;
                this.applyStyles();
            },
            resetAll() {
                this.textSize = 100;
                this.isGrayscale = false;
                this.isDyslexia = false;
                this.isCursorBig = false;
                this.stop();
                this.applyStyles();
            },
            speak() {
                this.stop();
                let text = window.getSelection().toString() || (document.querySelector('main') || document.body).innerText;
                if (text) {
                    this.utterance = new SpeechSynthesisUtterance(text);
                    this.utterance.lang = 'id-ID';
                    this.utterance.volume = this.volume;
                    
                    // Paksa cari suara Indonesia
                    const allVoices = this.synth.getVoices();
                    const idVoice = allVoices.find(v => v.lang.includes('id-ID') || v.lang.includes('ind'));
                    if (idVoice) this.utterance.voice = idVoice;

                    this.utterance.onstart = () => { this.isSpeaking = true; };
                    this.utterance.onend = () => { this.isSpeaking = false; };
                    this.synth.speak(this.utterance);
                }
            },
            stop() {
                if (this.currentAudio) {
                    this.currentAudio.pause();
                    this.currentAudio = null;
                    this.isSpeaking = false;
                }
                if (this.synth.speaking) {
                    this.synth.cancel();
                    this.isSpeaking = false;
                }
            },
            updateVolume() {
                if (this.isSpeaking) {
                    this.stop();
                    this.speak();
                }
            }
        }
    }
</script>

{{-- PERUBAHAN: bottom-6 diganti menjadi bottom-28 agar naik ke atas --}}
<div x-data="accessibilityWidget()" x-init="initWidget()" class="fixed bottom-28 left-6 z-[99999] print:hidden font-sans text-gray-800">

    <button @click="open = !open"
        :class="open ? 'bg-yellow-500 text-gray-900 rotate-90' : 'bg-gray-900 text-yellow-500'"
        class="p-3 rounded-full shadow-2xl border-4 border-yellow-500 transition-all duration-300 hover:scale-110 focus:outline-none w-14 h-14 flex items-center justify-center"
        title="Aksesibilitas">
        <i class="fas fa-universal-access text-2xl"></i>
    </button>

    {{-- Pop Up Menu --}}
    <div x-show="open"
        @click.outside="open = false"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 scale-90"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        class="absolute bottom-0 left-20 w-[300px] bg-gray-900 rounded-xl shadow-2xl border border-gray-700 overflow-hidden text-white origin-bottom-left"
        style="display: none;">

        <div class="bg-gray-800 p-3 flex justify-between items-center border-b border-gray-700">
            <h3 class="font-bold text-sm uppercase flex items-center gap-2">
                <i class="fas fa-universal-access text-yellow-500"></i> Aksesibilitas
            </h3>
            <button @click="open = false" class="text-gray-400 hover:text-white"><i class="fas fa-times"></i></button>
        </div>

        <div class="p-4 space-y-4 max-h-[60vh] overflow-y-auto">
            {{-- TTS --}}
            <div class="bg-gray-800 p-2 rounded border border-gray-700">
                <p class="text-[10px] text-gray-400 mb-1 uppercase font-bold">Pembaca Layar</p>
                <div class="flex gap-2 mb-2">
                    <button @click="speak" class="flex-1 bg-green-600 hover:bg-green-700 py-1.5 rounded text-xs font-bold transition"><i class="fas fa-play mr-1"></i> Baca</button>
                    <button @click="stop" class="flex-1 bg-red-600 hover:bg-red-700 py-1.5 rounded text-xs font-bold transition"><i class="fas fa-stop mr-1"></i> Stop</button>
                </div>
                <input type="range" min="0" max="1" step="0.1" x-model="volume" @input="updateVolume" class="w-full h-1 accent-yellow-500 cursor-pointer">
            </div>

            {{-- Font Size --}}
            <div class="flex justify-between items-center bg-gray-800 p-2 rounded border border-gray-700">
                <button @click="changeSize(-10)" class="w-8 h-8 bg-gray-700 hover:bg-gray-600 rounded flex items-center justify-center transition text-sm font-bold">-</button>
                <span x-text="textSize + '%'" class="text-yellow-500 font-mono font-bold"></span>
                <button @click="changeSize(10)" class="w-8 h-8 bg-gray-700 hover:bg-gray-600 rounded flex items-center justify-center transition text-sm font-bold">+</button>
            </div>

            {{-- Toggles --}}
            <div class="space-y-2">
                <button @click="toggleGrayscale" class="w-full text-left p-2 bg-gray-800 hover:bg-gray-700 rounded text-sm flex justify-between items-center transition border border-gray-700">
                    <span><i class="fas fa-eye-slash mr-2 text-gray-400"></i> Hitam Putih</span>
                    <div :class="isGrayscale ? 'bg-yellow-500' : 'bg-gray-600'" class="w-8 h-4 rounded-full relative transition-colors">
                        <div class="w-4 h-4 bg-white rounded-full shadow absolute top-0 transition-all" :style="isGrayscale ? 'right:0' : 'left:0'"></div>
                    </div>
                </button>
                <button @click="toggleDyslexia" class="w-full text-left p-2 bg-gray-800 hover:bg-gray-700 rounded text-sm flex justify-between items-center transition border border-gray-700">
                    <span><i class="fas fa-font mr-2 text-gray-400"></i> Font Disleksia</span>
                    <div :class="isDyslexia ? 'bg-yellow-500' : 'bg-gray-600'" class="w-8 h-4 rounded-full relative transition-colors">
                        <div class="w-4 h-4 bg-white rounded-full shadow absolute top-0 transition-all" :style="isDyslexia ? 'right:0' : 'left:0'"></div>
                    </div>
                </button>
                <button @click="toggleCursor" class="w-full text-left p-2 bg-gray-800 hover:bg-gray-700 rounded text-sm flex justify-between items-center transition border border-gray-700">
                    <span><i class="fas fa-mouse-pointer mr-2 text-gray-400"></i> Kursor Besar</span>
                    <div :class="isCursorBig ? 'bg-yellow-500' : 'bg-gray-600'" class="w-8 h-4 rounded-full relative transition-colors">
                        <div class="w-4 h-4 bg-white rounded-full shadow absolute top-0 transition-all" :style="isCursorBig ? 'right:0' : 'left:0'"></div>
                    </div>
                </button>
            </div>

            <button @click="resetAll" class="w-full py-2 text-xs text-red-400 border border-red-900/50 hover:bg-red-900/20 rounded transition font-bold uppercase tracking-wider">
                <i class="fas fa-rotate-left mr-1"></i> Reset Pengaturan
            </button>
        </div>
    </div>
</div>