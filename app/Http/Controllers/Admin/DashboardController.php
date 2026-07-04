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
            'total_penduduk'  => Penduduk::query()->count(),
            'berkas_masuk'    => PengajuanSurat::query()->whereIn('status', ['menunggu'])->count(),
            'perlu_tinjauan'  => PengajuanSurat::query()->where('status', 'menunggu')->count(),
            'selesai'         => PengajuanSurat::query()->where('status', 'selesai')->count(),
            'diproses'        => PengajuanSurat::query()->where('status', 'diproses')->count(),
        ];

        $penduduk_terbaru = Penduduk::query()->latest()->take(5)->get();

        $verifikasi_pending = PengajuanSurat::query()->where('status', 'menunggu')
            ->with(['penduduk', 'jenisSurat', 'user'])
            ->latest()
            ->take(5)
            ->get();

        $arsip_surat = PengajuanSurat::query()->where('status', 'selesai')
            ->whereDate('approved_at', today())
            ->with('jenisSurat')
            ->latest('approved_at')
            ->take(5)
            ->get();

        // Ringkasan kinerja bulan ini
        $bulan_ini = [
            'selesai' => PengajuanSurat::query()->where('status', 'selesai')
                ->whereMonth('approved_at', now()->month)
                ->whereYear('approved_at', now()->year)
                ->count(),
            'diproses' => PengajuanSurat::query()->whereIn('status', ['diproses', 'disetujui'])
                ->count(),
        ];

        $registrasi_baru = User::query()->where('role', 'warga')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats', 'penduduk_terbaru', 'verifikasi_pending', 'arsip_surat', 'bulan_ini', 'registrasi_baru'
        ));
    }

    /**
     * Update kata sandi Admin.
      */
    public function updatePassword(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|string|min:6|confirmed',
        ]);

        $user = \App\Models\User::find(auth()->id());

        if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Kata sandi saat ini salah!');
        }

        $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Kata sandi Admin berhasil diperbarui!');
    }
}
