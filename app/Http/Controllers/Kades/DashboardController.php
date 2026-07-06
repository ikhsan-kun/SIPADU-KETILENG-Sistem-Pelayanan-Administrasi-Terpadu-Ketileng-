<?php

namespace App\Http\Controllers\Kades;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSurat;
use App\Services\SuratService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $stats = [
            'menunggu'    => PengajuanSurat::where('status', 'diproses')->count(),
            'disetujui'   => PengajuanSurat::where('status', 'selesai')
                                ->whereDate('approved_at', today())->count(),
            'total_bulan' => PengajuanSurat::whereMonth('created_at', now()->month)
                                ->whereYear('created_at', now()->year)->count(),
        ];

        $antrean = PengajuanSurat::where('status', 'diproses')
            ->with(['penduduk', 'jenisSurat', 'user'])
            ->latest('verified_at')
            ->paginate(10);

        // Chart 1: Tren Pengajuan Bulanan (Tahun Berjalan)
        $submissionsThisYear = PengajuanSurat::whereYear('created_at', now()->year)->get();
        $monthlyChartData = array_fill(0, 12, 0);
        foreach ($submissionsThisYear as $p) {
            if ($p->created_at) {
                $monthIndex = $p->created_at->month - 1;
                $monthlyChartData[$monthIndex]++;
            }
        }

        // Chart 2: Jenis Surat Terpopuler (Top 5)
        $popularLetters = PengajuanSurat::with('jenisSurat')
            ->get()
            ->groupBy(function($item) {
                return $item->jenisSurat ? $item->jenisSurat->nama : 'Lainnya';
            })
            ->map(function($group) {
                return $group->count();
            })
            ->sortByDesc(function($count) {
                return $count;
            })
            ->take(5);

        $popularChartLabels = $popularLetters->keys()->all();
        $popularChartSeries = $popularLetters->values()->all();

        // Fallback jika belum ada data agar ApexCharts tidak blank
        if (empty($popularChartSeries)) {
            $popularChartLabels = ['Belum Ada Data'];
            $popularChartSeries = [1];
        }

        // Jika request via AJAX, kirim data mentah agar grafik terupdate smooth tanpa reload
        if ($request->ajax()) {
            return response()->json([
                'stats' => $stats,
                'monthlyChartData' => $monthlyChartData,
                'popularChartLabels' => $popularChartLabels,
                'popularChartSeries' => $popularChartSeries,
            ]);
        }

        return view('kades.dashboard', compact(
            'stats', 
            'antrean', 
            'monthlyChartData', 
            'popularChartLabels', 
            'popularChartSeries'
        ));
    }

    /**
     * Tampilkan daftar surat yang sudah disetujui/selesai.
     */
    public function suratDisetujui(Request $request)
    {
        $query = PengajuanSurat::where('status', 'selesai')
            ->with(['penduduk', 'jenisSurat', 'approvedBy']);

        // Search by name, NIK, or no_surat
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('no_surat', 'like', "%{$search}%")
                  ->orWhereHas('penduduk', function ($q2) use ($search) {
                      $q2->where('nama', 'like', "%{$search}%")
                         ->orWhere('nik', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by jenis_surat
        if ($jenis = $request->input('jenis')) {
            $query->where('jenis_surat_id', $jenis);
        }

        // Filter by month
        if ($bulan = $request->input('bulan')) {
            $query->whereMonth('approved_at', $bulan);
        }

        // Filter by year
        if ($tahun = $request->input('tahun')) {
            $query->whereYear('approved_at', $tahun);
        }

        $suratSelesai = $query->latest('approved_at')->paginate(10)->withQueryString();

        $jenisSuratList = \App\Models\JenisSurat::where('aktif', true)->get();

        // Stats
        $totalDisetujui   = PengajuanSurat::where('status', 'selesai')->count();
        $disetujuiBulanIni = PengajuanSurat::where('status', 'selesai')
            ->whereMonth('approved_at', now()->month)
            ->whereYear('approved_at', now()->year)
            ->count();

        return view('kades.surat-disetujui', compact(
            'suratSelesai', 'jenisSuratList', 'totalDisetujui', 'disetujuiBulanIni'
        ));
    }

    /**
     * Tampilkan detail surat yang sudah disetujui.
     */
    public function detailSurat(PengajuanSurat $pengajuan)
    {
        if ($pengajuan->status !== 'selesai') {
            return back()->with('error', 'Surat belum selesai diproses.');
        }

        $pengajuan->load('penduduk', 'jenisSurat', 'user', 'dokumen', 'verifiedBy', 'approvedBy');

        return view('kades.detail-surat', compact('pengajuan'));
    }

    /**
     * Tampilkan halaman profil Kepala Desa.
     */
    public function profile()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Rekap statistics Kades
        $stats = [
            'total_approved' => PengajuanSurat::where('status', 'selesai')->where('approved_by', $user->id)->count(),
            'pending_queue'  => PengajuanSurat::where('status', 'diproses')->count(),
        ];

        return view('kades.profile', compact('user', 'stats'));
    }

    /**
     * Update profil Kepala Desa.
     */
    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|max:15',
            'address'  => 'nullable|string|max:255',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;

        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profil Kepala Desa berhasil diperbarui!');
    }
}
