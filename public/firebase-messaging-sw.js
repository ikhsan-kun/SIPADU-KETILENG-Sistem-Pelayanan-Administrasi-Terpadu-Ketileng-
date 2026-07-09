importScripts('https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/9.23.0/firebase-messaging-compat.js');

// ── State konfigurasi dari postMessage ───────────────────────────────────────
let firebaseConfig = null;
let messaging = null;

// ── Terima konfigurasi Firebase dari halaman utama via postMessage ────────────
// Ini menggantikan metode query string yang menyebabkan browser mendaftarkan
// banyak Service Worker berbeda karena URL yang berubah-ubah setiap sesi.
self.addEventListener('message', function (event) {
    if (!event.data || event.data.type !== 'FIREBASE_CONFIG') return;
    if (firebaseConfig) return; // Sudah diinisialisasi sebelumnya, skip

    firebaseConfig = event.data.config;

    if (!firebaseConfig.apiKey) return;

    try {
        // Inisialisasi Firebase di dalam SW hanya sekali setelah menerima konfigurasi
        firebase.initializeApp(firebaseConfig);
        messaging = firebase.messaging();

        // ── Background Message Handler ────────────────────────────────────────
        // PENTING: HANYA log saja di sini — JANGAN panggil showNotification() secara manual!
        // FCM SDK secara otomatis menampilkan notifikasi dari payload 'notification' ke layar.
        // Memanggil showNotification() di sini AKAN menyebabkan notifikasi ganda.
        messaging.onBackgroundMessage(function (payload) {
            console.log('[SW] Menerima pesan background:', payload.notification?.title);
            // Tidak ada showNotification() di sini — biarkan FCM SDK yang handle
        });

        console.log('[SW] Firebase Messaging berhasil diinisialisasi via postMessage.');
    } catch (e) {
        console.log('[SW] Firebase init error:', e.message);
    }
});

// ── Klik notifikasi → buka/fokus tab yang sesuai ─────────────────────────────
self.addEventListener('notificationclick', function (event) {
    event.notification.close();

    // Temukan target URL dari data notifikasi (kompatibel FCM v1 dan Legacy)
    let targetUrl = '/';
    if (event.notification.data) {
        targetUrl = event.notification.data.url ||
                    event.notification.data.FCM_MSG?.data?.url ||
                    targetUrl;
    }

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then(function (windowClients) {
            for (let i = 0; i < windowClients.length; i++) {
                const client = windowClients[i];
                if (client.url.includes(targetUrl) && 'focus' in client) {
                    return client.focus();
                }
            }
            if (clients.openWindow) {
                return clients.openWindow(targetUrl);
            }
        })
    );
});
