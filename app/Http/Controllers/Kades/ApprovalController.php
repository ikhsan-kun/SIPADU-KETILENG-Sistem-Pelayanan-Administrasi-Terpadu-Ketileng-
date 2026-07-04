<?php

namespace App\Http\Controllers\Kades;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\PengajuanSurat;
use App\Services\SuratService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{
    public function __construct(protected SuratService $suratService) {}

    public function show(PengajuanSurat $pengajuan)
    {
        if ($pengajuan->status !== 'diproses') {
            return back()->with('error', 'Surat tidak dalam status siap disetujui.');
        }
        $pengajuan->load('penduduk', 'jenisSurat', 'user', 'dokumen', 'verifiedBy');
        return view('kades.review', compact('pengajuan'));
    }

    public function approve(Request $request, PengajuanSurat $pengajuan)
    {
        if ($pengajuan->status !== 'diproses') {
            return back()->with('error', 'Surat tidak dalam status siap disetujui.');
        }

        $pengajuan->load('penduduk', 'jenisSurat');

        // Generate nomor surat
        $noSurat = PengajuanSurat::generateNomorSurat($pengajuan->jenisSurat->kode);

        // Update status dulu
        $pengajuan->update([
            'no_surat'    => $noSurat,
            'status'      => 'selesai',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        // Hapus notifikasi masuk untuk Kades terkait surat ini agar langsung hilang dari lonceng
        Notification::where('url', route('kades.review', $pengajuan))->delete();

        // Generate QR Code + PDF
        $this->suratService->generateSurat($pengajuan);

        // Notifikasi ke Warga: surat sudah selesai & bisa diunduh
        Notification::kirim(
            userId: $pengajuan->user_id,
            title: 'Surat Anda Telah Disetujui! 🎉',
            message: $pengajuan->jenisSurat->nama . ' No. ' . $noSurat . ' telah ditandatangani Kepala Desa dan siap untuk diunduh.',
            icon: 'check',
            color: 'green',
            url: route('warga.detail', $pengajuan)
        );

        return redirect()->route('kades.dashboard')
            ->with('success', "Surat #{$noSurat} berhasil disetujui dan QR Code telah disematkan.");
    }

    public function tolak(Request $request, PengajuanSurat $pengajuan)
    {
        $request->validate([
            'catatan_kades' => ['required', 'string', 'max:500'],
        ], [
            'catatan_kades.required' => 'Alasan penolakan wajib diisi.',
        ]);

        $pengajuan->update([
            'status'        => 'ditolak',
            'catatan_kades' => $request->catatan_kades,
            'approved_by'   => Auth::id(),
            'approved_at'   => now(),
        ]);

        // Hapus notifikasi masuk untuk Kades terkait surat ini agar langsung hilang dari lonceng
        Notification::where('url', route('kades.review', $pengajuan))->delete();

        // Notifikasi ke Warga: surat ditolak Kades
        Notification::kirim(
            userId: $pengajuan->user_id,
            title: 'Pengajuan Surat Ditolak Kades',
            message: $pengajuan->jenisSurat->nama . ' Anda ditolak oleh Kepala Desa. Alasan: ' . $request->catatan_kades,
            icon: 'x',
            color: 'red'
        );

        return redirect()->route('kades.dashboard')
            ->with('success', 'Surat berhasil ditolak.');
    }

    /**
     * Download surat yang sudah disetujui (untuk Kades).
     */
    public function downloadSurat(PengajuanSurat $pengajuan)
    {
        if ($pengajuan->status !== 'selesai') {
            return back()->with('error', 'Surat belum selesai diproses.');
        }

        if (empty($pengajuan->surat_path)) {
            return back()->with('error', 'File surat belum diterbitkan.');
        }

        $path = storage_path('app/private/' . $pengajuan->surat_path);
        if (!file_exists($path) || is_dir($path)) {
            return back()->with('error', 'File surat tidak ditemukan.');
        }

        $safeFileName = 'Surat_' . str_replace(['/', '\\'], '_', $pengajuan->no_surat) . '.pdf';
        return response()->download($path, $safeFileName);
    }
}
