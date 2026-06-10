<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/png" href="{{ asset('download.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Kata Sandi – Desa Ketileng</title>
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
        <div class="absolute inset-0 bg-cover bg-center transition-all duration-700 transform scale-105 hover:scale-100" 
             style="background-image: url('{{ asset('images/bg_desa.png') }}');">
        </div>
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
                        Keamanan Akses<br>Terjaga & Terlindungi
                    </h1>
                    <p class="text-slate-200 text-base leading-relaxed max-w-sm">
                        Buat kata sandi baru yang kuat untuk melindungi data pribadi dan status pengajuan surat-surat Anda.
                    </p>
                </div>

                {{-- Feature chips --}}
                <div class="flex flex-wrap gap-2">
                    @foreach(['Enkripsi Kuat','Min. 8 Karakter','Kata Sandi Unik','Proteksi Privasi'] as $f)
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

    {{-- RIGHT: Form Reset Password --}}
    <div class="flex-1 flex items-center justify-center p-6 sm:p-12 md:p-16 bg-slate-950 lg:bg-white relative overflow-hidden">
        {{-- Mobile Background --}}
        <div class="absolute inset-0 bg-cover bg-center lg:hidden z-0 opacity-15 scale-105" 
             style="background-image: url('{{ asset('images/bg_desa.png') }}');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-slate-950/85 via-slate-950/92 to-slate-950 lg:hidden z-0"></div>

        {{-- Form Container --}}
        <div class="w-full max-w-md space-y-8 relative z-10 p-0 bg-transparent border-none shadow-none">
            
            {{-- Mobile logo --}}
            <div class="lg:hidden flex items-center gap-2 mb-6">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center">
                    <img src="{{ asset('download.png') }}" alt="logo" class="w-full h-full object-contain">
                </div>
                <span class="font-bold text-white">SIPADU Desa Ketileng</span>
            </div>

            <div class="space-y-3">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 lg:bg-blue-50 border border-white/20 lg:border-blue-100 backdrop-blur-md lg:backdrop-blur-none shadow-sm mb-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-400 lg:bg-blue-600 animate-pulse"></span>
                    <p class="text-[10px] font-bold text-white lg:text-blue-600 uppercase tracking-widest mobile-text-shadow lg:!shadow-none">Langkah Terakhir Pemulihan</p>
                </div>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-white lg:text-transparent lg:bg-clip-text lg:bg-gradient-to-br lg:from-slate-900 lg:to-blue-800 tracking-tight mobile-text-shadow lg:!shadow-none">Kata Sandi Baru</h2>
                <p class="text-white/90 lg:text-slate-500 text-sm leading-relaxed mobile-text-shadow lg:!shadow-none font-medium">
                    Silakan tentukan kata sandi baru untuk akun Anda. Gunakan minimal 8 karakter kombinasi huruf dan angka agar aman.
                </p>
            </div>

            {{-- Alert error --}}
            @if($errors->any())
            <div class="alert-error flex flex-col gap-1">
                @foreach ($errors->all() as $error)
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ $error }}</span>
                </div>
                @endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                @csrf

                {{-- Password Baru --}}
                <div>
                    <label for="password" class="login-label form-label text-white">Kata Sandi Baru</label>
                    <div class="relative" style="position: relative;">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-300 lg:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input id="password" name="password" type="password"
                               class="login-input form-input bg-white/10 text-white placeholder-white/50 border-white/30 focus:bg-white/15 focus:border-blue-400 pl-11 pr-12"
                               placeholder="Masukkan kata sandi baru" required autofocus>
                        <button type="button" id="toggle-password-btn" class="flex items-center text-slate-300 lg:text-slate-400 hover:text-white lg:hover:text-slate-600 focus:outline-none" style="position: absolute; right: 16px; top: 0; bottom: 0; z-index: 10; cursor: pointer;">
                            <svg id="eye-icon-hide" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                            </svg>
                            <svg id="eye-icon-show" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Konfirmasi Password Baru --}}
                <div>
                    <label for="password_confirmation" class="login-label form-label text-white">Konfirmasi Kata Sandi</label>
                    <div class="relative" style="position: relative;">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-300 lg:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <input id="password_confirmation" name="password_confirmation" type="password"
                               class="login-input form-input bg-white/10 text-white placeholder-white/50 border-white/30 focus:bg-white/15 focus:border-blue-400 pl-11 pr-12"
                               placeholder="Ulangi kata sandi baru" required>
                        <button type="button" id="toggle-password-confirm-btn" class="flex items-center text-slate-300 lg:text-slate-400 hover:text-white lg:hover:text-slate-600 focus:outline-none" style="position: absolute; right: 16px; top: 0; bottom: 0; z-index: 10; cursor: pointer;">
                            <svg id="eye-confirm-icon-hide" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                            </svg>
                            <svg id="eye-confirm-icon-show" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full btn-secondary justify-center py-3.5 text-base rounded-xl bg-slate-900 hover:bg-slate-800 text-white lg:text-white border border-slate-800/10 hover:border-slate-800/30">
                    Simpan Kata Sandi Baru
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </button>
            </form>
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
        // Toggle Password Baru
        const passwordInput = document.getElementById('password');
        const toggleBtn = document.getElementById('toggle-password-btn');
        const eyeIconHide = document.getElementById('eye-icon-hide');
        const eyeIconShow = document.getElementById('eye-icon-show');

        toggleBtn.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIconHide.classList.add('hidden');
                eyeIconShow.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIconHide.classList.remove('hidden');
                eyeIconShow.classList.add('hidden');
            }
        });

        // Toggle Konfirmasi Password
        const passwordConfirmInput = document.getElementById('password_confirmation');
        const toggleConfirmBtn = document.getElementById('toggle-password-confirm-btn');
        const eyeConfirmIconHide = document.getElementById('eye-confirm-icon-hide');
        const eyeConfirmIconShow = document.getElementById('eye-confirm-icon-show');

        toggleConfirmBtn.addEventListener('click', function() {
            if (passwordConfirmInput.type === 'password') {
                passwordConfirmInput.type = 'text';
                eyeConfirmIconHide.classList.add('hidden');
                eyeConfirmIconShow.classList.remove('hidden');
            } else {
                passwordConfirmInput.type = 'password';
                eyeConfirmIconHide.classList.remove('hidden');
                eyeConfirmIconShow.classList.add('hidden');
            }
        });
    });
</script>
</body>
</html>
