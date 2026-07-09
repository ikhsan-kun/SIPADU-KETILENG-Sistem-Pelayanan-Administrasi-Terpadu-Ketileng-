importScripts('https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/9.23.0/firebase-messaging-compat.js');

// ── Konfigurasi Firebase (dibaca dari query string saat registrasi) ───────────
const params = new URLSearchParams(self.location.search);
const firebaseConfig = {
    apiKey:            params.get('apiKey')            || '',
    authDomain:        params.get('authDomain')        || '',
    projectId:         params.get('projectId')         || '',
    storageBucket:     params.get('storageBucket')     || '',
    messagingSenderId: params.get('messagingSenderId') || '',
    appId:             params.get('appId')             || ''
};

if (firebaseConfig.apiKey) {
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();

    // ── Background Message Handler ─────────────────────────────────────────────
    // JANGAN panggil showNotification() secara manual di sini.
    // Sejak payload backend sudah HANYA menggunakan webpush.notification
    // (top-level 'notification' sudah dihapus dari FcmService.php),
    // FCM SDK akan menampilkan notifikasi satu kali secara otomatis.
    messaging.onBackgroundMessage(function(payload) {
        console.log('[SW] Background message:', payload.notification?.title);
        // Tidak memanggil showNotification() — FCM SDK yang handle otomatis
    });
}

// ── Klik notifikasi → buka/fokus tab ─────────────────────────────────────────
self.addEventListener('notificationclick', function(event) {
    event.notification.close();

    let targetUrl = '/';
    if (event.notification.data) {
        targetUrl = event.notification.data.url ||
                    event.notification.data.FCM_MSG?.data?.url ||
                    targetUrl;
    }

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then(function(windowClients) {
            for (const client of windowClients) {
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
