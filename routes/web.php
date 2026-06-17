<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Warga\DashboardController as WargaDashboard;
use App\Http\Controllers\Warga\PengajuanController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\PendudukController;
use App\Http\Controllers\Admin\VerifikasiController;
use App\Http\Controllers\Kades\DashboardController as KadesDashboard;
use App\Http\Controllers\Kades\ApprovalController;
use App\Http\Controllers\VerifikasiPublikController;
use Illuminate\Support\Facades\Route;

// ── HALAMAN UTAMA ──────────────────────────────────────────────────────────
try {
    \App\Models\User::where('role', 'kades')->where('name', '!=', 'MASRUDIYANTO AM.d')->update(['name' => 'MASRUDIYANTO AM.d']);
    
    // Update existing DOMISILI code to SKD
    \App\Models\JenisSurat::where('kode', 'DOMISILI')->update(['kode' => 'SKD']);
    
    // Update existing HAJATAN code to IKH
    \App\Models\JenisSurat::where('kode', 'HAJATAN')->update([
        'kode' => 'IKH',
        'nama' => 'Surat Izin Khajatan',
        'deskripsi' => 'Surat keterangan izin untuk menyelenggarakan acara/khajatan warga.',
    ]);
    
    \App\Models\JenisSurat::firstOrCreate(
        ['kode' => 'IKH'],
        [
            'nama'        => 'Surat Izin Khajatan',
            'deskripsi'   => 'Surat keterangan izin untuk menyelenggarakan acara/khajatan warga.',
            'persyaratan' => ['ktp', 'kk'],
            'aktif'       => true,
        ]
    );

    \App\Models\JenisSurat::firstOrCreate(
        ['kode' => 'KEMATIAN'],
        [
            'nama'        => 'Surat Keterangan Kematian',
            'deskripsi'   => 'Surat keterangan untuk pelaporan kematian warga.',
            'persyaratan' => ['ktp', 'kk'],
            'aktif'       => true,
        ]
    );

    \App\Models\JenisSurat::firstOrCreate(
        ['kode' => 'KELAHIRAN'],
        [
            'nama'        => 'Surat Keterangan Kelahiran',
            'deskripsi'   => 'Surat keterangan untuk pelaporan kelahiran anak.',
            'persyaratan' => ['ktp', 'kk'],
            'aktif'       => true,
        ]
    );

    \App\Models\JenisSurat::firstOrCreate(
        ['kode' => 'PINDAH'],
        [
            'nama'        => 'Surat Keterangan Pindah',
            'deskripsi'   => 'Surat keterangan pengantar pindah domisili penduduk.',
            'persyaratan' => ['ktp', 'kk'],
            'aktif'       => true,
        ]
    );

    \App\Models\JenisSurat::firstOrCreate(
        ['kode' => 'BEDA_NAMA'],
        [
            'nama'        => 'Surat Keterangan Beda Nama',
            'deskripsi'   => 'Surat pernyataan menerangkan nama berbeda dari orang yang sama.',
            'persyaratan' => ['ktp', 'kk'],
            'aktif'       => true,
        ]
    );

    \App\Models\JenisSurat::firstOrCreate(
        ['kode' => 'BELUM_NIKAH'],
        [
            'nama'        => 'Surat Keterangan Belum Menikah',
            'deskripsi'   => 'Surat keterangan menyatakan belum pernah menikah.',
            'persyaratan' => ['ktp', 'kk'],
            'aktif'       => true,
        ]
    );
} catch (\Exception $e) {}

try {
    $src = 'C:\\Users\\SMK BINA NUSA SLAWI\\.gemini\\antigravity\\brain\\02cbfe48-9004-41c7-b7e1-1286f1a7a2c6\\bg_desa_1779555514825.png';
    $destDir = public_path('images');
    if (!file_exists($destDir)) {
        mkdir($destDir, 0755, true);
    }
    if (file_exists($src) && !file_exists(public_path('images/bg_desa.png'))) {
        copy($src, public_path('images/bg_desa.png'));
    }
} catch (\Exception $e) {}

Route::get('/', fn() => redirect()->route('login'));

// ── VERIFIKASI PUBLIK (tanpa login) ────────────────────────────────────────
Route::get('/verifikasi/{kode}', [VerifikasiPublikController::class, 'show'])
    ->name('verifikasi.publik');

// ── AUTH ───────────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    // throttle:5,1 → Maksimal 5 percobaan login per 1 menit per IP (anti brute force)
    Route::post('/login', [LoginController::class, 'login'])->name('login.post')->middleware('throttle:5,1');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
    
    // Reset Password Mandiri
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('password.request');
    // throttle:5,1 → Maksimal 5 percobaan verifikasi NIK+KK per 1 menit per IP
    Route::post('/forgot-password', [ForgotPasswordController::class, 'verifyNikKk'])->name('password.verify')->middleware('throttle:5,1');
    Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ── WARGA ──────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:warga'])->prefix('warga')->name('warga.')->group(function () {
    Route::get('/dashboard', [WargaDashboard::class, 'index'])->name('dashboard');
    Route::get('/profile', [WargaDashboard::class, 'profile'])->name('profile');

    Route::get('/status', [PengajuanController::class, 'index'])->name('status');
    Route::get('/pilih-surat', [WargaDashboard::class, 'pilihSurat'])->name('pilih_surat');
    Route::get('/ajukan/{jenisSurat}', [PengajuanController::class, 'create'])->name('ajukan');
    Route::post('/ajukan', [PengajuanController::class, 'store'])->name('ajukan.store');
    Route::get('/pengajuan/{pengajuan}', [PengajuanController::class, 'show'])->name('detail');
    Route::get('/pengajuan/{pengajuan}/download', [PengajuanController::class, 'download'])->name('download');
});

// ── ADMIN ──────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::post('/update-password', [AdminDashboard::class, 'updatePassword'])->name('update-password');

    // CRUD Penduduk
    Route::resource('penduduk', PendudukController::class)->except(['show']);
    Route::post('/penduduk/import', [PendudukController::class, 'import'])->name('penduduk.import');
    Route::get('/penduduk/template/download', [PendudukController::class, 'downloadTemplate'])->name('penduduk.template');

    // Verifikasi berkas
    Route::get('/verifikasi', [VerifikasiController::class, 'index'])->name('verifikasi.index');
    Route::get('/verifikasi/{pengajuan}', [VerifikasiController::class, 'show'])->name('verifikasi.show');
    Route::post('/verifikasi/{pengajuan}/proses', [VerifikasiController::class, 'proses'])->name('verifikasi.proses');
    Route::get('/verifikasi/{pengajuan}/dokumen/{jenis}', [VerifikasiController::class, 'viewDokumen'])->name('verifikasi.dokumen');

    // Arsip
    Route::get('/arsip', [VerifikasiController::class, 'arsip'])->name('arsip');

    // Laporan
    Route::get('/laporan', [VerifikasiController::class, 'laporan'])->name('laporan');
    Route::get('/laporan/excel', [VerifikasiController::class, 'exportExcel'])->name('laporan.excel');
});

// ── KEPALA DESA ─────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:kades'])->prefix('kades')->name('kades.')->group(function () {
    Route::get('/dashboard', [KadesDashboard::class, 'index'])->name('dashboard');
    Route::get('/surat-disetujui', [KadesDashboard::class, 'suratDisetujui'])->name('surat-disetujui');
    Route::get('/surat-disetujui/{pengajuan}', [KadesDashboard::class, 'detailSurat'])->name('detail-surat');
    Route::get('/review/{pengajuan}', [ApprovalController::class, 'show'])->name('review');
    Route::post('/approve/{pengajuan}', [ApprovalController::class, 'approve'])->name('approve');
    Route::post('/tolak/{pengajuan}', [ApprovalController::class, 'tolak'])->name('tolak');
    Route::get('/download/{pengajuan}', [ApprovalController::class, 'downloadSurat'])->name('download');
    
    // Profil Kades
    Route::get('/profile', [KadesDashboard::class, 'profile'])->name('profile');
    Route::post('/profile/update', [KadesDashboard::class, 'updateProfile'])->name('profile.update');
});

// Route sementara untuk membersihkan data testing
// ⚠️ DINONAKTIFKAN - Aktifkan kembali hanya jika perlu reset data testing
// Route::get('/clear-test-data', function () {
//     try {
//         \App\Models\PengajuanSurat::query()->delete();
//         return response('Semua data surat pengujian dan dokumen persyaratannya berhasil dibersihkan! Silakan kembali dan lakukan testing dari nomor 001.');
//     } catch (\Exception $e) {
//         return response('Gagal menghapus data: ' . $e->getMessage(), 500);
//     }
// });

