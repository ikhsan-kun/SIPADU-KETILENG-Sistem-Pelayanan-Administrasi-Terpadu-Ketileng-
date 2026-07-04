<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\PengajuanSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VerifikasiController extends Controller
{
    public function index(Request $request)
    {
        // Don't show 'selesai' here anymore since it has its own page
        $status   = $request->get('status', 'menunggu');
        $search   = $request->get('search', '');

        $pengajuan = PengajuanSurat::with(['penduduk', 'jenisSurat', 'user'])
            ->where('status', '!=', 'selesai') // Exclude selesai
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($search, function ($q) use ($search) {
                $q->where(function($q) use ($search) {
                    $q->whereHas('penduduk', fn($p) => $p->where('nama', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%"))
                      ->orWhereHas('jenisSurat', fn($j) => $j->where('nama', 'like', "%{$search}%"));
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.verifikasi.index', compact('pengajuan', 'status', 'search'));
    }

    public function arsip(Request $request)
    {
        $search = $request->get('search', '');
        $jenis  = $request->get('jenis', '');
        $bulan  = $request->get('bulan', '');
        $tahun  = $request->get('tahun', '');

        $query = PengajuanSurat::with(['penduduk', 'jenisSurat', 'user'])
            ->where('status', 'selesai');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('no_surat', 'like', "%{$search}%")
                  ->orWhereHas('penduduk', fn($p) => $p->where('nama', 'like', "%{$search}%")
                      ->orWhere('nik', 'like', "%{$search}%"))
                  ->orWhereHas('jenisSurat', fn($j) => $j->where('nama', 'like', "%{$search}%"));
            });
        }

        if ($jenis) {
            $query->where('jenis_surat_id', $jenis);
        }

        if ($bulan) {
            $query->whereMonth('approved_at', $bulan);
        }

        if ($tahun) {
            $query->whereYear('approved_at', $tahun);
        }

        $pengajuan = $query->latest('approved_at')->paginate(10)->withQueryString();
        
        $jenisSuratList = \App\Models\JenisSurat::where('aktif', true)->get();

        return view('admin.arsip', compact('pengajuan', 'search', 'jenis', 'bulan', 'tahun', 'jenisSuratList'));
    }

    public function show(PengajuanSurat $pengajuan)
    {
        $pengajuan->load('penduduk', 'jenisSurat', 'user', 'dokumen', 'verifiedBy', 'approvedBy');
        return view('admin.verifikasi.show', compact('pengajuan'));
    }

    public function proses(Request $request, PengajuanSurat $pengajuan)
    {
        $request->validate([
            'aksi'          => ['required', 'in:diproses,ditolak'],
            'catatan_admin' => ['nullable', 'string', 'max:500'],
        ]);

        $pengajuan->update([
            'status'        => $request->aksi,
            'catatan_admin' => $request->catatan_admin,
            'verified_by'   => Auth::id(),
            'verified_at'   => now(),
        ]);

        // Hapus notifikasi masuk untuk Admin terkait surat ini agar langsung hilang dari lonceng
        Notification::where('url', route('admin.verifikasi.show', $pengajuan))->delete();

        $pengajuan->load('penduduk', 'jenisSurat');

        if ($request->aksi === 'diproses') {
            // Notifikasi ke Kades: ada surat baru menunggu persetujuan TTE
            Notification::kirimKeRole(
                role: 'kades',
                title: 'Surat Siap Ditandatangani',
                message: $pengajuan->penduduk->nama . ' – ' . $pengajuan->jenisSurat->nama . ' telah diverifikasi Admin dan menunggu persetujuan Anda.',
                icon: 'document',
                color: 'yellow',
                url: route('kades.review', $pengajuan)
            );
            $pesan = 'Berkas berhasil diverifikasi dan diteruskan ke Kepala Desa.';
        } else {
            // Notifikasi ke Warga: berkas ditolak oleh Admin
            Notification::kirim(
                userId: $pengajuan->user_id,
                title: 'Pengajuan Surat Ditolak',
                message: $pengajuan->jenisSurat->nama . ' Anda ditolak oleh Admin Desa. Silakan hubungi kantor desa untuk informasi lebih lanjut.',
                icon: 'x',
                color: 'red'
            );
            $pesan = 'Berkas berhasil ditolak.';
        }

        return redirect()->route('admin.verifikasi.index')
            ->with('success', $pesan);
    }

    public function viewDokumen(PengajuanSurat $pengajuan, string $jenis)
    {
        $dokumen = $pengajuan->dokumen()->where('jenis_dokumen', strtoupper($jenis))->firstOrFail();
        $path    = storage_path('app/private/' . $dokumen->file_path);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->file($path, [
            'Content-Type' => $dokumen->mime_type,
        ]);
    }

    public function laporan(Request $request)
    {
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);

        $data = PengajuanSurat::with('jenisSurat', 'penduduk')
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->get();

        $rekap = [
            'total'     => $data->count(),
            'selesai'   => $data->where('status', 'selesai')->count(),
            'ditolak'   => $data->where('status', 'ditolak')->count(),
            'proses'    => $data->whereIn('status', ['menunggu', 'diproses', 'disetujui'])->count(),
        ];

        $bulanList = collect(range(1, 12))->mapWithKeys(fn($m) => [
            $m => \Carbon\Carbon::create()->month($m)->locale('id')->monthName
        ]);

        $tahunList = range(now()->year - 2, now()->year);

        return view('admin.laporan.index', compact('data', 'rekap', 'bulan', 'tahun', 'bulanList', 'tahunList'));
    }
    public function exportExcel(Request $request)
    {
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);

        $data = PengajuanSurat::with('jenisSurat', 'penduduk')
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->get();

        $bulanNama = \Carbon\Carbon::create()->month((int) $bulan)->locale('id')->monthName;
        $fileName = "Laporan_Surat_{$bulanNama}_{$tahun}.csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['No', 'No. Surat', 'Jenis Surat', 'Pemohon', 'NIK Pemohon', 'Tanggal Pengajuan', 'Status'];

        $callback = function() use($data, $columns) {
            $file = fopen('php://output', 'w');
            // Add BOM for Excel UTF-8 support
            fputs($file, "\xEF\xBB\xBF");
            fputcsv($file, $columns, ';'); // Use semicolon for better Excel compatibility in ID locale

            foreach ($data as $index => $row) {
                fputcsv($file, [
                    $index + 1,
                    $row->no_surat ?? '-',
                    $row->jenisSurat->nama,
                    $row->penduduk->nama,
                    "'" . $row->penduduk->nik, // Prefix with quote to prevent scientific notation in Excel
                    $row->created_at->format('d/m/Y H:i'),
                    ucfirst($row->status)
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
