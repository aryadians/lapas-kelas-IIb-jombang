<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sedang Dalam Pemeliharaan - Lapas Kelas IIB Jombang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .bg-gradient-mesh {
            background-color: #0f172a;
            background-image: 
                radial-gradient(at 0% 0%, hsla(217,100%,15%,1) 0, transparent 50%), 
                radial-gradient(at 50% 0%, hsla(217,100%,10%,1) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(217,100%,15%,1) 0, transparent 50%);
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
    </style>
</head>
<body class="bg-gradient-mesh text-white min-h-screen flex items-center justify-center p-6 overflow-hidden">
    {{-- Background Decorative Elements --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-2xl w-full text-center relative z-10">
        {{-- Animated Icon --}}
        <div class="mb-10 animate-float">
            <div class="relative inline-block">
                <div class="absolute inset-0 bg-yellow-400/20 blur-2xl rounded-full"></div>
                <div class="relative bg-gradient-to-br from-yellow-400 to-amber-600 w-32 h-32 rounded-3xl flex items-center justify-center shadow-2xl rotate-12 transform hover:rotate-0 transition-transform duration-500">
                    <i class="fas fa-tools text-5xl text-slate-900"></i>
                </div>
            </div>
        </div>

        {{-- Content --}}
        <h1 class="text-4xl md:text-5xl font-extrabold mb-6 tracking-tight">
            Sistem Sedang <br>
            <span class="bg-gradient-to-r from-yellow-400 to-amber-500 bg-clip-text text-transparent">Dalam Pemeliharaan</span>
        </h1>
        
        <p class="text-blue-200/70 text-lg md:text-xl leading-relaxed mb-10 max-w-lg mx-auto">
            Kami sedang melakukan pembaruan rutin untuk meningkatkan kualitas layanan kunjungan. Mohon kembali beberapa saat lagi.
        </p>

        {{-- Progress Indicator --}}
        <div class="flex items-center justify-center gap-4 mb-10">
            <div class="flex gap-2">
                <span class="w-3 h-3 bg-yellow-500 rounded-full animate-pulse"></span>
                <span class="w-3 h-3 bg-yellow-500/50 rounded-full animate-pulse [animation-delay:0.2s]"></span>
                <span class="w-3 h-3 bg-yellow-500/20 rounded-full animate-pulse [animation-delay:0.4s]"></span>
            </div>
            <span class="text-xs font-bold uppercase tracking-widest text-blue-300/50">Estimasi Selesai: Segera</span>
        </div>

        {{-- CTA/Info --}}
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="https://wa.me/6285733333400" class="group flex items-center gap-3 px-8 py-4 bg-white/5 border border-white/10 rounded-2xl hover:bg-white/10 transition-all active:scale-95">
                <i class="fab fa-whatsapp text-green-400 text-xl"></i>
                <div class="text-left">
                    <div class="text-[10px] uppercase font-bold text-blue-300/50 tracking-tighter">Hubungi Kami</div>
                    <div class="text-sm font-bold">Layanan Pengaduan</div>
                </div>
            </a>
            <button onclick="window.location.reload()" class="group flex items-center gap-3 px-8 py-4 bg-yellow-500 hover:bg-yellow-400 text-slate-900 rounded-2xl transition-all shadow-lg shadow-yellow-500/20 active:scale-95">
                <i class="fas fa-sync-alt group-hover:rotate-180 transition-transform duration-500"></i>
                <span class="font-bold">Cek Status Sekarang</span>
            </button>
        </div>

        {{-- Footer --}}
        <div class="mt-20 pt-8 border-t border-white/5">
            <div class="flex items-center justify-center gap-4 grayscale opacity-40">
                <img src="/img/logo-lapas.png" alt="Logo" class="h-8" onerror="this.style.display='none'">
                <p class="text-xs font-medium text-blue-200/30 uppercase tracking-widest">
                    Lapas Kelas IIB Jombang &copy; {{ date('Y') }}
                </p>
            </div>
        </div>
    </div>
</body>
</html>
