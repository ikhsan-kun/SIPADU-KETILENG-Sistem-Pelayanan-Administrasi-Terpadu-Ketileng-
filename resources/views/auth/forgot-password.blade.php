<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/png" href="{{ asset('download.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi – Desa Ketileng</title>
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
                        Akses Portal<br>Pelayanan Digital<br>Desa Ketileng
                    </h1>
                    <p class="text-slate-200 text-base leading-relaxed max-w-sm">
                        Verifikasi identitas kependudukan Anda untuk memulihkan akses akun mandiri secara aman.
                    </p>
                </div>

                {{-- Feature chips --}}
                <div class="flex flex-wrap gap-2">
                    @foreach(['Verifikasi NIK & KK','Pemulihan Mandiri','Keamanan 256-bit','Tanpa Email'] as $f)
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

    {{-- RIGHT: Form Lupa Password --}}
    <div class="flex-1 flex items-center justify-center p-6 sm:p-12 md:p-16 bg-white relative overflow-hidden">

        {{-- Form Container --}}
        <div class="w-full max-w-md space-y-8 relative z-10">
            
            {{-- Mobile logo --}}
            <div class="lg:hidden flex items-center gap-2 mb-6">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center">
                    <img src="{{ asset('download.png') }}" alt="logo" class="w-full h-full object-contain">
                </div>
                <span class="font-bold text-slate-800">SIPADU Desa Ketileng</span>
            </div>

            <div class="space-y-3">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 border border-blue-100 shadow-sm mb-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></span>
                    <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">Pemulihan Akun Warga</p>
                </div>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-br from-slate-900 to-blue-800 tracking-tight">Lupa Kata Sandi?</h2>
                <p class="text-slate-500 text-sm leading-relaxed font-medium">
                    Silakan masukkan NIK dan Nomor KK Anda yang terdaftar pada database kependudukan Desa Ketileng untuk memverifikasi akun Anda.
                </p>
            </div>

            {{-- Alert error --}}
            @if($errors->has('nik'))
            <div class="alert-error flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                {{ $errors->first('nik') }}
            </div>
            @endif

            @if($errors->has('no_kk'))
            <div class="alert-error flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                {{ $errors->first('no_kk') }}
            </div>
            @endif

            <form method="POST" action="{{ route('password.verify') }}" class="space-y-6">
                @csrf

                {{-- NIK --}}
                <div>
                    <label for="nik" class="form-label">Nomor Induk Kependudukan (NIK)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2"/>
                            </svg>
                        </div>
                        <input id="nik" name="nik" type="text" maxlength="16"
                               value="{{ old('nik') }}"
                               class="form-input pl-11 @error('nik') border-red-400 focus:ring-red-400 @enderror"
                               placeholder="Masukkan 16 digit NIK" required autofocus>
                    </div>
                </div>

                {{-- KK --}}
                <div>
                    <label for="no_kk" class="form-label">Nomor Kartu Keluarga (KK)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </div>
                        <input id="no_kk" name="no_kk" type="text" maxlength="16"
                               value="{{ old('no_kk') }}"
                               class="form-input pl-11 @error('no_kk') border-red-400 @enderror"
                               placeholder="Masukkan 16 digit Nomor KK" required>
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full btn-secondary justify-center py-3.5 text-base rounded-xl bg-slate-900 hover:bg-slate-800 text-white lg:text-white border border-slate-800/10 hover:border-slate-800/30">
                    Verifikasi Data Penduduk
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </form>

            <div class="text-center space-y-3 pt-6 border-t border-slate-200">
                <p class="text-slate-500 font-medium text-sm">
                    Kembali ke halaman utama?
                    <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:text-blue-700 transition-colors">
                        Masuk ke Portal
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
</body>
</html>
