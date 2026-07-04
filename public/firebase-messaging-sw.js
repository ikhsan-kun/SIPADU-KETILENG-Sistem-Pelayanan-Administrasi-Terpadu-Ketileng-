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

messaging.onBackgroundMessage(function (payload) {
    const notificationTitle = payload.notification ? payload.notification.title : 'SIPADU Ketileng';
    const notificationOptions = {
        body: payload.notification ? payload.notification.body : 'Ada pemberitahuan baru.',
        icon: payload.notification && payload.notification.icon ? payload.notification.icon : '/download.png',
        data: {
            url: payload.data && payload.data.url ? payload.data.url : '/'
        }
    };

    return self.registration.showNotification(notificationTitle, notificationOptions);
});

self.addEventListener('push', function (event) {
    if (event.data) {
        let notificationTitle = 'SIPADU Ketileng';
        let notificationOptions = {
            body: 'Ada pemberitahuan baru.',
            icon: '/download.png',
            data: { url: '/' }
        };

        try {
            const payload = event.data.json();
            if (payload.notification) {
                notificationTitle = payload.notification.title || notificationTitle;
                notificationOptions.body = payload.notification.body || notificationOptions.body;
                if (payload.notification.icon) {
                    notificationOptions.icon = payload.notification.icon;
                }
            }
            if (payload.data && payload.data.url) {
                notificationOptions.data.url = payload.data.url;
            }
        } catch(jsonErr) {
            // Jika data pengujian berbentuk Plain Text (bukan JSON)
            try {
                notificationOptions.body = event.data.text();
            } catch(e) {}
        }

        event.waitUntil(
            self.registration.showNotification(notificationTitle, notificationOptions)
        );
    }
});

self.addEventListener('notificationclick', function (event) {
    event.notification.close();
    const targetUrl = event.notification.data ? event.notification.data.url : '/';
    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then(function (windowClients) {
            for (let i = 0; i < windowClients.length; i++) {
                const client = windowClients[i];
                if (client.url === targetUrl && 'focus' in client) {
                    return client.focus();
                }
            }
            if (clients.openWindow) {
                return clients.openWindow(targetUrl);
            }
        })
    );
});
