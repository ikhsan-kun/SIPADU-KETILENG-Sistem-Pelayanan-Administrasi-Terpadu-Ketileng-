<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\DokumenPersyaratan;
use App\Models\JenisSurat;
use App\Models\Notification;
use App\Models\Penduduk;
use App\Models\PengajuanSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PengajuanController extends Controller
{
    public function index()
    {
        $pengajuan = PengajuanSurat::where('user_id', Auth::id())
                        ->with('jenisSurat')
                        ->latest()
                        ->paginate(10);

        return view('warga.status', compact('pengajuan'));
    }

    public function create(JenisSurat $jenisSurat)
    {
        $user      = Auth::user();
        $penduduk  = Penduduk::where('nik', $user->nik)->first();

        return view('warga.ajukan', compact('jenisSurat', 'user', 'penduduk'));
    }

    public function store(Request $request)
    {
        $jenisSurat = JenisSurat::findOrFail($request->jenis_surat_id);

        $request->validate([
            'jenis_surat_id' => ['required', 'exists:jenis_surat,id'],
            'keperluan'      => ['required', 'string', 'max:500'],
            'file_ktp'       => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'file_kk'        => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ], [
            'keperluan.required'  => 'Keperluan pengajuan wajib diisi.',
            'file_ktp.required'   => 'File KTP wajib diunggah.',
            'file_kk.required'    => 'File KK wajib diunggah.',
            'file_ktp.mimes'      => 'Format file KTP harus JPG, PNG, atau PDF.',
            'file_kk.mimes'       => 'Format file KK harus JPG, PNG, atau PDF.',
            'file_ktp.max'        => 'Ukuran file KTP maksimal 2 MB.',
            'file_kk.max'         => 'Ukuran file KK maksimal 2 MB.',
        ]);

        $user     = Auth::user();
        $penduduk = Penduduk::where('nik', $user->nik)->firstOrFail();

        $pengajuan = PengajuanSurat::create([
            'user_id'        => $user->id,
            'penduduk_id'    => $penduduk->id,
            'jenis_surat_id' => $jenisSurat->id,
            'keperluan'      => $request->keperluan,
            'status'         => 'menunggu',
        ]);

        // Upload dokumen
        foreach (['ktp' => 'file_ktp', 'kk' => 'file_kk'] as $jenis => $input) {
            if ($request->hasFile($input)) {
                $file     = $request->file($input);
                $filename = $jenis . '_' . $pengajuan->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path     = $file->storeAs("dokumen/{$pengajuan->id}", $filename, 'local');

                DokumenPersyaratan::create([
                    'pengajuan_id'  => $pengajuan->id,
                    'jenis_dokumen' => strtoupper($jenis),
                    'nama_file'     => $file->getClientOriginalName(),
                    'file_path'     => $path,
                    'file_size'     => $file->getSize(),
                    'mime_type'     => $file->getMimeType(),
                ]);
            }
        }

        // Kirim notifikasi ke semua Admin
        Notification::kirimKeRole(
            role: 'admin',
            title: 'Pengajuan Surat Baru Masuk',
            message: $penduduk->nama . ' mengajukan ' . $jenisSurat->nama . '. Segera lakukan verifikasi berkas.',
            icon: 'document',
            color: 'blue',
            url: route('admin.verifikasi.show', $pengajuan)
        );

        return redirect()->route('warga.status')->with('success', 'Pengajuan surat berhasil dikirim! Silakan tunggu verifikasi dari perangkat desa.');
    }

    public function show(PengajuanSurat $pengajuan)
    {
        if ($pengajuan->user_id !== Auth::id()) {
            abort(403);
        }
        $pengajuan->load('jenisSurat', 'penduduk', 'dokumen', 'verifiedBy', 'approvedBy');
        return view('warga.detail', compact('pengajuan'));
    }

    public function download(PengajuanSurat $pengajuan)
    {
        if ($pengajuan->user_id !== Auth::id() || $pengajuan->status !== 'selesai') {
            abort(403);
        }

        if (empty($pengajuan->surat_path)) {
            return back()->with('error', 'File surat belum diterbitkan (atau terjadi kegagalan saat pembuatan).');
        }

        $path = storage_path('app/private/' . $pengajuan->surat_path);
        if (!file_exists($path) || is_dir($path)) {
            return back()->with('error', 'File surat tidak ditemukan.');
        }

        $safeFileName = 'Surat_' . str_replace(['/', '\\'], '_', $pengajuan->no_surat) . '.pdf';
        return response()->download($path, $safeFileName);
    }
}
