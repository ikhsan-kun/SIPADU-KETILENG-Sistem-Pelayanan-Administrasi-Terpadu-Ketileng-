<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/png" href="{{ asset('download.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun – Desa Ketileng</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        /* Smooth shake animation for errors */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-4px); }
            20%, 40%, 60%, 80% { transform: translateX(4px); }
        }
        .shake { animation: shake 0.5s ease-in-out; }

        /* Floating label focus effect */
        .input-group:focus-within .input-icon {
            color: #10b981;
            transition: color 0.2s ease;
        }
    </style>
</head>
<body class="min-h-screen bg-white font-[Inter] flex flex-col">

<div class="flex flex-1 relative min-h-0">
    {{-- LEFT: Gambar / Branding --}}
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-slate-950">
        {{-- Background Image sama seperti login --}}
        <div class="absolute inset-0 bg-cover bg-center transition-all duration-700 transform scale-105 hover:scale-100"
             style="background-image: url('{{ asset('images/bg_desa.png') }}');">
        </div>
        {{-- Premium Vignette Dark Gradient Overlay --}}
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
                        Daftar Akun<br>Warga Desa<br>Ketileng
                    </h1>
                    <p class="text-slate-300 text-base leading-relaxed max-w-sm">
                        Daftarkan akun Anda untuk mengakses layanan surat-menyurat desa secara online.
                        Data Anda akan diverifikasi dengan database kependudukan desa.
                    </p>
                </div>

            </div>

            {{-- Bottom info --}}
            <div class="flex items-center gap-2 text-slate-400 text-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Desa Ketileng, Kec. Kramat, Kab. Tegal
            </div>
        </div>
    </div>

    {{-- RIGHT: Form Register --}}
    <div class="flex-1 flex items-center justify-center p-8 bg-white relative overflow-hidden">
        <div class="w-full max-w-md space-y-6">
            {{-- Mobile logo --}}
            <div class="lg:hidden flex items-center gap-2 mb-4">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center">
                    <img src="{{ asset('download.png') }}" alt="logo" class="w-full h-full object-contain">
                </div>
                <span class="font-bold text-slate-800">SIPADU Desa Ketileng</span>
            </div>

            <div>
                <h2 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-br from-slate-900 to-blue-800 tracking-tight">Daftar Akun Warga</h2>
                <p class="text-slate-500 mt-2 text-sm leading-relaxed font-medium">
                    Verifikasi identitas Anda menggunakan data kependudukan yang sudah terdaftar di desa.
                </p>
            </div>

            {{-- Info box --}}
            <div class="bg-blue-50 border border-blue-200 rounded-xl px-4 py-3 flex gap-3">
                <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-blue-700 text-xs leading-relaxed">
                    Pastikan data Anda sudah terdaftar di kantor desa. Jika NIK Anda belum terdaftar, silakan hubungi Admin Desa terlebih dahulu.
                </p>
            </div>

            {{-- Alert errors --}}
            @if($errors->any())
            <div class="alert-error flex items-start gap-2 {{ $errors->any() ? 'shake' : '' }}">
                <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div class="text-sm">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
            @endif

            <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
                @csrf

                {{-- NIK --}}
                <div>
                    <label for="nik" class="form-label">NIK (Nomor Induk Kependudukan)</label>
                    <div class="relative input-group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400 input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2"/>
                            </svg>
                        </div>
                        <input id="nik" name="nik" type="text"
                               value="{{ old('nik') }}"
                               maxlength="16"
                               inputmode="numeric"
                               pattern="[0-9]*"
                               class="form-input pl-11 @error('nik') border-red-400 focus:ring-red-400 @enderror"
                               placeholder="Masukkan 16 digit NIK" required autofocus>
                    </div>
                    @error('nik')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- No KK --}}
                <div>
                    <label for="no_kk" class="form-label">No. Kartu Keluarga (KK)</label>
                    <div class="relative input-group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400 input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <input id="no_kk" name="no_kk" type="text"
                               value="{{ old('no_kk') }}"
                               maxlength="16"
                               inputmode="numeric"
                               pattern="[0-9]*"
                               class="form-input pl-11 @error('no_kk') border-red-400 focus:ring-red-400 @enderror"
                               placeholder="Masukkan 16 digit No. KK" required>
                    </div>
                    @error('no_kk')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal Lahir --}}
                <div>
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <div class="relative input-group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400 input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <input id="tanggal_lahir" name="tanggal_lahir" type="date"
                               value="{{ old('tanggal_lahir') }}"
                               class="form-input pl-11 @error('tanggal_lahir') border-red-400 focus:ring-red-400 @enderror"
                               required>
                    </div>
                    @error('tanggal_lahir')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- No HP (opsional) --}}
                <div>
                    <label for="phone" class="form-label">No. HP <span class="text-slate-400 font-normal">(opsional)</span></label>
                    <div class="relative input-group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400 input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <input id="phone" name="phone" type="text"
                               value="{{ old('phone') }}"
                               maxlength="15"
                               class="form-input pl-11"
                               placeholder="Contoh: 081234567890">
                    </div>
                </div>

                {{-- Divider --}}
                <div class="relative py-1">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-200"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="px-3 bg-white text-xs text-slate-400 font-medium">Buat Kata Sandi</span>
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="form-label">Kata Sandi</label>
                    <div class="relative input-group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400 input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input id="password" name="password" type="password"
                               class="form-input pl-11 @error('password') border-red-400 focus:ring-red-400 @enderror"
                               placeholder="Minimal 6 karakter" required>
                    </div>
                    @error('password')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div>
                    <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                    <div class="relative input-group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400 input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <input id="password_confirmation" name="password_confirmation" type="password"
                               class="form-input pl-11"
                               placeholder="Ulangi kata sandi" required>
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full btn-primary justify-center py-3 text-base rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    Daftar Akun
                </button>
            </form>

            {{-- Link ke Login --}}
            <p class="text-center text-slate-500 text-sm">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:text-blue-700 transition-colors">
                    Masuk di sini
                </a>
            </p>

            <p class="text-center text-slate-400 text-xs">
                Butuh bantuan?
                <a href="https://wa.me/6281234567890" class="text-slate-600 font-semibold hover:text-blue-600 transition-colors">
                    Hubungi Administrator Desa
                </a>
            </p>
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
