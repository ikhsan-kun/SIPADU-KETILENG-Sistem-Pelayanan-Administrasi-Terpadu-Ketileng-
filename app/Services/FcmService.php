<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FcmService
{
    /**
     * Kirim push notification ke satu token FCM
     */
    public static function sendPush(?string $token, string $title, string $body, ?string $url = null): bool
    {
        if (empty($token)) {
            return false;
        }

        $serverKey = env('FCM_SERVER_KEY') ?: env('FIREBASE_VAPID_KEY');

        if (empty($serverKey)) {
            Log::info("FCM push skipped: Neither FCM_SERVER_KEY nor FIREBASE_VAPID_KEY is configured in .env");
            return false;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'key=' . $serverKey,
                'Content-Type'  => 'application/json',
            ])->post('https://fcm.googleapis.com/fcm/send', [
                'to' => $token,
                'notification' => [
                    'title' => $title,
                    'body'  => $body,
                    'icon'  => asset('images/logo.png'),
                    'sound' => 'default',
                ],
                'data' => [
                    'url' => $url ?? url('/'),
                ],
                'priority' => 'high',
            ]);

            if (!$response->successful()) {
                Log::error("FCM API Failed: Status " . $response->status() . " | Body: " . $response->body());
            } else {
                Log::info("FCM API Success: " . $response->body());
            }

            return $response->successful();
        } catch (\Exception $e) {
            Log::error("FCM Push Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Kirim push notification ke beberapa token FCM (Array)
     */
    public static function sendPushMultiple(array $tokens, string $title, string $body, ?string $url = null): void
    {
        $tokens = array_filter($tokens);
        foreach ($tokens as $token) {
            static::sendPush($token, $title, $body, $url);
        }
    }
}
