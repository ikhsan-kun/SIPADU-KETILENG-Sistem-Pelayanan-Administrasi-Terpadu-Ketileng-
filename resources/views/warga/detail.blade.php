@extends('layouts.warga')
@section('title', 'Detail Pengajuan')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-2 text-sm text-slate-400 mb-6">
        <a href="{{ route('warga.status') }}" class="hover:text-slate-600">Status Pengajuan</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-700 font-medium">Detail</span>
    </div>

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
                <div><p class="text-slate-400">Keperluan</p><p class="font-medium">{{ $pengajuan->keperluan }}</p></div>
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
                <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Status Timeline --}}
    <div class="card mb-4">
        <h2 class="font-semibold text-slate-800 mb-4">Riwayat Status</h2>
        <div class="space-y-3">
            <div class="flex gap-3">
                <div class="w-6 h-6 rounded-full bg-emerald-500 flex items-center justify-center flex-shrink-0 mt-0.5">
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
                <div class="w-6 h-6 rounded-full {{ $pengajuan->status === 'selesai' ? 'bg-emerald-500' : 'bg-red-500' }} flex items-center justify-center flex-shrink-0 mt-0.5">
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
