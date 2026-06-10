@extends('layouts.admin')
@section('title', 'Detail Verifikasi')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex items-center gap-2 text-sm text-slate-400 mb-6">
        <a href="{{ route('admin.verifikasi.index') }}" class="hover:text-slate-600">Verifikasi Berkas</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-700 font-medium">Detail Pengajuan</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Kolom Kiri: Info & Dokumen --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Info Surat --}}
            <div class="card">
                <div class="flex items-start justify-between mb-4 pb-4 border-b border-slate-100">
                    <div>
                        <h2 class="text-xl font-bold text-slate-900">{{ $pengajuan->jenisSurat->nama }}</h2>
                        <p class="text-slate-500 mt-1 text-sm">Diajukan pada {{ $pengajuan->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <span class="badge-{{ $pengajuan->status }} px-3 py-1 text-sm">{{ $pengajuan->status_badge['label'] }}</span>
                </div>
                <div>
                    <p class="text-sm text-slate-400 mb-1">Keperluan Pengajuan</p>
                    <div class="font-medium text-slate-800 bg-slate-50 p-3 rounded-lg leading-relaxed">
                        @if($pengajuan->jenisSurat->kode === 'IKH')
                            @php
                                $details = json_decode($pengajuan->keperluan, true);
                            @endphp
                            @if(is_array($details))
                                <span class="block"><strong>Acara:</strong> {{ $details['acara'] }}</span>
                                <span class="block"><strong>Hari/Tgl:</strong> {{ $details['hari'] }}, {{ $details['tanggal'] }}</span>
                                <span class="block"><strong>Tempat:</strong> {{ $details['tempat'] }}</span>
                                <span class="block"><strong>Hiburan:</strong> {{ $details['hiburan'] }}</span>
                            @else
                                {{ $pengajuan->keperluan }}
                            @endif
                        @else
                            {{ $pengajuan->keperluan }}
                        @endif
                    </div>
                </div>
            </div>

            {{-- Dokumen Persyaratan --}}
            <div class="card">
                <h2 class="text-lg font-bold text-slate-800 mb-4">Dokumen Persyaratan</h2>
                <div class="space-y-3">
                    @foreach($pengajuan->dokumen as $dok)
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800">{{ $dok->jenis_dokumen }}</p>
                                <p class="text-xs text-slate-500">{{ $dok->nama_file }} • {{ $dok->file_size_formatted }}</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.verifikasi.dokumen', [$pengajuan, strtolower($dok->jenis_dokumen)]) }}" target="_blank" class="btn-outline px-3 py-1.5 text-xs bg-white">
                            Lihat Dokumen
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Pemohon & Aksi --}}
        <div class="space-y-6">
            {{-- Data Pemohon --}}
            <div class="card">
                <h2 class="text-lg font-bold text-slate-800 mb-4 pb-4 border-b border-slate-100">Data Pemohon</h2>
                <div class="space-y-4 text-sm">
                    <div>
                        <p class="text-slate-400">Nama Lengkap</p>
                        <p class="font-semibold text-slate-800">{{ $pengajuan->penduduk->nama }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400">NIK / No. KK</p>
                        <p class="font-semibold text-slate-800">{{ $pengajuan->penduduk->nik }} <br><span class="text-xs font-normal text-slate-500">KK: {{ $pengajuan->penduduk->no_kk }}</span></p>
                    </div>
                    <div>
                        <p class="text-slate-400">Alamat</p>
                        <p class="font-semibold text-slate-800">{{ $pengajuan->penduduk->alamat_lengkap }}</p>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-100 text-center">
                    <a href="{{ route('admin.penduduk.edit', $pengajuan->penduduk) }}" target="_blank" class="text-sm font-medium text-blue-600 hover:text-blue-700">Lihat Detail Penduduk &rarr;</a>
                </div>
            </div>

            {{-- Form Verifikasi --}}
            @if($pengajuan->status == 'menunggu')
            <div class="card bg-blue-50 border-blue-100">
                <h2 class="text-lg font-bold text-slate-800 mb-4">Aksi Verifikasi</h2>
                <form action="{{ route('admin.verifikasi.proses', $pengajuan) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="form-label text-slate-700">Keputusan</label>
                        <select name="aksi" class="form-input bg-white" required onchange="document.getElementById('catatan_wrapper').style.display = this.value == 'ditolak' ? 'block' : 'none'">
                            <option value="">Pilih Aksi...</option>
                            <option value="diproses">Valid - Teruskan ke Kepala Desa</option>
                            <option value="ditolak">Tolak - Berkas Tidak Valid</option>
                        </select>
                    </div>
                    <div id="catatan_wrapper" style="display: none;">
                        <label class="form-label text-slate-700">Alasan Penolakan <span class="text-red-500">*</span></label>
                        <textarea name="catatan_admin" rows="3" class="form-input bg-white resize-none" placeholder="Tuliskan alasan penolakan..."></textarea>
                    </div>
                    <button type="submit" class="btn-primary w-full justify-center">Simpan Verifikasi</button>
                </form>
            </div>
            @endif

            {{-- Riwayat --}}
            @if(in_array($pengajuan->status, ['diproses', 'disetujui', 'ditolak', 'selesai']))
            <div class="card">
                <h2 class="text-lg font-bold text-slate-800 mb-4 pb-4 border-b border-slate-100">Riwayat Verifikasi</h2>
                <div class="space-y-4 text-sm">
                    <div>
                        <p class="text-slate-400">Diverifikasi Oleh</p>
                        <p class="font-semibold text-slate-800">{{ $pengajuan->verifiedBy->name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400">Tanggal Verifikasi</p>
                        <p class="font-semibold text-slate-800">{{ $pengajuan->verified_at ? $pengajuan->verified_at->format('d M Y, H:i') : '-' }}</p>
                    </div>
                    @if($pengajuan->catatan_admin)
                    <div>
                        <p class="text-slate-400">Catatan Admin</p>
                        <p class="font-medium text-slate-800">{{ $pengajuan->catatan_admin }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
