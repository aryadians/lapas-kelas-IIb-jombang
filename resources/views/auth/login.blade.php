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

        /* Glassmorphism Card */
        .login-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            transform-style: preserve-3d;
        }

        /* Modern Input Group */
        .input-group {
            position: relative;
            transition: all 0.3s ease;
        }
        .input-group input {
            padding-left: 3rem; /* Space for icon */
            padding-right: 1rem;
            width: 100%;
            height: 3.5rem; /* Tinggi input yang pas */
            background-color: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 0.75rem; /* Rounded-xl */
            font-weight: 500;
            color: #334155;
            transition: all 0.2s;
        }
        .input-group input:focus {
            background-color: #ffffff;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
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
            color: #3b82f6;
        }
        .input-group .toggle-password {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            cursor: pointer;
            transition: color 0.2s;
        }
        .input-group .toggle-password:hover {
            color: #334155;
        }
    </style>

    {{-- BACKGROUND --}}
    <div class="fixed inset-0 bg-slate-900 -z-10 overflow-hidden">
        <div class="blob bg-blue-600 w-96 h-96 rounded-full top-0 left-0 -translate-x-1/2 -translate-y-1/2"></div>
        <div class="blob bg-indigo-600 w-96 h-96 rounded-full bottom-0 right-0 translate-x-1/2 translate-y-1/2 animation-delay-2000"></div>
    </div>

    {{-- MAIN CARD --}}
    <div class="w-full sm:max-w-md mt-6 px-8 py-10 login-card rounded-[2rem] relative z-10 animate__animated animate__zoomIn">
        
        {{-- Header --}}
        <div class="text-center mb-8">
            <div class="mx-auto w-16 h-16 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/30 transform rotate-3 hover:rotate-0 transition-all duration-300 mb-4">
                <i class="fas fa-fingerprint text-3xl text-white"></i>
            </div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Selamat Datang</h2>
            <p class="text-slate-500 text-sm mt-1">Masuk untuk mengelola sistem Lapas.</p>
        </div>

        {{-- Status Session --}}
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            {{-- Email Input --}}
            <div class="space-y-1.5">
                <label for="email" class="block text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Email / NIP</label>
                <div class="input-group">
                    <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="contoh@keminipas.go.id">
                    <i class="fas fa-envelope icon"></i>
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1 ml-1 text-xs" />
            </div>

            {{-- Password Input --}}
            <div class="space-y-1.5" x-data="{ show: false }">
                <label for="password" class="block text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Kata Sandi</label>
                <div class="input-group">
                    <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="current-password" placeholder="••••••••">
                    <i class="fas fa-lock icon"></i>
                    
                    {{-- Toggle Eye --}}
                    <button type="button" @click="show = !show" class="toggle-password focus:outline-none">
                        <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1 ml-1 text-xs" />
            </div>

            {{-- Remember & Forgot Password Row --}}
            <div class="flex items-center justify-between pt-2">
                <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                    <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500 cursor-pointer" name="remember">
                    <span class="ml-2 text-sm text-slate-600 group-hover:text-slate-800 transition-colors">Ingat Saya</span>
                </label>

                {{-- Forgot Password Link --}}
                @if (Route::has('password.request'))
                    <a class="text-sm font-bold text-blue-600 hover:text-indigo-700 transition-colors" href="{{ route('password.request') }}">
                        Lupa Password?
                    </a>
                @endif
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="w-full py-3.5 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-blue-200 flex items-center justify-center gap-2">
                <span>MASUK AKUN</span>
                <i class="fas fa-arrow-right"></i>
            </button>
        </form>
    </div>

    {{-- Footer --}}
    <div class="mt-8 text-center text-slate-400 text-xs relative z-10 animate__animated animate__fadeInUp animate__delay-1s">
        &copy; {{ date('Y') }} Sistem Informasi Lapas Kelas IIB Jombang.
    </div>
</x-guest-layout>