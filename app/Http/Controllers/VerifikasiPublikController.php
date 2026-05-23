<?php

namespace App\Http\Controllers;

use App\Models\PengajuanSurat;

class VerifikasiPublikController extends Controller
{
    public function show(string $kode)
    {
        $pengajuan = PengajuanSurat::where('kode_verifikasi', $kode)
            ->with(['penduduk', 'jenisSurat', 'approvedBy'])
            ->firstOrFail();

        return view('verifikasi.publik', compact('pengajuan'));
    }
}
