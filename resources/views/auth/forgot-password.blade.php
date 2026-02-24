<x-guest-layout>
    {{-- Load Animate.css --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        /* Background Animation */
        .blob {
            position: absolute;
            filter: blur(80px);
            z-index: 0;
            opacity: 0.6;
            animation: float 10s infinite ease-in-out;
        }
        @keyframes float {
            0% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(20px, -20px) scale(1.1); }
            100% { transform: translate(0, 0) scale(1); }
        }

        /* 3D Glass Card */
        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3);
            transform-style: preserve-3d;
            transition: transform 0.3s ease;
        }
        
        /* Modern Input */
        .input-group {
            position: relative;
            transition: all 0.3s ease;
        }
        .input-group input {
            padding-left: 3rem;
            width: 100%;
            height: 3.5rem;
            background-color: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 0.75rem;
            font-weight: 600;
            color: #334155;
            transition: all 0.2s;
        }
        .input-group input:focus {
            background-color: #ffffff;
            border-color: #f59e0b; /* Amber focus */
            box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1);
            outline: none;
        }
        .input-group .icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1.2rem;
            pointer-events: none;
            transition: color 0.2s;
        }
        .input-group input:focus ~ .icon {
            color: #f59e0b;
        }
    </style>

    {{-- BACKGROUND DECORATION --}}
    <div class="fixed inset-0 bg-slate-900 -z-10 overflow-hidden">
        <div class="blob bg-amber-600 w-96 h-96 rounded-full top-0 left-0 -translate-x-1/2 -translate-y-1/2"></div>
        <div class="blob bg-blue-600 w-96 h-96 rounded-full bottom-0 right-0 translate-x-1/2 translate-y-1/2 animation-delay-2000"></div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="min-h-screen flex flex-col justify-center items-center p-6">
        
        <div class="w-full sm:max-w-md auth-card rounded-[2.5rem] p-8 sm:p-10 relative z-10 animate__animated animate__zoomIn">
            
            {{-- Header Icon & Title --}}
            <div class="text-center mb-8">
                <div class="mx-auto w-20 h-20 bg-gradient-to-br from-amber-400 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg shadow-orange-500/30 transform -rotate-6 hover:rotate-0 transition-all duration-300 mb-6">
                    <i class="fas fa-key text-4xl text-white"></i>
                </div>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight">Lupa Password?</h2>
                <p class="text-slate-500 text-sm mt-2 font-medium leading-relaxed px-4">
                    Masukkan email Anda, kami akan mengirimkan tautan untuk mereset kata sandi.
                </p>
            </div>

            {{-- Status Message (Jika sukses terkirim) --}}
            <x-auth-session-status class="mb-6" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                {{-- Email Input --}}
                <div class="space-y-1.5">
                    <label for="email" class="block text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Alamat Email</label>
                    <div class="input-group">
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus placeholder="nama@keminipas.go.id">
                        <i class="fas fa-envelope icon"></i>
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-1 ml-1 text-xs" />
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="w-full py-3.5 px-4 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-bold rounded-xl shadow-lg shadow-orange-500/30 transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-orange-200 flex items-center justify-center gap-2">
                    <i class="fas fa-paper-plane"></i>
                    <span>KIRIM LINK RESET</span>
                </button>

                {{-- Back to Login --}}
                <div class="text-center pt-2">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-slate-800 transition-colors group">
                        <i class="fas fa-arrow-left text-xs transition-transform group-hover:-translate-x-1"></i>
                        Kembali ke Login
                    </a>
                </div>
            </form>
        </div>

        {{-- Footer --}}
        <div class="mt-8 text-center text-slate-500 text-xs relative z-10 animate__animated animate__fadeInUp animate__delay-1s">
            &copy; {{ date('Y') }} Sistem Informasi Lapas Kelas IIB Jombang.
        </div>
    </div>
</x-guest-layout>