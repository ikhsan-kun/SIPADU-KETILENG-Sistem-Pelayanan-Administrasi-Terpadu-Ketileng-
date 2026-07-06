importScripts('https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/9.23.0/firebase-messaging-compat.js');

// ── Ambil konfigurasi Firebase dinamis dari query string registrasi ──────────
const params = new URLSearchParams(self.location.search);
const firebaseConfig = {
    apiKey: params.get('apiKey') || "",
    authDomain: params.get('authDomain') || "",
    projectId: params.get('projectId') || "",
    storageBucket: params.get('storageBucket') || "",
    messagingSenderId: params.get('messagingSenderId') || "",
    appId: params.get('appId') || ""
};

let messaging;

// Hanya inisialisasi jika apiKey ada (menghindari error jika diakses langsung tanpa parameter)
if (firebaseConfig.apiKey) {
    firebase.initializeApp(firebaseConfig);
    messaging = firebase.messaging();
}

// ── Helper: cek apakah ada tab SIPADU yang sedang aktif (foreground) ──────────
async function isAppFocused() {
    const allClients = await self.clients.matchAll({ type: 'window', includeUncontrolled: true });
    return allClients.some(client => client.focused === true || client.visibilityState === 'visible');
}

// ── Background Message Handler (tab tertutup / di background) ────────────────
if (messaging) {
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
            tag:     'sipadu-notif-' + targetUrl, // tag unik per URL
            renotify: false,
            data:    { url: targetUrl }
        });
    });
}

// ── Push Event Handler (fallback jika onBackgroundMessage tidak terpicu) ──────
self.addEventListener('push', function (event) {
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
        try { body = event.data.text(); } catch (_) {}
    }

    event.waitUntil(
        self.clients.matchAll({ type: 'window', includeUncontrolled: true }).then(function (windowClients) {
            const appFocused = windowClients.some(c => c.visibilityState === 'visible');
            if (appFocused) return;

            return self.registration.showNotification(title, {
                body:     body,
                icon:     icon,
                badge:    '/download.png',
                tag:      'sipadu-notif-' + url,
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
