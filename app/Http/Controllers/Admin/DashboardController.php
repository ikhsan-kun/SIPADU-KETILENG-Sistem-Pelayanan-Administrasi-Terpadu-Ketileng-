<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use App\Models\PengajuanSurat;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_penduduk'  => Penduduk::count(),
            'berkas_masuk'    => PengajuanSurat::whereIn('status', ['menunggu'])->count(),
            'perlu_tinjauan'  => PengajuanSurat::where('status', 'menunggu')->count(),
            'selesai'         => PengajuanSurat::where('status', 'selesai')->count(),
            'diproses'        => PengajuanSurat::where('status', 'diproses')->count(),
        ];

        $penduduk_terbaru = Penduduk::latest()->take(5)->get();

        $verifikasi_pending = PengajuanSurat::where('status', 'menunggu')
            ->with(['penduduk', 'jenisSurat', 'user'])
            ->latest()
            ->take(5)
            ->get();

        $arsip_surat = PengajuanSurat::where('status', 'selesai')
            ->whereDate('approved_at', today())
            ->with('jenisSurat')
            ->latest('approved_at')
            ->take(5)
            ->get();

        // Ringkasan kinerja bulan ini
        $bulan_ini = [
            'selesai' => PengajuanSurat::where('status', 'selesai')
                ->whereMonth('approved_at', now()->month)
                ->whereYear('approved_at', now()->year)
                ->count(),
            'diproses' => PengajuanSurat::whereIn('status', ['diproses', 'disetujui'])
                ->count(),
        ];

        return view('admin.dashboard', compact(
            'stats', 'penduduk_terbaru', 'verifikasi_pending', 'arsip_surat', 'bulan_ini'
        ));
    }
}
