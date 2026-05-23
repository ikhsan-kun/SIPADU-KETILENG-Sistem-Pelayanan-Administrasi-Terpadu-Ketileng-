<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kepala Desa') – Desa Ketileng</title>
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
            pointer-events: auto;
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

    {{-- SIDEBAR --}}
    <aside id="sidebar" class="bg-slate-900 flex flex-col fixed inset-y-0 left-0 z-50">
        <div class="p-5 border-b border-slate-800">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-slate-700 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-white font-bold text-sm leading-none">Desa Digital</p>
                    <p class="text-slate-500 text-xs">Governance Portal</p>
                </div>
            </div>
        </div>
        <nav class="flex-1 px-4 py-4 space-y-1">
            <a href="{{ route('kades.dashboard') }}" class="sidebar-link {{ request()->routeIs('kades.dashboard') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                Antrean Tanda Tangan
            </a>
            <a href="{{ route('kades.surat-disetujui') }}" class="sidebar-link {{ request()->routeIs('kades.surat-disetujui') || request()->routeIs('kades.detail-surat') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Surat Disetujui
            </a>
            <a href="{{ route('kades.profile') }}" class="sidebar-link {{ request()->routeIs('kades.profile') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Profil
            </a>
        </nav>
        <div class="border-t border-slate-800 p-4 space-y-1">
            <a href="#" class="sidebar-link text-slate-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Bantuan
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-link w-full text-red-400 hover:text-red-300 hover:bg-red-900/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>
    <div id="main-content" class="flex-1 flex flex-col min-w-0">
        <header class="bg-white border-b border-slate-100 px-4 md:px-8 py-4 flex items-center justify-between sticky top-0 z-30">
            <div class="flex items-center gap-3">
                <button id="sidebar-toggle" class="p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-lg flex-shrink-0" aria-label="Toggle Sidebar">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Kepala Desa</p>
            </div>
            <div class="flex items-center gap-3">
                <button class="p-2 text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </button>
                <button class="p-2 text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </button>
                <div class="w-8 h-8 rounded-full bg-slate-700 flex items-center justify-center text-white text-sm font-bold">
                    {{ strtoupper(substr(auth()->user()->name ?? 'K', 0, 1)) }}
                </div>
            </div>
        </header>
        @if(session('success'))<div class="mx-4 md:mx-8 mt-4"><div class="alert-success">{{ session('success') }}</div></div>@endif
        @if(session('error'))<div class="mx-4 md:mx-8 mt-4"><div class="alert-error">{{ session('error') }}</div></div>@endif
        <main class="flex-1 p-4 md:p-8">@yield('content')</main>
    </div>
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
