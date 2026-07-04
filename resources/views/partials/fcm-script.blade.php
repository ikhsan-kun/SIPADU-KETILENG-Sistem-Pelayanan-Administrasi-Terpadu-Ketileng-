@auth
<script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-messaging-compat.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const firebaseConfig = {
            apiKey: "{{ env('FIREBASE_API_KEY', 'AIzaSyBCsySc3QWYbtxgoBj92bDlgAZo2LW3tW4') }}",
            authDomain: "{{ env('FIREBASE_AUTH_DOMAIN', 'sipadu-ketileng.firebaseapp.com') }}",
            projectId: "{{ env('FIREBASE_PROJECT_ID', 'sipadu-ketileng') }}",
            storageBucket: "{{ env('FIREBASE_STORAGE_BUCKET', 'sipadu-ketileng.firebasestorage.app') }}",
            messagingSenderId: "{{ env('FIREBASE_MESSAGING_SENDER_ID', '134729018039') }}",
            appId: "{{ env('FIREBASE_APP_ID', '1:134729018039:web:82aa58fae70584b199bb32') }}"
        };

        if (firebaseConfig.apiKey) {
            try {
                firebase.initializeApp(firebaseConfig);
                const messaging = firebase.messaging();

                // Minta izin Notifikasi dari Pengguna di Browser
                if (typeof Notification !== 'undefined') {
                    Notification.requestPermission().then((permission) => {
                        if (permission === 'granted') {
                            if ('serviceWorker' in navigator) {
                                navigator.serviceWorker.register('/firebase-messaging-sw.js')
                                    .then((registration) => {
                                        return messaging.getToken({
                                            serviceWorkerRegistration: registration,
                                            vapidKey: "{{ env('FIREBASE_VAPID_KEY', 'BDunN7aaIGFoH-OzEPfyzCng1ftVhJKInnTbV3BHeOpabVkLWdXVnjBx9-2pJz-y8ZCprGQr7ZfhkCB-U5_odvI') }}"
                                        });
                                    })
                                    .then((currentToken) => {
                                        if (currentToken) {
                                            console.log('FCM Token diperoleh:', currentToken);
                                            // Simpan Token ke Database Laravel via AJAX
                                            fetch("{{ route('save-fcm-token') }}", {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                                },
                                                body: JSON.stringify({ token: currentToken })
                                            })
                                            .then(res => res.json())
                                            .then(res => console.log('FCM Token tersimpan:', res))
                                            .catch(err => console.log('Simpan Token FCM Gagal:', err));
                                        } else {
                                            console.log('Tidak ada token FCM.');
                                        }
                                    }).catch((err) => console.log('Gagal mengambil FCM Token:', err));
                            }
                        }
                    });
                }

                // Tangkap notifikasi saat halaman sedang terbuka (Foreground)
                messaging.onMessage((payload) => {
                    console.log('Notifikasi FCM Diterima:', payload);
                    window.dispatchEvent(new CustomEvent('new-notification-received'));
                });
            } catch (e) {
                console.log('Firebase JS Init Error:', e);
            }
        }
    });
</script>
@endauth
