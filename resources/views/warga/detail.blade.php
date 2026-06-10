@extends('layouts.warga')
@section('title', 'Detail Pengajuan')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-2 text-sm text-slate-400 mb-6">
        <a href="{{ route('warga.status') }}" class="hover:text-slate-600">Status Pengajuan</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-700 font-medium">Detail</span>
    </div>

    @if($pengajuan->status === 'ditolak')
    <div class="bg-red-50 border border-red-200 rounded-xl p-5 mb-6 flex items-start gap-4 shadow-sm animate-fade-in">
        <div class="w-10 h-10 bg-red-100 text-red-600 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <div class="flex-1">
            <h3 class="font-bold text-red-900 text-base">Pengajuan Surat Ditolak</h3>
            <p class="text-sm text-red-700 mt-1 leading-relaxed">
                Mohon maaf, pengajuan surat Anda belum dapat diproses.
                @if($pengajuan->catatan_kades || $pengajuan->catatan_admin)
                    <span class="block mt-2 font-semibold text-red-800">
                        Alasan Penolakan: 
                        <span class="italic font-normal text-red-700">
                            "{{ $pengajuan->catatan_kades ?: $pengajuan->catatan_admin }}"
                        </span>
                    </span>
                @endif
            </p>
            <div class="mt-4 flex items-center gap-3">
                <a href="{{ route('warga.dashboard') }}" class="inline-flex items-center gap-1.5 px-4 py-2 font-bold text-xs rounded-lg transition-colors shadow-sm" style="background-color: #e11d48; color: #ffffff !important;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Ajukan Surat Baru
                </a>
                <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center gap-1.5 px-4 py-2 border font-bold text-xs rounded-lg transition-colors bg-white" style="border-color: #cbd5e1; color: #334155 !important;">
                    Hubungi Admin Desa
                </a>
            </div>
        </div>
    </div>
    @endif

    <div class="card mb-4">
        <div class="flex items-start justify-between mb-4">
            <div>
                <h1 class="text-xl font-bold text-slate-900">{{ $pengajuan->jenisSurat->nama }}</h1>
                @if($pengajuan->no_surat)
                <p class="text-sm text-slate-500 mt-1">No. Surat: <span class="font-mono font-semibold">{{ $pengajuan->no_surat }}</span></p>
                @endif
            </div>
            <span class="badge-{{ $pengajuan->status }} text-sm px-3 py-1">{{ $pengajuan->status_badge['label'] }}</span>
        </div>

        <div class="space-y-3 text-sm">
            <div class="grid grid-cols-2 gap-4">
                <div><p class="text-slate-400">Tanggal Pengajuan</p><p class="font-medium">{{ $pengajuan->created_at->format('d M Y, H:i') }}</p></div>
                <div>
                    <p class="text-slate-400">Keperluan</p>
                    <p class="font-medium text-slate-800 leading-relaxed">
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
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Dokumen --}}
    <div class="card mb-4">
        <h2 class="font-semibold text-slate-800 mb-3">Dokumen yang Diunggah</h2>
        <div class="space-y-2">
            @foreach($pengajuan->dokumen as $dok)
            <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-lg">
                <svg class="w-5 h-5 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <div class="flex-1">
                    <p class="font-medium text-sm">{{ $dok->jenis_dokumen }}</p>
                    <p class="text-xs text-slate-400">{{ $dok->nama_file }} ({{ $dok->file_size_formatted }})</p>
                </div>
                <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Status Timeline --}}
    <div class="card mb-4">
        <h2 class="font-semibold text-slate-800 mb-4">Riwayat Status</h2>
        <div class="space-y-3">
            <div class="flex gap-3">
                <div class="w-6 h-6 rounded-full bg-blue-500 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                </div>
                <div><p class="font-medium text-sm">Pengajuan Dikirim</p><p class="text-xs text-slate-400">{{ $pengajuan->created_at->format('d M Y, H:i') }}</p></div>
            </div>
            @if($pengajuan->verified_at)
            <div class="flex gap-3">
                <div class="w-6 h-6 rounded-full bg-blue-500 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                </div>
                <div>
                    <p class="font-medium text-sm">Diverifikasi Admin</p>
                    <p class="text-xs text-slate-400">{{ $pengajuan->verified_at->format('d M Y, H:i') }} oleh {{ $pengajuan->verifiedBy->name ?? '-' }}</p>
                </div>
            </div>
            @endif
            @if($pengajuan->approved_at)
            <div class="flex gap-3">
                <div class="w-6 h-6 rounded-full {{ $pengajuan->status === 'selesai' ? 'bg-blue-500' : 'bg-red-500' }} flex items-center justify-center flex-shrink-0 mt-0.5">
                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                </div>
                <div>
                    <p class="font-medium text-sm">{{ $pengajuan->status === 'selesai' ? 'Disetujui Kepala Desa' : 'Ditolak' }}</p>
                    <p class="text-xs text-slate-400">{{ $pengajuan->approved_at->format('d M Y, H:i') }}</p>
                    @if($pengajuan->catatan_kades)<p class="text-xs text-red-500 mt-1">Catatan: {{ $pengajuan->catatan_kades }}</p>@endif
                </div>
            </div>
            @endif
        </div>
    </div>

    @if($pengajuan->status === 'selesai')
    <a href="{{ route('warga.download', $pengajuan) }}" class="btn-primary w-full justify-center">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
        Unduh Surat (PDF + QR Code)
    </a>
    @endif
</div>
@endsection
