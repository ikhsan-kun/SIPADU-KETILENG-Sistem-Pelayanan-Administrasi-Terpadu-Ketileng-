<div class="relative" wire:poll.15s="refreshNotifications">

    {{-- ── TOMBOL LONCENG ─────────────────────────────────────── --}}
    <button wire:click="toggleDropdown"
            class="relative p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-all duration-200 focus:outline-none"
            title="Notifikasi">
        {{-- Icon Lonceng --}}
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>

        {{-- Badge merah jumlah belum dibaca dengan style inline (agar pasti muncul warna merahnya) --}}
        @if($unreadCount > 0)
            <span class="absolute shadow-lg animate-pulse" 
                  style="
                      position: absolute;
                      top: -4px;
                      right: -4px;
                      min-width: 22px;
                      height: 22px;
                      background-color: #ef4444;
                      border: 2px solid #ffffff;
                      color: #ffffff;
                      border-radius: 9999px;
                      font-size: 10px;
                      font-weight: 900;
                      display: flex;
                      align-items: center;
                      justify-content: center;
                      padding: 0 4px;
                      line-height: 1;
                      z-index: 50;
                      box-sizing: border-box;
                  ">
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
        @endif
    </button>

    {{-- ── DROPDOWN PANEL ──────────────────────────────────────── --}}
    @if($isOpen)
    <div class="absolute right-0 top-full mt-2 w-80 z-[200]"
         style="filter: drop-shadow(0 20px 40px rgba(15,23,42,0.15));">

        <div style="background: rgba(255,255,255,0.96); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(226,232,240,0.8); border-radius: 16px; overflow: hidden;">

            {{-- Header Dropdown --}}
            <div style="padding: 14px 16px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; background: rgba(248,250,252,0.8);">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <svg style="width: 15px; height: 15px; color: #3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span style="font-size: 13px; font-weight: 700; color: #1e293b;">Notifikasi</span>
                    @if(count($notifications) > 0)
                        <span style="padding: 1px 7px; background-color: #eff6ff; color: #1d4ed8; border-radius: 9999px; font-size: 10px; font-weight: 700;">{{ count($notifications) }}</span>
                    @endif
                </div>
                @if(count($notifications) > 0)
                    <button wire:click="hapusSemua"
                            style="font-size: 10px; font-weight: 600; color: #ef4444; background: none; border: none; cursor: pointer; padding: 2px 6px; border-radius: 4px; transition: background 0.15s;"
                            onmouseover="this.style.background='#fef2f2'"
                            onmouseout="this.style.background='none'"
                            title="Hapus semua notifikasi">
                        Hapus Semua
                    </button>
                @endif
            </div>

            {{-- List Notifikasi --}}
            <div style="max-height: 340px; overflow-y: auto;">
                @forelse($notifications as $notif)
                    <div style="padding: 12px 16px; border-bottom: 1px solid #f8fafc; display: flex; align-items: flex-start; gap: 10px; transition: background 0.15s; position: relative; {{ !$notif['is_read'] ? 'background-color: #eff6ff;' : '' }}"
                         onmouseover="this.style.background='#f8fafc'"
                         onmouseout="this.style.background='{{ !$notif['is_read'] ? '#eff6ff' : 'transparent' }}'">

                        @if(!empty($notif['url']) && $notif['url'] !== '#')
                            <a href="{{ $notif['url'] }}" style="position: absolute; inset: 0; z-index: 25;"></a>
                        @endif

                        {{-- Icon Warna --}}
                        <div style="
                            width: 34px; height: 34px; border-radius: 10px; flex-shrink: 0;
                            display: flex; align-items: center; justify-content: center;
                            position: relative; z-index: 10; pointer-events: none;
                            {{ $notif['color'] === 'green' ? 'background-color: #ecfdf5; color: #10b981;' :
                               ($notif['color'] === 'red'   ? 'background-color: #fff1f2; color: #ef4444;' :
                               ($notif['color'] === 'yellow'? 'background-color: #fffbeb; color: #f59e0b;' :
                                                             'background-color: #eff6ff; color: #3b82f6;')) }}">
                            @if($notif['icon'] === 'check')
                                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            @elseif($notif['icon'] === 'document')
                                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            @elseif($notif['icon'] === 'x')
                                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                            @else
                                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            @endif
                        </div>

                        {{-- Teks Notifikasi --}}
                        <div style="flex: 1; min-width: 0; position: relative; z-index: 10; pointer-events: none;">
                            <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 6px;">
                                <p style="font-size: 12px; font-weight: 700; color: #1e293b; margin: 0; line-height: 1.3;">{{ $notif['title'] }}</p>
                            </div>
                            <p style="font-size: 11px; color: #64748b; margin: 2px 0 0 0; line-height: 1.4;">{{ $notif['message'] }}</p>
                            <p style="font-size: 10px; color: #94a3b8; margin: 4px 0 0 0; font-weight: 500;">
                                {{ \Carbon\Carbon::parse($notif['created_at'])->diffForHumans() }}
                            </p>
                        </div>

                        {{-- Tombol X hapus per notif --}}
                        <button wire:click.stop="hapusNotif({{ $notif['id'] }})"
                                style="flex-shrink: 0; color: #cbd5e1; background: none; border: none; cursor: pointer; padding: 2px; line-height: 1; transition: color 0.15s; position: relative; z-index: 30;"
                                onmouseover="this.style.color='#ef4444'"
                                onmouseout="this.style.color='#cbd5e1'"
                                title="Hapus">
                            <svg style="width: 13px; height: 13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                @empty
                    <div style="padding: 48px 16px; text-align: center; color: #94a3b8;">
                        <svg style="width: 36px; height: 36px; margin: 0 auto 10px; color: #e2e8f0; display: block;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <p style="font-size: 13px; font-weight: 600; margin: 0;">Tidak ada notifikasi</p>
                        <p style="font-size: 11px; color: #cbd5e1; margin: 4px 0 0 0;">Semua aktivitas sudah terpantau</p>
                    </div>
                @endforelse
            </div>

            {{-- Footer Dropdown --}}
            @if(count($notifications) > 0)
            <div style="padding: 10px 16px; background: rgba(248,250,252,0.8); border-top: 1px solid #f1f5f9; text-align: center;">
                <p style="font-size: 10px; color: #94a3b8; margin: 0; font-weight: 500;">
                    🔄 Auto-refresh setiap 15 detik
                </p>
            </div>
            @endif
        </div>

    </div>

    {{-- Overlay transparan untuk menutup dropdown saat klik di luar --}}
    <div wire:click="closeDropdown" style="position: fixed; inset: 0; z-index: 199;"></div>
    @endif

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Fungsi pembunyian suara notifikasi lembut (Web Audio API - Tanpa library)
        function playNotificationSound() {
            try {
                const AudioCtx = window.AudioContext || window.webkitAudioContext;
                if (!AudioCtx) return;
                const ctx = new AudioCtx();

                // Nada 1: 1318.51Hz (E6)
                const osc1 = ctx.createOscillator();
                const gain1 = ctx.createGain();
                osc1.type = 'sine';
                osc1.frequency.value = 1318.51;
                gain1.gain.setValueAtTime(0.15, ctx.currentTime);
                gain1.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.3);
                osc1.connect(gain1);
                gain1.connect(ctx.destination);
                osc1.start(ctx.currentTime);
                osc1.stop(ctx.currentTime + 0.3);

                // Nada 2: 1760Hz (A6 - Chime "Ting-Ting")
                const osc2 = ctx.createOscillator();
                const gain2 = ctx.createGain();
                osc2.type = 'sine';
                osc2.frequency.value = 1760;
                gain2.gain.setValueAtTime(0.2, ctx.currentTime + 0.12);
                gain2.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.5);
                osc2.connect(gain2);
                gain2.connect(ctx.destination);
                osc2.start(ctx.currentTime + 0.12);
                osc2.stop(ctx.currentTime + 0.5);
            } catch (e) {
                console.log('Web Audio Error:', e);
            }
        }

        window.addEventListener('new-notification-received', function () {
            // Bunyikan suara notifikasi real-time
            playNotificationSound();

            // Cek jika pengguna sedang aktif mengisi form/input
            const activeEl = document.activeElement;
            if (activeEl && (activeEl.tagName === 'INPUT' || activeEl.tagName === 'TEXTAREA' || activeEl.isContentEditable)) {
                return; 
            }

            // Pembaruan data halaman secara SENYAP (Tanpa refresh browser)
            const pageContent = document.getElementById('page-content');
            if (pageContent) {
                fetch(window.location.href, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newContent = doc.getElementById('page-content');
                    if (newContent && pageContent) {
                        pageContent.innerHTML = newContent.innerHTML;
                    }
                })
                .catch(err => console.log('Silent update error:', err));
            }
        });
    });
</script>
