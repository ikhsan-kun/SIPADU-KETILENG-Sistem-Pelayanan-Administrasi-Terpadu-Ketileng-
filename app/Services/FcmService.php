<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FcmService
{
    /**
     * Kirim push notification ke satu token FCM (Mendukung FCM HTTP v1 dan Legacy API)
     */
    public static function sendPush(?string $token, string $title, string $body, ?string $url = null): bool
    {
        if (empty($token)) {
            return false;
        }

        // 1. Cek Service Account untuk FCM HTTP v1 API (Metode Terbaru & Resmi)
        $serviceAccountPath = storage_path('app/firebase-service-account.json');
        if (file_exists($serviceAccountPath)) {
            $json = json_decode(file_get_contents($serviceAccountPath), true);
            if (!empty($json['client_email']) && !empty($json['private_key']) && !empty($json['project_id'])) {
                return static::sendPushV1($token, $title, $body, $url, $json['project_id'], $json['client_email'], $json['private_key']);
            }
        }

        // Cek credential dari config untuk HTTP v1 API
        if (config('services.firebase.client_email') && config('services.firebase.private_key')) {
            $projectId = config('services.firebase.project_id', 'sipadu-ketileng');
            $privateKey = str_replace('\n', "\n", config('services.firebase.private_key'));
            return static::sendPushV1($token, $title, $body, $url, $projectId, config('services.firebase.client_email'), $privateKey);
        }

        // 2. Fallback ke Legacy Server Key
        $serverKey = config('services.firebase.server_key');
        if (!empty($serverKey) && $serverKey !== config('services.firebase.vapid_key')) {
            return static::sendPushLegacy($token, $title, $body, $url, $serverKey);
        }

        Log::warning("FCM Push skipped: Belum mengunduh Service Account JSON ke storage/app/firebase-service-account.json");
        return false;
    }

    /**
     * FCM HTTP v1 API (Standar Resmi Google Terbaru)
     */
    private static function sendPushV1(string $token, string $title, string $body, ?string $url, string $projectId, string $clientEmail, string $privateKey): bool
    {
        $accessToken = static::getAccessToken($clientEmail, $privateKey);
        if (!$accessToken) {
            return false;
        }

        try {
            $endpoint = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";
            $response = Http::timeout(5)->withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type'  => 'application/json',
            ])->post($endpoint, [
                'message' => [
                    'token' => $token,
                    // PENTING: Hapus top-level 'notification' — gunakan HANYA webpush.notification
                    // Memiliki keduanya menyebabkan browser menampilkan dua notifikasi sekaligus.
                    'webpush' => [
                        'notification' => [
                            'title' => $title,
                            'body'  => $body,
                            'icon'  => url('/download.png'),
                            'badge' => url('/download.png'),
                            'tag'   => 'sipadu-' . md5($title . $body), // Tag unik cegah notif duplikat
                            'requireInteraction' => false,
                        ],
                        'fcm_options' => [
                            'link' => $url ?? url('/'),
                        ],
                    ],
                    'data' => [
                        'url' => $url ?? url('/'),
                    ],
                ],
            ]);

            if ($response->successful()) {
                Log::info("FCM HTTP v1 Success: " . $response->body());
                return true;
            }

            Log::error("FCM HTTP v1 Failed: Status " . $response->status() . " | Body: " . $response->body());
            return false;
        } catch (\Exception $e) {
            Log::error("FCM HTTP v1 Exception: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Legacy FCM HTTP API (Fallback)
     */
    private static function sendPushLegacy(string $token, string $title, string $body, ?string $url, string $serverKey): bool
    {
        try {
            $response = Http::timeout(5)->withHeaders([
                'Authorization' => 'key=' . $serverKey,
                'Content-Type'  => 'application/json',
            ])->post('https://fcm.googleapis.com/fcm/send', [
                'to'           => $token,
                'notification' => [
                    'title' => $title,
                    'body'  => $body,
                    'icon'  => url('/download.png'),
                    'sound' => 'default',
                ],
                'data' => [
                    'url' => $url ?? url('/'),
                ],
                'priority'     => 'high',
            ]);

            if ($response->successful()) {
                Log::info("FCM Legacy Success: " . $response->body());
                return true;
            }

            Log::error("FCM Legacy Failed: Status " . $response->status() . " | Body: " . $response->body());
            return false;
        } catch (\Exception $e) {
            Log::error("FCM Legacy Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Generate OAuth2 Access Token untuk FCM HTTP v1 API tanpa library luar
     */
    private static function getAccessToken(string $clientEmail, string $privateKey): ?string
    {
        try {
            $now = time();
            $header = base64_encode(json_encode(['alg' => 'RS256', 'typ' => 'JWT']));
            $payload = base64_encode(json_encode([
                'iss'   => $clientEmail,
                'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
                'aud'   => 'https://oauth2.googleapis.com/token',
                'exp'   => $now + 3600,
                'iat'   => $now,
            ]));

            $headerUrl  = str_replace(['+', '/', '='], ['-', '_', ''], $header);
            $payloadUrl = str_replace(['+', '/', '='], ['-', '_', ''], $payload);
            $toSign     = $headerUrl . '.' . $payloadUrl;

            $signature = '';
            if (!openssl_sign($toSign, $signature, $privateKey, 'SHA256')) {
                Log::error("FCM OAuth2: OpenSSL sign failed");
                return null;
            }
            $signatureUrl = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
            $jwt = $toSign . '.' . $signatureUrl;

            $response = Http::asForm()->timeout(5)->post('https://oauth2.googleapis.com/token', [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion'  => $jwt,
            ]);

            if ($response->successful()) {
                return $response->json('access_token');
            }

            Log::error("FCM OAuth2 Token Request Failed: " . $response->body());
            return null;
        } catch (\Exception $e) {
            Log::error("FCM OAuth2 Exception: " . $e->getMessage());
            return null;
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
