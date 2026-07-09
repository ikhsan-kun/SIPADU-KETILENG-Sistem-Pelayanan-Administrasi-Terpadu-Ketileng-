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
                apiKey: "{{ env('FIREBASE_API_KEY') }}",
                authDomain: "{{ env('FIREBASE_AUTH_DOMAIN') }}",
                projectId: "{{ env('FIREBASE_PROJECT_ID') }}",
                storageBucket: "{{ env('FIREBASE_STORAGE_BUCKET') }}",
                messagingSenderId: "{{ env('FIREBASE_MESSAGING_SENDER_ID') }}",
                appId: "{{ env('FIREBASE_APP_ID') }}"
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

                        // ── KUNCI UTAMA: Gunakan URL SW yang STATIS tanpa query string ──
                        // Parameter konfigurasi dikirim via postMessage SETELAH SW aktif,
                        // bukan via query string. Ini memastikan browser hanya punya SATU
                        // instance SW aktif, tidak membuat duplikasi saat URL berbeda.
                        navigator.serviceWorker.register('/firebase-messaging-sw.js', {
                            updateViaCache: 'none' // Selalu ambil SW terbaru dari server
                        })
                        .then((registration) => {
                            // Kirim konfigurasi ke SW via postMessage setelah aktif
                            const sendConfig = () => {
                                if (registration.active) {
                                    registration.active.postMessage({
                                        type: 'FIREBASE_CONFIG',
                                        config: firebaseConfig
                                    });
                                }
                            };

                            if (registration.active) {
                                sendConfig();
                            } else {
                                // SW baru saja dipasang, tunggu sampai aktif
                                const sw = registration.installing || registration.waiting;
                                if (sw) {
                                    sw.addEventListener('statechange', () => {
                                        if (sw.state === 'activated') sendConfig();
                                    });
                                }
                            }

                            return messaging.getToken({
                                serviceWorkerRegistration: registration,
                                vapidKey: "{{ env('FIREBASE_VAPID_KEY') }}"
                            });
                        })
                        .then((currentToken) => {
                            if (!currentToken) {
                                console.log('[FCM] Tidak ada token FCM diperoleh.');
                                return;
                            }

                            // ── Guard: Jangan simpan token jika sudah sama dengan sebelumnya ──
                            const savedToken = sessionStorage.getItem('fcm_token_saved');
                            if (savedToken === currentToken) {
                                console.log('[FCM] Token sama, tidak perlu disimpan ulang.');
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
                                    sessionStorage.setItem('fcm_token_saved', currentToken);
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
