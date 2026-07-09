@auth
<script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-messaging-compat.js"></script>
<script>
    // ── Guard: Pastikan script FCM hanya diinisialisasi SEKALI per sesi browser ──
    // window.fcmInitialized mencegah Livewire re-render atau navigasi halaman
    // yang memicu firebase.initializeApp() lebih dari satu kali (penyebab utama notif ganda)
    if (window.fcmInitialized) {
        console.log('[FCM] Sudah terinisialisasi sebelumnya, skip.');
    } else {
        window.fcmInitialized = true;

        document.addEventListener('DOMContentLoaded', function () {
            const firebaseConfig = {
                apiKey: "{{ config('services.firebase.api_key') }}",
                authDomain: "{{ config('services.firebase.auth_domain') }}",
                projectId: "{{ config('services.firebase.project_id') }}",
                storageBucket: "{{ config('services.firebase.storage_bucket') }}",
                messagingSenderId: "{{ config('services.firebase.messaging_sender_id') }}",
                appId: "{{ config('services.firebase.app_id') }}"
            };

            if (!firebaseConfig.apiKey) {
                console.log('[FCM] Firebase API Key tidak ditemukan, skip inisialisasi.');
                return;
            }

            try {
                // ── Guard: Jangan panggil initializeApp jika sudah ada instance aktif ──
                const firebaseApp = firebase.apps.length
                    ? firebase.app()
                    : firebase.initializeApp(firebaseConfig);

                const messaging = firebase.messaging(firebaseApp);

                // Minta izin Notifikasi dari Pengguna di Browser
                if (typeof Notification !== 'undefined') {
                    Notification.requestPermission().then((permission) => {
                        if (permission !== 'granted') {
                            console.log('[FCM] Izin notifikasi ditolak.');
                            return;
                        }

                        if (!('serviceWorker' in navigator)) return;

                        // Kirimkan parameter konfigurasi ke Service Worker secara dinamis via query string
                        const swUrl = '/firebase-messaging-sw.js?' + new URLSearchParams(firebaseConfig).toString();
                        navigator.serviceWorker.register(swUrl)
                        .then((registration) => {
                            return messaging.getToken({
                                serviceWorkerRegistration: registration,
                                vapidKey: "{{ config('services.firebase.vapid_key') }}"
                            });
                        })
                        .then((currentToken) => {
                            if (!currentToken) {
                                console.log('[FCM] Tidak ada token FCM diperoleh.');
                                return;
                            }

                            // ── Guard: Jangan simpan token jika sudah sama dengan sebelumnya untuk user ini ──
                            const userId = "{{ auth()->id() }}";
                            const savedToken = sessionStorage.getItem('fcm_token_saved_' + userId);
                            if (savedToken === currentToken) {
                                console.log('[FCM] Token sama untuk user ini, tidak perlu disimpan ulang.');
                                return;
                            }

                            console.log('[FCM] Token baru diperoleh, menyimpan ke server...');
                            fetch("{{ route('save-fcm-token') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                },
                                body: JSON.stringify({ token: currentToken })
                            })
                            .then(res => res.json())
                            .then(res => {
                                if (res.success) {
                                    sessionStorage.setItem('fcm_token_saved_' + userId, currentToken);
                                    console.log('[FCM] Token berhasil disimpan.');
                                }
                            })
                            .catch(err => console.log('[FCM] Gagal simpan token:', err));
                        })
                        .catch((err) => console.log('[FCM] Gagal mengambil token FCM:', err));
                    });
                }

                // ── Tangkap notifikasi saat halaman sedang TERBUKA (Foreground) ──────────
                // Jika tab aktif: HANYA update badge lonceng & bunyikan suara.
                // TIDAK memanggil showNotification() di sini — itu tugas SW saat background.
                messaging.onMessage((payload) => {
                    console.log('[FCM] Pesan foreground diterima (tab aktif):', payload);
                    window.dispatchEvent(new CustomEvent('new-notification-received'));
                });

            } catch (e) {
                console.log('[FCM] Firebase Init Error:', e);
            }
        });
    }
</script>
@endauth
