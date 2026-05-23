@extends('layouts.kades')
@section('title', 'Tinjau Dokumen')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex items-center gap-2 text-sm text-slate-400 mb-6">
        <a href="{{ route('kades.dashboard') }}" class="hover:text-slate-600">Dashboard</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-700 font-medium">Tinjau Dokumen</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Kiri: Preview Dokumen --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="card p-0 overflow-hidden bg-slate-100 flex items-center justify-center min-h-[600px] border border-slate-200 relative">
                {{-- Mockup Preview Surat --}}
                <div class="bg-white w-[90%] max-w-[600px] my-10 p-12 shadow-sm relative">
                    <div class="text-center border-b-2 border-black pb-4 mb-8">
                        <h1 class="text-lg font-bold uppercase">Pemerintah Kabupaten Tegal</h1>
                        <h2 class="text-lg font-bold uppercase">Kecamatan Kramat</h2>
                        <h3 class="text-xl font-bold uppercase">Desa Ketileng</h3>
                        <p class="text-sm">Jl. Raya Ketileng, Kec. Kramat, Kab. Tegal</p>
                    </div>
                    
                    <div class="text-center mb-8">
                        <h4 class="text-lg font-bold uppercase underline">{{ $pengajuan->jenisSurat->nama }}</h4>
                        <p class="text-sm">Nomor: .../{{ $pengajuan->jenisSurat->kode }}/.../...</p>
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
                            <p class="text-sm">Ketileng, {{ now()->locale('id')->isoFormat('D MMMM YYYY') }}</p>
                            <p class="text-sm font-bold mb-16">Kepala Desa Ketileng</p>
                            <div class="w-24 h-24 border-2 border-dashed border-slate-300 mx-auto flex items-center justify-center text-slate-400 text-xs">
                                Area QR Code
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Dokumen Lampiran --}}
            <div class="card">
                <h2 class="text-base font-bold text-slate-800 mb-4">Lampiran (Verifikasi Admin)</h2>
                <div class="flex flex-wrap gap-3">
                    @foreach($pengajuan->dokumen as $dok)
                        <a href="{{ route('admin.verifikasi.dokumen', [$pengajuan, strtolower($dok->jenis_dokumen)]) }}" target="_blank" class="flex items-center gap-2 px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg hover:border-blue-400 hover:text-blue-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                            <span class="text-sm font-medium">{{ $dok->jenis_dokumen }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Kanan: Aksi --}}
        <div class="space-y-6">
            <div class="card bg-slate-900 text-white">
                <h2 class="text-lg font-bold mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    Aksi Persetujuan
                </h2>
                <p class="text-sm text-slate-400 mb-6 leading-relaxed">
                    Dengan menyetujui dokumen ini, sistem akan otomatis membubuhkan Tanda Tangan Elektronik berupa QR Code yang sah.
                </p>

                <form action="{{ route('kades.approve', $pengajuan) }}" method="POST" class="mb-3" onsubmit="return confirm('Anda yakin ingin menyetujui dan menandatangani dokumen ini?');">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Setujui & Terbitkan QR
                    </button>
                </form>

                <form action="{{ route('kades.tolak', $pengajuan) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <textarea name="catatan_kades" rows="2" class="w-full px-3 py-2 bg-slate-800 border border-slate-700 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:border-red-500" placeholder="Alasan penolakan (opsional jika setuju)"></textarea>
                    </div>
                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-2 border border-slate-700 hover:bg-red-500/10 hover:text-red-400 hover:border-red-500/50 text-slate-300 font-medium rounded-xl transition-all duration-200 text-sm">
                        Tolak Permohonan
                    </button>
                </form>
            </div>

            <div class="card">
                <h3 class="text-sm font-bold text-slate-800 mb-3 uppercase tracking-wider">Informasi Tambahan</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <p class="text-slate-400">Pemeriksa (Admin)</p>
                        <p class="font-medium text-slate-900">{{ $pengajuan->verifiedBy->name ?? '-' }}</p>
                        <p class="text-xs text-slate-500">{{ $pengajuan->verified_at ? $pengajuan->verified_at->format('d M Y, H:i') : '-' }}</p>
                    </div>
                    @if($pengajuan->catatan_admin)
                    <div class="bg-blue-50 p-3 rounded-lg border border-blue-100">
                        <p class="text-xs font-bold text-blue-800 mb-1">Catatan Admin:</p>
                        <p class="text-blue-900">{{ $pengajuan->catatan_admin }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
