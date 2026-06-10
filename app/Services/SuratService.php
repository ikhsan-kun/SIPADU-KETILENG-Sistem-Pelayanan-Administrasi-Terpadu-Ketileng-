<?php

namespace App\Services;

use App\Models\PengajuanSurat;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SuratService
{
    public function generateSurat(PengajuanSurat $pengajuan): void
    {
        // 1. Buat kode verifikasi unik
        $kodeVerifikasi = Str::upper(Str::random(12));
        $pengajuan->update(['kode_verifikasi' => $kodeVerifikasi]);

        // 2. Generate QR Code sebagai SVG / PNG (base64)
        $urlVerifikasi = url("/verifikasi/{$kodeVerifikasi}");
        $qrCodeSvg     = QrCode::format('svg')->size(150)->generate($urlVerifikasi);
        $qrBase64      = 'data:image/svg+xml;base64,' . base64_encode($qrCodeSvg);

        // 3. Tentukan template berdasarkan kode jenis surat
        $kode     = $pengajuan->jenisSurat->kode;
        $template = match($kode) {
            'SKTM'        => 'surat.sktm',
            'SKCK'        => 'surat.skck',
            'SKU'         => 'surat.sku',
            'SKD'         => 'surat.domisili',
            'IKH'         => 'surat.hajatan',
            'KEMATIAN'    => 'surat.kematian',
            'KELAHIRAN'   => 'surat.kelahiran',
            'PINDAH'      => 'surat.pindah',
            'BEDA_NAMA'   => 'surat.beda_nama',
            'BELUM_NIKAH' => 'surat.belum_nikah',
            default       => 'surat.domisili',
        };

        // 4. Generate PDF
        $pdf = Pdf::loadView($template, [
            'pengajuan'    => $pengajuan,
            'penduduk'     => $pengajuan->penduduk,
            'qrBase64'     => $qrBase64,
            'urlVerifikasi'=> $urlVerifikasi,
            'tanggalSurat' => now()->locale('id')->isoFormat('D MMMM YYYY'),
        ])->setPaper('a4', 'portrait');

        // 5. Simpan PDF ke private storage
        $filename  = 'surat_' . Str::slug($pengajuan->no_surat) . '.pdf';
        $path      = "surat/{$pengajuan->id}/{$filename}";
        Storage::disk('local')->put($path, $pdf->output());

        // 6. Update path di database
        $pengajuan->update(['surat_path' => $path]);
    }
}
