<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login – Desa Ketileng</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-white font-[Inter]">

<div class="flex min-h-screen">
    {{-- LEFT: Gambar / Branding --}}
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-slate-900">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-emerald-900"></div>
        {{-- Grid pattern overlay --}}
        <div class="absolute inset-0 opacity-10"
             style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
        </div>
        <div class="relative z-10 flex flex-col justify-between p-10 w-full">
            {{-- Logo --}}
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-white font-bold text-lg leading-none">Desa Digital</p>
                    <p class="text-slate-400 text-xs">Governance Portal</p>
                </div>
            </div>

            {{-- Hero Text --}}
            <div class="space-y-6">
                <div class="space-y-3">
                    <h1 class="text-white text-4xl font-bold leading-tight">
                        Transformasi<br>Layanan Publik<br>Desa Anda
                    </h1>
                    <p class="text-slate-300 text-base leading-relaxed max-w-sm">
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

    {{-- RIGHT: Form Login --}}
    <div class="flex-1 flex items-center justify-center p-8 bg-white">
        <div class="w-full max-w-md space-y-8">
            {{-- Mobile logo --}}
            <div class="lg:hidden flex items-center gap-2 mb-6">
                <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <span class="font-bold text-slate-800">Desa Ketileng</span>
            </div>

            <div>
                <h2 class="text-3xl font-bold text-slate-900">Selamat Datang</h2>
                <p class="text-slate-500 mt-2 text-sm leading-relaxed">
                    Silakan masuk menggunakan NIK (untuk warga) atau Email (untuk Admin/Kades) Anda untuk mengakses portal layanan.
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

            <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                @csrf

                {{-- NIK atau Email --}}
                <div>
                    <label for="login" class="form-label">NIK atau Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2"/>
                            </svg>
                        </div>
                        <input id="login" name="login" type="text"
                               value="{{ old('login') }}"
                               class="form-input pl-11 @error('login') border-red-400 focus:ring-red-400 @enderror"
                               placeholder="Masukkan NIK atau Email" required autofocus>
                    </div>
                    @error('login')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="form-label mb-0">Kata Sandi</label>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input id="password" name="password" type="password"
                               class="form-input pl-11 @error('password') border-red-400 @enderror"
                               placeholder="Masukkan kata sandi Anda" required>
                    </div>
                    @error('password')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full btn-secondary justify-center py-3 text-base rounded-xl bg-slate-900 hover:bg-slate-800">
                    Masuk ke Portal
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </form>

            <div class="text-center space-y-3">
                <p class="text-slate-600 text-sm">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-emerald-600 font-semibold hover:text-emerald-700 transition-colors">
                        Daftar di sini
                    </a>
                </p>
                <p class="text-slate-400 text-xs">
                    Butuh bantuan?
                    <a href="https://wa.me/6281234567890" class="text-slate-600 font-semibold hover:text-emerald-600 transition-colors">
                        Hubungi Administrator Desa
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

@livewireScripts
</body>
</html>
