<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/png" href="{{ asset('download.png') }}">
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
            left: -14rem !important;
            z-index: 50 !important;
            transition: left 0.3s ease-in-out !important;
        }
        #sidebar.active {
            left: 0 !important;
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
        @media (min-width: 1024px) {
            #sidebar { left: 0 !important; }
            #main-content {
                margin-left: 14rem !important;
                width: calc(100% - 14rem) !important;
            }
            #sidebar-toggle { display: none !important; }
            #sidebar-overlay { display: none !important; pointer-events: none !important; }
        }
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-down {
            animation: fadeInDown 0.15s ease-out;
        }

        /* ── PREMIUM AURORA GLASSMORPHISM ── */
        body {
            background: linear-gradient(135deg, #eef2ff 0%, #f5f3ff 40%, #ecfdf5 100%) !important;
        }
        #main-content {
            background: transparent !important;
            position: relative;
        }
        .aurora-blob {
            position: fixed;
            border-radius: 50%;
            filter: blur(90px);
            pointer-events: none;
            z-index: 0;
            opacity: 0.85;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.72) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
            border: 1px solid rgba(255, 255, 255, 0.55) !important;
            box-shadow: 0 4px 24px rgba(99, 102, 241, 0.07), 0 1px 3px rgba(0,0,0,0.05) !important;
            position: relative;
            z-index: 1;
            transition: box-shadow 0.25s ease, transform 0.25s ease;
        }
        .glass-card:hover {
            box-shadow: 0 8px 32px rgba(99, 102, 241, 0.13), 0 2px 8px rgba(0,0,0,0.07) !important;
            transform: translateY(-1px);
        }
    </style>
</head>
<body class="bg-slate-50 font-[Inter]">
<div class="flex min-h-screen">
    {{-- AURORA BLOBS --}}
    <div class="aurora-blob" style="width:520px;height:520px;background:rgba(99,102,241,0.13);top:-80px;right:-60px;"></div>
    <div class="aurora-blob" style="width:420px;height:420px;background:rgba(59,130,246,0.11);top:250px;left:-80px;"></div>
    <div class="aurora-blob" style="width:360px;height:360px;background:rgba(16,185,129,0.09);bottom:80px;right:120px;"></div>
    <div class="aurora-blob" style="width:300px;height:300px;background:rgba(168,85,247,0.10);bottom:220px;left:220px;"></div>

    {{-- OVERLAY BACKDROP --}}
    <div id="sidebar-overlay"></div>

    {{-- ── SIDEBAR ── --}}
    <aside id="sidebar" class="bg-slate-900 flex flex-col fixed inset-y-0 left-0 z-50">
        {{-- Logo --}}
        <div class="p-5 border-b border-slate-800">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0">
                    <img src="{{ asset('download.png') }}" alt="logo" class="w-full h-full object-contain">
                </div>
                <div>
                    <p class="text-white font-bold text-sm leading-none">SIPADU</p>
                    <p class="text-slate-500 text-xs">Desa Ketileng</p>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-4 space-y-1 pb-4 pt-4">
            <a href="{{ route('kades.dashboard') }}"
               class="sidebar-link {{ request()->routeIs('kades.dashboard') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                Antrean Tanda Tangan
            </a>
            <a href="{{ route('kades.surat-disetujui') }}"
               class="sidebar-link {{ request()->routeIs('kades.surat-disetujui') || request()->routeIs('kades.detail-surat') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Surat Disetujui
            </a>
        </nav>
    </aside>

    {{-- ── MAIN CONTENT ── --}}
    <main id="main-content" class="flex-1 min-w-0 flex flex-col">
        {{-- ── HEADER ── --}}
        <header class="px-6 py-3.5 flex items-center justify-between sticky top-0 z-30" style="background-color: rgba(255, 255, 255, 0.85); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border-bottom: 1px solid rgba(226, 232, 240, 0.8); z-index: 100;">
            <div class="flex items-center gap-3">
                <button id="sidebar-toggle" class="p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-lg flex-shrink-0" aria-label="Toggle Sidebar">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <div class="flex items-center gap-2.5">
                    <div style="width: 28px; height: 28px; border-radius: 6px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 4px;">
                        <img src="{{ asset('download.png') }}" alt="Logo Desa" style="width: 100%; height: 100%; object-fit: contain;">
                    </div>
                    <div style="display: flex; flex-direction: column; text-align: left; line-height: 1.2;">
                        <span style="font-weight: 800; color: #1e293b; font-size: 13px; letter-spacing: -0.01em;">Persetujuan Kades</span>
                        <span style="font-size: 10px; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Desa Ketileng</span>
                    </div>
                </div>
            </div>
            {{-- Flex container untuk sisi kanan header --}}
            <div class="flex items-center gap-4">
                {{-- Lonceng Notifikasi Real-time (Livewire) --}}
                <livewire:notification-bell />

                {{-- Profile Dropdown --}}
                <div class="relative" style="position: relative; display: flex; align-items: center; gap: 12px;">
                    <div style="text-align: right; line-height: 1.3;" class="hidden sm:block">
                        <p style="font-size: 12px; font-weight: 700; color: #334155; margin: 0;">{{ explode(' ', auth()->user()->name)[0] }}</p>
                        <p style="font-size: 9px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin: 0;">Kepala Desa</p>
                    </div>
                    <button type="button"
                        onclick="event.stopPropagation(); const m = document.getElementById('profile-dropdown-menu'); m.style.display = (m.style.display === 'block' ? 'none' : 'block');"
                        class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-bold shadow-sm hover:bg-blue-600 transition-colors focus:outline-none cursor-pointer">
                        {{ strtoupper(substr(auth()->user()->name ?? 'K', 0, 1)) }}
                    </button>

                    {{-- Dropdown Card --}}
                    <div id="profile-dropdown-menu"
                         style="display: none; position: absolute; right: 0; top: 100%; margin-top: 8px; width: 210px; background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); padding: 8px 0; z-index: 300;"
                         onclick="event.stopPropagation();">
                        <div class="px-4 py-2.5 border-b border-slate-50">
                            <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Nama Akun</p>
                            <p class="text-sm font-bold text-slate-800 truncate mt-0.5">{{ auth()->user()->name }}</p>
                            <p class="text-[11px] text-blue-600 font-semibold mt-0.5">Kepala Desa</p>
                        </div>
                        <a href="{{ route('kades.profile') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Lihat Profil
                        </a>
                        <hr class="border-slate-50 my-1">
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
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

        <div id="page-content" class="p-4 md:p-8">
            @yield('content')
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

        // ── PROFILE DROPDOWN MENU ──
        document.addEventListener('click', function() {
            const profileMenu = document.getElementById('profile-dropdown-menu');
            if (profileMenu) {
                profileMenu.style.display = 'none';
            }
        });

        // ── AUTO-DISMISS ALERT NOTIFICATIONS ──
        const autoDismissAlerts = () => {
            const alerts = document.querySelectorAll('.alert-success, .alert-error, [class*="alert-"]');
            alerts.forEach(alert => {
                if (alert.dataset.autoDismissed) return;
                alert.dataset.autoDismissed = "true";

                alert.style.transition = 'all 0.5s cubic-bezier(0.4, 0, 0.2, 1)';

                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-8px)';
                    alert.style.maxHeight = '0px';
                    alert.style.marginTop = '0px';
                    alert.style.marginBottom = '0px';
                    alert.style.paddingTop = '0px';
                    alert.style.paddingBottom = '0px';
                    alert.style.overflow = 'hidden';

                    setTimeout(() => {
                        const parent = alert.parentElement;
                        alert.remove();
                        if (parent && parent.children.length === 0 && parent.classList.contains('mx-4')) {
                            parent.remove();
                        }
                    }, 500);
                }, 3500);
            });
        };

        autoDismissAlerts();

        const alertObserver = new MutationObserver(() => autoDismissAlerts());
        alertObserver.observe(document.body, { childList: true, subtree: true });
    });
</script>
@include('partials.fcm-script')
</body>
</html>
