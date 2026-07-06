<?php

namespace App\Livewire;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;

class NotificationBell extends Component
{
    public int $unreadCount = 0;
    public $notifications = [];
    public bool $isOpen = false;

    public function mount(): void
    {
        $this->loadNotifications();
    }

    public function loadNotifications(): void
    {
        $user = Auth::user();
        if ($user) {
            // Pembersihan otomatis: hapus notifikasi Kades untuk surat yang sudah selesai / ditolak
            if ($user->isKades()) {
                $kadesNotifs = Notification::where('user_id', $user->id)
                    ->where('title', 'like', '%Surat Siap Ditandatangani%')
                    ->get();

                foreach ($kadesNotifs as $notif) {
                    if ($notif->url) {
                        $parts = explode('/', rtrim($notif->url, '/'));
                        $pengajuanId = end($parts);
                        if (is_numeric($pengajuanId)) {
                            $pengajuan = \App\Models\PengajuanSurat::find($pengajuanId);
                            if (!$pengajuan || $pengajuan->status !== 'diproses') {
                                $notif->delete();
                            }
                        }
                    }
                }
            }

            // Pembersihan otomatis: hapus notifikasi Admin untuk surat yang sudah tidak berstatus 'menunggu'
            if ($user->isAdmin()) {
                $adminNotifs = Notification::where('user_id', $user->id)
                    ->where('title', 'like', '%Pengajuan Surat Baru%')
                    ->get();

                foreach ($adminNotifs as $notif) {
                    if ($notif->url) {
                        $parts = explode('/', rtrim($notif->url, '/'));
                        $pengajuanId = end($parts);
                        if (is_numeric($pengajuanId)) {
                            $pengajuan = \App\Models\PengajuanSurat::find($pengajuanId);
                            if (!$pengajuan || $pengajuan->status !== 'menunggu') {
                                $notif->delete();
                            }
                        }
                    }
                }
            }

            $this->notifications = Notification::where('user_id', $user->id)
                ->latest()
                ->take(10)
                ->get()
                ->toArray();

            $this->unreadCount = Notification::where('user_id', $user->id)
                ->where('is_read', false)
                ->count();
        }
    }

    public function toggleDropdown(): void
    {
        $this->isOpen = !$this->isOpen;

        // Tandai semua sebagai dibaca saat dropdown dibuka
        if ($this->isOpen) {
            Notification::where('user_id', Auth::id())
                ->where('is_read', false)
                ->update(['is_read' => true]);

            $this->unreadCount = 0;
            $this->loadNotifications();
        }
    }

    public function closeDropdown(): void
    {
        $this->isOpen = false;
    }

    // Auto-refresh setiap 15 detik via Livewire polling
    public function refreshNotifications(): void
    {
        $oldUnread = $this->unreadCount;

        $this->loadNotifications();

        // Hanya kirim sinyal jika ada notifikasi baru yang BELUM DIBACA bertambah
        if ($this->unreadCount > $oldUnread) {
            $this->dispatch('new-notification-received');
        }
    }

    public function hapusNotif(int $id): void
    {
        Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        $this->loadNotifications();
    }

    public function hapusSemua(): void
    {
        Notification::where('user_id', Auth::id())->delete();
        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.notification-bell');
    }
}
