<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Warga') – Desa Ketileng</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        /* ── BULLETPROOF RESPONSIVE SIDEBAR (VANILLA CSS) ── */
        #sidebar {
            width: 14rem !important;
            position: fixed !important;
            top: 0 !important;
            bottom: 0 !important;
            left: -14rem !important; /* Tersembunyi di kiri by default */
            z-index: 50 !important;
            transition: left 0.3s ease-in-out !important;
        }
        
        #sidebar.active {
            left: 0 !important; /* Muncul ketika aktif di mobile */
        }
        
        #sidebar-overlay {
            position: fixed !important;
            inset: 0 !important;
            background-color: rgba(15, 23, 42, 0.5) !important;
            z-index: 40 !important;
            opacity: 0 !important;
            pointer-events: none !important;
            transition: opacity 0.3s ease-in-out !important;
        }
        
        #sidebar-overlay.active {
            opacity: 1 !important;
            pointer-events: auto !important;
        }
        
        #main-content {
            margin-left: 0 !important;
            transition: margin-left 0.3s ease-in-out !important;
            width: 100% !important;
        }
        
        #sidebar-toggle {
            display: flex !important;
        }

        /* Desktop View (Layar Lebar >= 1024px) */
        @media (min-width: 1024px) {
            #sidebar {
                left: 0 !important; /* Selalu tampil di desktop */
            }
            #main-content {
                margin-left: 14rem !important; /* Beri ruang lebar sidebar */
                width: calc(100% - 14rem) !important;
            }
            #sidebar-toggle {
                display: none !important; /* Sembunyikan tombol toggle di desktop */
            }
            #sidebar-overlay {
                display: none !important;
                pointer-events: none !important;
            }
        }
    </style>
</head>
<body class="bg-slate-50 font-[Inter]">

<div class="flex min-h-screen">
    {{-- OVERLAY BACKDROP --}}
    <div id="sidebar-overlay"></div>

    {{-- ── SIDEBAR ── --}}
    <aside id="sidebar" class="bg-slate-900 flex flex-col fixed inset-y-0 left-0 z-50">
        {{-- Logo --}}
        <div class="p-5 border-b border-slate-800">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-white font-bold text-sm leading-none">Desa Digital</p>
                    <p class="text-slate-500 text-xs">Governance Portal</p>
                </div>
            </div>
        </div>


        {{-- Navigation --}}
        <nav class="flex-1 px-4 space-y-1 pb-4 pt-4">
            <a href="{{ route('warga.dashboard') }}"
               class="sidebar-link {{ request()->routeIs('warga.dashboard') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>
            <a href="{{ route('warga.pilih_surat') }}"
               class="sidebar-link {{ request()->routeIs('warga.pilih_surat') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Ajukan Surat
            </a>
            <a href="{{ route('warga.status') }}"
               class="sidebar-link {{ request()->routeIs('warga.status') && request()->has('filter') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Status
            </a>
            <a href="{{ route('warga.profile') }}"
               class="sidebar-link {{ request()->routeIs('warga.profile') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Profile
            </a>
        </nav>

        {{-- Bottom --}}
        <div class="border-t border-slate-800 p-4 space-y-1">
            <a href="#" class="sidebar-link text-slate-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Bantuan
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-link w-full text-red-400 hover:text-red-300 hover:bg-red-900/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- ── MAIN CONTENT ── --}}
    <main id="main-content" class="flex-1 min-w-0 flex flex-col">
        {{-- ── MOBILE HEADER ── --}}
        <header class="bg-white border-b border-slate-100 px-6 py-4 flex lg:hidden items-center justify-between sticky top-0 z-30">
            <div class="flex items-center gap-3">
                <button id="sidebar-toggle" class="p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-lg flex-shrink-0" aria-label="Toggle Sidebar">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <span class="font-bold text-slate-800 text-sm">Portal Warga</span>
            </div>
            <div class="w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center text-white text-sm font-bold">
                {{ strtoupper(substr(auth()->user()->name ?? 'W', 0, 1)) }}
            </div>
        </header>

        {{-- Alerts --}}
        @if(session('success'))
        <div class="mx-4 md:mx-8 mt-6">
            <div class="alert-success flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        </div>
        @endif
        @if(session('error'))
        <div class="mx-4 md:mx-8 mt-6">
            <div class="alert-error flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                {{ session('error') }}
            </div>
        </div>
        @endif

        <div class="p-4 md:p-8">
            @yield('content')
        </div>
    </main>
</div>

@livewireScripts
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('sidebar-toggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        if (toggleBtn && sidebar && overlay) {
            function toggleSidebar() {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            }

            toggleBtn.addEventListener('click', toggleSidebar);
            overlay.addEventListener('click', toggleSidebar);
        }
    });
</script>
</body>
</html>
