importScripts('https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/9.23.0/firebase-messaging-compat.js');

firebase.initializeApp({
    apiKey: "AIzaSyBCsySc3QWYbtxgoBj92bDlgAZo2LW3tW4",
    authDomain: "sipadu-ketileng.firebaseapp.com",
    projectId: "sipadu-ketileng",
    storageBucket: "sipadu-ketileng.firebasestorage.app",
    messagingSenderId: "134729018039",
    appId: "1:134729018039:web:82aa58fae70584b199bb32"
});

const messaging = firebase.messaging();

// ── Helper: cek apakah ada tab SIPADU yang sedang aktif (foreground) ──────────
async function isAppFocused() {
    const allClients = await self.clients.matchAll({ type: 'window', includeUncontrolled: true });
    return allClients.some(client => client.focused === true || client.visibilityState === 'visible');
}

// ── Background Message Handler (tab tertutup / di background) ────────────────
// Firebase SDK sudah otomatis TIDAK memanggil onBackgroundMessage jika tab aktif (foreground).
// Ini mencegah duplikasi dengan onMessage() di fcm-script.blade.php.
messaging.onBackgroundMessage(async function (payload) {
    // Jika tab masih terbuka & aktif, biarkan onMessage() di halaman yang menangani
    const focused = await isAppFocused();
    if (focused) return;

    const notificationTitle = payload.notification?.title ?? 'SIPADU Ketileng';
    const notificationBody  = payload.notification?.body  ?? 'Ada pemberitahuan baru.';
    const notificationIcon  = payload.notification?.icon  ?? '/download.png';
    const targetUrl         = payload.data?.url           ?? '/';

    return self.registration.showNotification(notificationTitle, {
        body:    notificationBody,
        icon:    notificationIcon,
        badge:   '/download.png',
        tag:     'sipadu-notif-' + targetUrl, // tag unik per URL — cegah notif duplikat di HP
        renotify: false,                      // jika tag sama, tidak pergetar HP lagi
        data:    { url: targetUrl }
    });
});

// ── Push Event Handler (fallback jika onBackgroundMessage tidak terpicu) ──────
self.addEventListener('push', function (event) {
    // Lewati jika tidak ada data
    if (!event.data) return;

    let title = 'SIPADU Ketileng';
    let body  = 'Ada pemberitahuan baru.';
    let icon  = '/download.png';
    let url   = '/';

    try {
        const payload = event.data.json();
        title = payload.notification?.title ?? title;
        body  = payload.notification?.body  ?? body;
        icon  = payload.notification?.icon  ?? icon;
        url   = payload.data?.url           ?? url;
    } catch (e) {
        // Plain text fallback
        try { body = event.data.text(); } catch (_) {}
    }

    event.waitUntil(
        // Cek dulu apakah tab aktif — jika ya, jangan tampilkan notifikasi sistem
        self.clients.matchAll({ type: 'window', includeUncontrolled: true }).then(function (windowClients) {
            const appFocused = windowClients.some(c => c.visibilityState === 'visible');
            if (appFocused) return; // Tab aktif: biarkan onMessage() di halaman yang handle

            return self.registration.showNotification(title, {
                body:     body,
                icon:     icon,
                badge:    '/download.png',
                tag:      'sipadu-notif-' + url, // tag unik per URL
                renotify: false,
                data:     { url: url }
            });
        })
    );
});

// ── Klik notifikasi → buka/fokus tab yang sesuai ─────────────────────────────
self.addEventListener('notificationclick', function (event) {
    event.notification.close();
    const targetUrl = event.notification.data?.url ?? '/';

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
