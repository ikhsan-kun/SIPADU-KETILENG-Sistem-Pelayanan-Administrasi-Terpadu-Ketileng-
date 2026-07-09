<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Services\FcmService;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'icon',
        'color',
        'url',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ── HELPER: kirim notifikasi ke user tertentu ──────────────────────────────
    public static function kirim(int $userId, string $title, string $message, string $icon = 'bell', string $color = 'blue', ?string $url = null): static
    {
        // ── Guard duplikasi: jika notifikasi persis sama sudah ada dalam 60 detik terakhir, skip ──
        $query = static::where('user_id', $userId)
            ->where('title', $title)
            ->where('created_at', '>=', now()->subSeconds(60)->toDateTimeString());

        if (is_null($url)) {
            $query->whereNull('url');
        } else {
            $query->where('url', $url);
        }

        $sudahAda = $query->exists();

        if ($sudahAda) {
            $fallbackQuery = static::where('user_id', $userId)->where('title', $title);
            if (is_null($url)) {
                $fallbackQuery->whereNull('url');
            } else {
                $fallbackQuery->where('url', $url);
            }
            return $fallbackQuery->latest()->first();
        }

        $notif = static::create([
            'user_id' => $userId,
            'title'   => $title,
            'message' => $message,
            'icon'    => $icon,
            'color'   => $color,
            'url'     => $url,
        ]);

        // Kirim Push Notification via FCM jika user memiliki token FCM
        $user = User::find($userId);
        if ($user && $user->fcm_token) {
            FcmService::sendPush($user->fcm_token, $title, $message, $url);
        }

        return $notif;
    }

    // ── HELPER: kirim notifikasi ke semua user dengan role tertentu ───────────
    public static function kirimKeRole(string $role, string $title, string $message, string $icon = 'bell', string $color = 'blue', ?string $url = null): void
    {
        $users = User::where('role', $role)->get();
        foreach ($users as $user) {
            static::kirim($user->id, $title, $message, $icon, $color, $url);
        }
    }
}
