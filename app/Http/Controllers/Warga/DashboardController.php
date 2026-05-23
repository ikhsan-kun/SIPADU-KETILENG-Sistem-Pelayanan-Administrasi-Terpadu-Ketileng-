<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\JenisSurat;
use App\Models\PengajuanSurat;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user        = Auth::user();
        $jenisSurat  = JenisSurat::aktif()->get();
        $pengajuan   = PengajuanSurat::where('user_id', $user->id)
                        ->with('jenisSurat')
                        ->latest()
                        ->take(5)
                        ->get();

        $stats = [
            'total'     => PengajuanSurat::where('user_id', $user->id)->count(),
            'selesai'   => PengajuanSurat::where('user_id', $user->id)->where('status', 'selesai')->count(),
            'proses'    => PengajuanSurat::where('user_id', $user->id)->whereIn('status', ['menunggu', 'diproses', 'disetujui'])->count(),
            'ditolak'   => PengajuanSurat::where('user_id', $user->id)->where('status', 'ditolak')->count(),
        ];

        return view('warga.dashboard', compact('user', 'jenisSurat', 'pengajuan', 'stats'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('warga.profile', compact('user'));
    }

    public function pilihSurat()
    {
        $user = Auth::user();
        $jenisSurat = JenisSurat::aktif()->get();
        return view('warga.pilih_surat', compact('user', 'jenisSurat'));
    }
}
