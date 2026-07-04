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
        $this->notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->take(10)
            ->get()
            ->toArray();

        $this->unreadCount = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();
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
        $oldNotifications = json_encode($this->notifications);

        $this->loadNotifications();

        // Jika data notifikasi berubah (ada yang baru atau terhapus), kirim sinyal ke frontend
        if (json_encode($this->notifications) !== $oldNotifications) {
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
