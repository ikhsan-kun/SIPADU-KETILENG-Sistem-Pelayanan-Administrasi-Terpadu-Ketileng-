@extends('layouts.kades')
@section('title', 'Detail Surat - ' . $pengajuan->no_surat)

@section('content')
<div class="max-w-6xl mx-auto">
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-slate-400 mb-6">
        <a href="{{ route('kades.dashboard') }}" class="hover:text-slate-600 transition-colors">Dashboard</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('kades.surat-disetujui') }}" class="hover:text-slate-600 transition-colors">Surat Disetujui</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-700 font-medium">{{ $pengajuan->no_surat }}</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Kiri: Preview Dokumen --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Status Header --}}
            <div class="card bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold">Surat Telah Disetujui</h1>
                            <p class="text-blue-100 text-sm mt-0.5">Nomor: {{ $pengajuan->no_surat }}</p>
                        </div>
                    </div>
                    @if($pengajuan->surat_path)
                    <a href="{{ route('kades.download', $pengajuan) }}" target="_blank" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-blue-700 rounded-xl font-bold text-sm hover:bg-blue-50 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Download PDF
                    </a>
                    @endif
                </div>
            </div>

            {{-- Preview Surat --}}
            <div class="card p-0 overflow-hidden bg-slate-100 flex items-center justify-center min-h-[600px] border border-slate-200 relative">
                <div class="bg-white w-[90%] max-w-[600px] my-10 p-12 shadow-sm relative">
                    <div class="text-center border-b-2 border-black pb-4 mb-8">
                        <h1 class="text-sm font-bold uppercase">PEMERINTAH KABUPATEN TEGAL</h1>
                        <h2 class="text-sm font-bold uppercase">KECAMATAN KRAMAT</h2>
                        <h3 class="text-base font-bold uppercase">KANTOR KEPALA DESA KETILENG</h3>
                        <p class="text-xs font-semibold mt-1">Jl. Sandrageni No. 1 Ketileng Kramat Tegal Kode Pos 52181</p>
                    </div>
                    
                    <div class="text-center mb-8">
                        <h4 class="text-lg font-bold uppercase underline">{{ $pengajuan->jenisSurat->nama }}</h4>
                        <p class="text-sm">Nomor: {{ $pengajuan->no_surat }}</p>
                    </div>

                    <div class="text-sm leading-relaxed mb-6 space-y-2">
                        <p>Yang bertanda tangan di bawah ini Kepala Desa Ketileng, Kecamatan Kramat, Kabupaten Tegal menerangkan dengan sebenarnya bahwa:</p>
                        <table class="w-full ml-4">
                            <tr><td class="w-40 py-1">Nama Lengkap</td><td>: <strong>{{ $pengajuan->penduduk->nama }}</strong></td></tr>
                            <tr><td class="py-1">NIK / No. KK</td><td>: {{ $pengajuan->penduduk->nik }} / {{ $pengajuan->penduduk->no_kk }}</td></tr>
                            <tr><td class="py-1">Tempat, Tgl Lahir</td><td>: {{ $pengajuan->penduduk->tempat_lahir }}, {{ $pengajuan->penduduk->tanggal_lahir->format('d M Y') }}</td></tr>
                            <tr><td class="py-1">Pekerjaan</td><td>: {{ $pengajuan->penduduk->pekerjaan }}</td></tr>
                            <tr><td class="py-1 align-top">Alamat</td><td>: {{ $pengajuan->penduduk->alamat_lengkap }}</td></tr>
                        </table>
                        <p class="mt-4">Orang tersebut di atas benar-benar warga Desa Ketileng yang berdomisili di alamat tersebut. Surat ini dibuat untuk keperluan:</p>
                        <p class="font-semibold text-center italic my-4">"{{ $pengajuan->keperluan }}"</p>
                        <p>Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.</p>
                    </div>

                    <div class="flex justify-end mt-16">
                        <div class="text-center">
                            <p class="text-sm">Ketileng, {{ $pengajuan->approved_at ? $pengajuan->approved_at->locale('id')->isoFormat('D MMMM YYYY') : '-' }}</p>
                            <p class="text-sm font-bold mb-4">Kepala Desa Ketileng</p>
                            @if($pengajuan->qr_code_path)
                            <div class="w-24 h-24 mx-auto mb-2">
                                <img src="{{ asset('storage/' . $pengajuan->qr_code_path) }}" alt="QR Code" class="w-full h-full object-contain">
                            </div>
                            @else
                            <div class="w-24 h-24 border-2 border-dashed border-blue-300 mx-auto flex items-center justify-center text-blue-400 text-xs mb-2 rounded">
                                QR Code
                            </div>
                            @endif
                            <p class="text-sm font-bold underline">{{ $pengajuan->approvedBy->name ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        {{-- Kanan: Detail Info --}}
        <div class="space-y-6">
            {{-- Informasi Surat --}}
            <div class="card">
                <h3 class="text-sm font-bold text-slate-800 mb-4 uppercase tracking-wider flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Informasi Surat
                </h3>
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/></svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-medium">Nomor Surat</p>
                            <p class="font-bold text-slate-900 font-mono text-sm">{{ $pengajuan->no_surat }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-medium">Jenis Surat</p>
                            <p class="font-semibold text-slate-900 text-sm">{{ $pengajuan->jenisSurat->nama }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-medium">Tanggal Pengajuan</p>
                            <p class="font-semibold text-slate-900 text-sm">{{ $pengajuan->created_at->locale('id')->isoFormat('D MMMM YYYY, HH:mm') }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-medium">Tanggal Disetujui</p>
                            <p class="font-bold text-blue-600 text-sm">{{ $pengajuan->approved_at ? $pengajuan->approved_at->locale('id')->isoFormat('D MMMM YYYY, HH:mm') : '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Data Pemohon --}}
            <div class="card">
                <h3 class="text-sm font-bold text-slate-800 mb-4 uppercase tracking-wider flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Data Pemohon
                </h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <p class="text-slate-400 text-xs">Nama Lengkap</p>
                        <p class="font-semibold text-slate-900">{{ $pengajuan->penduduk->nama }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-xs">NIK</p>
                        <p class="font-medium text-slate-900 font-mono">{{ $pengajuan->penduduk->nik }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-xs">No. KK</p>
                        <p class="font-medium text-slate-900 font-mono">{{ $pengajuan->penduduk->no_kk }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-xs">Tempat, Tanggal Lahir</p>
                        <p class="font-medium text-slate-900">{{ $pengajuan->penduduk->tempat_lahir }}, {{ $pengajuan->penduduk->tanggal_lahir->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-xs">Pekerjaan</p>
                        <p class="font-medium text-slate-900">{{ $pengajuan->penduduk->pekerjaan }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-xs">Alamat</p>
                        <p class="font-medium text-slate-900">{{ $pengajuan->penduduk->alamat_lengkap }}</p>
                    </div>
                </div>
            </div>

            {{-- Jejak Persetujuan --}}
            <div class="card">
                <h3 class="text-sm font-bold text-slate-800 mb-4 uppercase tracking-wider flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Jejak Persetujuan
                </h3>
                <div class="space-y-4 relative">
                    <div class="absolute left-[15px] top-6 bottom-4 w-0.5 bg-slate-200"></div>
                    
                    {{-- Step 1: Pengajuan --}}
                    <div class="flex items-start gap-3 relative">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0 z-10">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-900 text-sm">Pengajuan Dibuat</p>
                            <p class="text-xs text-slate-500">{{ $pengajuan->created_at->locale('id')->isoFormat('D MMM YYYY, HH:mm') }}</p>
                            <p class="text-xs text-slate-400">Oleh: {{ $pengajuan->user->name ?? '-' }}</p>
                        </div>
                    </div>

                    {{-- Step 2: Verifikasi Admin --}}
                    <div class="flex items-start gap-3 relative">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0 z-10">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-900 text-sm">Diverifikasi Admin</p>
                            <p class="text-xs text-slate-500">{{ $pengajuan->verified_at ? $pengajuan->verified_at->locale('id')->isoFormat('D MMM YYYY, HH:mm') : '-' }}</p>
                            <p class="text-xs text-slate-400">Oleh: {{ $pengajuan->verifiedBy->name ?? '-' }}</p>
                            @if($pengajuan->catatan_admin)
                            <div class="mt-1.5 bg-blue-50 px-2.5 py-1.5 rounded-md border border-blue-100">
                                <p class="text-xs text-blue-800">{{ $pengajuan->catatan_admin }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Step 3: Disetujui Kades --}}
                    <div class="flex items-start gap-3 relative">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0 z-10">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-blue-600 text-sm">Disetujui & Ditandatangani</p>
                            <p class="text-xs text-slate-500">{{ $pengajuan->approved_at ? $pengajuan->approved_at->locale('id')->isoFormat('D MMM YYYY, HH:mm') : '-' }}</p>
                            <p class="text-xs text-slate-400">Oleh: {{ $pengajuan->approvedBy->name ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kode Verifikasi --}}
            @if($pengajuan->kode_verifikasi)
            <div class="card bg-slate-900 text-white">
                <h3 class="text-sm font-bold mb-3 uppercase tracking-wider flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    Kode Verifikasi
                </h3>
                <div class="bg-slate-800 rounded-lg px-4 py-3 text-center">
                    <p class="text-lg font-mono font-bold text-blue-400 tracking-widest">{{ $pengajuan->kode_verifikasi }}</p>
                </div>
                <a href="{{ route('verifikasi.publik', $pengajuan->kode_verifikasi) }}" target="_blank" class="mt-3 inline-flex items-center gap-1.5 text-xs text-slate-400 hover:text-white transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Buka Halaman Verifikasi Publik
                </a>
            </div>
            @endif

            {{-- Tombol Kembali --}}
            <a href="{{ route('kades.surat-disetujui') }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 border border-slate-200 text-slate-700 rounded-xl font-semibold text-sm hover:bg-slate-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar
            </a>
        </div>
    </div>
</div>
@endsection
