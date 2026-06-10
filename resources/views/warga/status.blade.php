@extends('layouts.warga')
@section('title', 'Status Pengajuan')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Status Pengajuan Surat</h1>
        <p class="text-slate-500 text-sm mt-1">Pantau semua pengajuan surat Anda</p>
    </div>
    <a href="{{ route('warga.pilih_surat') }}" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Ajukan Baru
    </a>
</div>

<div class="card p-0 overflow-hidden">
    @if($pengajuan->isEmpty())
    <div class="py-16 text-center text-slate-400">
        <svg class="w-16 h-16 mx-auto mb-4 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        <p class="font-medium text-slate-500">Belum ada pengajuan surat</p>
        <p class="text-sm mt-1">Klik tombol "Ajukan Baru" untuk membuat pengajuan</p>
    </div>
    @else
    <div class="overflow-x-auto w-full">
        <table class="data-table min-w-full">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Surat</th>
                    <th>Keperluan</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengajuan as $i => $p)
                <tr>
                    <td class="text-slate-400">{{ $pengajuan->firstItem() + $i }}</td>
                    <td class="font-medium">{{ $p->jenisSurat->nama }}</td>
                    <td class="text-slate-500 max-w-xs truncate">{{ Str::limit($p->keperluan, 40) }}</td>
                    <td class="text-slate-500">{{ $p->created_at->format('d M Y') }}</td>
                    <td>
                        <span class="badge-{{ $p->status }}">{{ $p->status_badge['label'] }}</span>
                    </td>
                    <td>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('warga.detail', $p) }}"
                               class="p-1.5 text-slate-400 hover:text-blue-600 border border-slate-200 rounded-lg transition-colors" title="Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            @if($p->status === 'selesai')
                            <a href="{{ route('warga.download', $p) }}"
                               class="p-1.5 text-blue-500 hover:text-blue-700 border border-blue-200 rounded-lg transition-colors" title="Download Surat">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-slate-100">
        {{ $pengajuan->links() }}
    </div>
    @endif
</div>
@endsection
