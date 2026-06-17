<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/png" href="{{ asset('download.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login – Desa Ketileng</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        /* Mobile text shadow only */
        @media (max-width: 1023px) {
            .mobile-text-shadow { text-shadow: 0 1px 10px rgba(0,0,0,0.95); }
        }
        /* Desktop text colors - force override */
        @media (min-width: 1024px) {
            .mobile-text-shadow { text-shadow: none !important; }
            .login-tagline  { color: #059669 !important; }  /* blue-600 */
            .login-heading  { color: #0f172a !important; }  /* slate-900 */
            .login-desc     { color: #475569 !important; }  /* slate-600 */
            .login-label    { color: #374151 !important; }  /* slate-700 */
            .login-footer   { color: #4b5563 !important; }  /* gray-600 */
            .login-help     { color: #6b7280 !important; }  /* gray-500 */
            .login-help-link { color: #374151 !important; } /* slate-700 */
            /* Fix input text on desktop */
            .login-input {
                color: #334155 !important;        /* slate-700 */
                background-color: #ffffff !important;
                border-color: #e2e8f0 !important; /* slate-200 */
            }
            .login-input::placeholder {
                color: #94a3b8 !important;        /* slate-400 */
            }
        }
    </style>
</head>
<body class="min-h-screen bg-white font-[Inter] flex flex-col">

<div class="flex flex-1 relative min-h-0">
    {{-- LEFT: Gambar / Branding --}}
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-slate-950">
        {{-- Background Image with Unsplash Fallback --}}
        <div class="absolute inset-0 bg-cover bg-center transition-all duration-700 transform scale-105 hover:scale-100" 
             style="background-image: url('{{ asset('images/bg_desa.png') }}');">
        </div>
        {{-- Premium Vignette Dark Gradient Overlay for optimal text contrast --}}
        <div class="absolute inset-0 bg-gradient-to-b from-slate-950/70 via-slate-900/20 to-slate-950/95"></div>
        <div class="relative z-10 flex flex-col justify-between p-10 w-full">
            {{-- Logo --}}
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center">
                    <img src="{{ asset('download.png') }}" alt="logo" class="w-full h-full object-contain">
                </div>
                <div>
                    <p class="text-white font-bold text-lg leading-none">SIPADU</p>
                    <p class="text-blue-300/90 font-semibold text-xs mt-0.5 tracking-wide">Desa Ketileng</p>
                </div>
            </div>

            {{-- Hero Text --}}
            <div class="space-y-6">
                <div class="space-y-3">
                    <h1 class="text-white text-4xl font-bold leading-tight">
                        Transformasi<br>Layanan Publik<br>Desa Ketileng
                    </h1>
                    <p class="text-slate-200 text-base leading-relaxed max-w-sm">
                        Platform tata kelola modern untuk administrasi yang lebih cepat, transparan,
                        dan terintegrasi langsung dengan data kependudukan.
                    </p>
                </div>

                {{-- Feature chips --}}
                <div class="flex flex-wrap gap-2">
                    @foreach(['QR Code Terverifikasi','Pengajuan Online','Real-time Status','3 Level Akses'] as $f)
                    <span class="px-3 py-1.5 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full text-xs text-white font-medium">
                        {{ $f }}
                    </span>
                    @endforeach
                </div>
            </div>

            {{-- Bottom info --}}
            <div class="flex items-center gap-2 text-slate-300 text-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Desa Ketileng, Kec. Kramat, Kab. Tegal
            </div>
        </div>
    </div>

    {{-- RIGHT: Form Login --}}
    <div class="flex-1 flex items-center justify-center p-6 sm:p-12 md:p-16 bg-slate-950 lg:bg-white relative overflow-hidden">
        {{-- Mobile Background Image - tampil penuh dengan opacity cukup agar terlihat --}}
        <div class="absolute inset-0 bg-cover bg-center lg:hidden z-0 scale-105" 
             style="background-image: url('{{ asset('images/bg_desa.png') }}');">
        </div>
        {{-- Overlay lebih ringan agar gambar desa tetap terlihat namun form tetap terbaca --}}
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/55 via-slate-900/65 to-slate-950/80 lg:hidden z-0"></div>

        {{-- Form Container: pakai glassmorphic card di mobile, transparan di desktop --}}
        <div class="w-full max-w-md space-y-6 relative z-10 lg:p-0 lg:bg-transparent lg:border-none lg:shadow-none"
             style="background: rgba(15,23,42,0.55); backdrop-filter: blur(18px); -webkit-backdrop-filter: blur(18px); border: 1px solid rgba(255,255,255,0.10); border-radius: 20px; padding: 28px 24px;"
             id="login-card-wrapper">
        <style>
            @media (min-width: 1024px) {
                #login-card-wrapper {
                    background: transparent !important;
                    backdrop-filter: none !important;
                    -webkit-backdrop-filter: none !important;
                    border: none !important;
                    border-radius: 0 !important;
                    padding: 0 !important;
                }
            }
        </style>
            
            {{-- Mobile logo --}}
            <div class="lg:hidden flex items-center gap-2 mb-6">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center">
                    {{-- <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg> --}}
                    <img src="{{ asset('download.png') }}" alt="logo">
                </div>
                <span class="font-bold text-white">SIPADU Desa Ketileng</span>
            </div>

            <div class="space-y-3">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 lg:bg-blue-50 border border-white/20 lg:border-blue-100 backdrop-blur-md lg:backdrop-blur-none shadow-sm mb-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-400 lg:bg-blue-600 animate-pulse"></span>
                    <p class="text-[10px] font-bold text-white lg:text-blue-600 uppercase tracking-widest mobile-text-shadow lg:!shadow-none">Sistem Administrasi Terpadu</p>
                </div>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-white lg:text-transparent lg:bg-clip-text lg:bg-gradient-to-br lg:from-slate-900 lg:to-blue-800 tracking-tight mobile-text-shadow lg:!shadow-none">Selamat Datang</h2>
                <p class="text-white/90 lg:text-slate-500 text-sm leading-relaxed mobile-text-shadow lg:!shadow-none font-medium">
                    Silakan masuk menggunakan NIK (untuk warga) atau Email (untuk Admin/Kades) Anda untuk mengakses portal pelayanan digital.
                </p>
            </div>

            {{-- Alert error --}}
            @if($errors->has('login'))
            <div class="alert-error flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                {{ $errors->first('login') }}
            </div>
            @endif

            @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
                @csrf

                {{-- NIK atau Email --}}
                <div>
                    <label for="login" class="login-label form-label text-white">NIK atau Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-300 lg:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2"/>
                            </svg>
                        </div>
                        <input id="login" name="login" type="text"
                               value="{{ old('login') }}"
                               class="login-input form-input bg-white/10 text-white placeholder-white/50 border-white/30 focus:bg-white/15 focus:border-blue-400 pl-11 @error('login') border-red-400 focus:ring-red-400 @enderror"
                               placeholder="Masukkan NIK atau Email" required autofocus>
                    </div>
                    @error('login')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="login-label form-label text-white mb-0">Kata Sandi</label>
                        <a href="{{ route('password.request') }}" class="login-label text-xs text-white font-bold mobile-text-shadow hover:text-blue-300 lg:text-slate-500 lg:hover:text-blue-600 transition-colors">
                            Lupa Kata Sandi?
                        </a>
                    </div>
                    <div class="relative" style="position: relative;">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-300 lg:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input id="password" name="password" type="password"
                               class="login-input form-input bg-white/10 text-white placeholder-white/50 border-white/30 focus:bg-white/15 focus:border-blue-400 pl-11 pr-10 @error('password') border-red-400 @enderror"
                               placeholder="Masukkan kata sandi Anda" required>
                        <button type="button" id="toggle-password-btn" class="flex items-center text-slate-300 lg:text-slate-400 hover:text-white lg:hover:text-slate-600 focus:outline-none" style="position: absolute; right: 16px; top: 0; bottom: 0; z-index: 10; cursor: pointer;">
                            {{-- Icon Mata Terpejam (Hide) --}}
                            <svg id="eye-icon-hide" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                            </svg>
                            {{-- Icon Mata Terbuka (Show) --}}
                            <svg id="eye-icon-show" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full btn-secondary justify-center py-3.5 text-base rounded-xl bg-slate-900 hover:bg-slate-800 text-white lg:text-white border border-slate-800/10 hover:border-slate-800/30">
                    Masuk ke Portal
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </form>

            <div class="text-center space-y-3 pt-6 border-t border-white/20 lg:border-slate-200">
                <p class="login-footer text-white font-medium mobile-text-shadow text-sm">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-blue-300 lg:text-blue-600 font-bold hover:text-blue-400 lg:hover:text-blue-700 transition-colors">
                        Daftar di sini
                    </a>
                </p>
                <p class="login-help text-white font-medium mobile-text-shadow text-xs">
                    Butuh bantuan?
                    <a href="https://wa.me/62895385213235" class="login-help-link text-white font-bold mobile-text-shadow hover:text-blue-300 lg:hover:text-blue-600 transition-colors">
                        Hubungi Administrator Desa
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

{{-- Footer UHN --}}
<footer style="background-color: #f8f9fa; border-top: 1px solid #e2e8f0; padding: 16px 48px; flex-shrink: 0; width: 100%; position: relative; z-index: 20;">
    <div style="display: flex; justify-content: space-between; align-items: center; width: 100%; flex-wrap: wrap; gap: 16px;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <div style="width: 38px; height: 38px; padding: 6px; background-color: #ffffff; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 1px solid #f1f5f9; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);">
                <img src="{{ asset('uhn.png') }}" alt="UHN Logo" style="width: 100%; height: 100%; object-fit: contain;">
            </div>
            <div style="display: flex; flex-direction: column; justify-content: center; text-align: left;">
                <p style="color: #1e293b; font-size: 11px; letter-spacing: 0.08em; line-height: 1; margin: 0 0 4px 0; font-weight: 700; text-transform: uppercase;">Universitas Harkat Negeri</p>
                <p style="color: #64748b; font-size: 9px; letter-spacing: 0.1em; line-height: 1; margin: 0; font-weight: 600; text-transform: uppercase;">Prodi Teknik Komputer</p>
            </div>
        </div>
        <div style="display: flex; flex-direction: column; justify-content: center; text-align: right;">
            <p style="color: #1e293b; font-size: 11px; letter-spacing: 0.08em; line-height: 1; margin: 0 0 4px 0; font-weight: 700; text-transform: uppercase;">© 2026 Tugas Akhir.</p>
            <p style="color: #64748b; font-size: 9px; letter-spacing: 0.1em; line-height: 1; margin: 0; font-weight: 600; text-transform: uppercase;">All Rights Reserved.</p>
        </div>
    </div>
</footer>

@livewireScripts
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        const toggleBtn = document.getElementById('toggle-password-btn');
        const eyeHide = document.getElementById('eye-icon-hide');
        const eyeShow = document.getElementById('eye-icon-show');

        if (toggleBtn && passwordInput && eyeHide && eyeShow) {
            toggleBtn.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeHide.classList.add('hidden');
                    eyeShow.classList.remove('hidden');
                } else {
                    passwordInput.type = 'password';
                    eyeShow.classList.add('hidden');
                    eyeHide.classList.remove('hidden');
                }
            });
        }
    });
</script>
</body>
</html>
