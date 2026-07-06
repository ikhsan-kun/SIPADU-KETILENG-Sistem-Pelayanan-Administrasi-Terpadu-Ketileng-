@auth
<script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-messaging-compat.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const firebaseConfig = {
            apiKey: "{{ env('FIREBASE_API_KEY') }}",
            authDomain: "{{ env('FIREBASE_AUTH_DOMAIN') }}",
            projectId: "{{ env('FIREBASE_PROJECT_ID') }}",
            storageBucket: "{{ env('FIREBASE_STORAGE_BUCKET') }}",
            messagingSenderId: "{{ env('FIREBASE_MESSAGING_SENDER_ID') }}",
            appId: "{{ env('FIREBASE_APP_ID') }}"
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
                                // Kirimkan parameter konfigurasi ke Service Worker secara dinamis via query string
                                // Hal ini untuk menghindari hardcoding API Key di file firebase-messaging-sw.js
                                const swUrl = '/firebase-messaging-sw.js?' + new URLSearchParams(firebaseConfig).toString();
                                navigator.serviceWorker.register(swUrl)
                                    .then((registration) => {
                                        return messaging.getToken({
                                            serviceWorkerRegistration: registration,
                                            vapidKey: "{{ env('FIREBASE_VAPID_KEY') }}"
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

                // ── Tangkap notifikasi saat halaman sedang TERBUKA (Foreground) ──────────
                // Jika tab aktif: HANYA update badge lonceng Livewire & bunyikan suara.
                // Jangan tampilkan popup notifikasi sistem — itu tugas Service Worker saat background.
                messaging.onMessage((payload) => {
                    console.log('FCM Foreground diterima (tab aktif):', payload);
                    // Cukup kirim sinyal ke Livewire bell agar badge diperbarui & berbunyi
                    window.dispatchEvent(new CustomEvent('new-notification-received'));
                    // TIDAK memanggil showNotification() di sini — mencegah duplikasi dengan SW
                });
            } catch (e) {
                console.log('Firebase JS Init Error:', e);
            }
        }
    });
</script>
@endauth
