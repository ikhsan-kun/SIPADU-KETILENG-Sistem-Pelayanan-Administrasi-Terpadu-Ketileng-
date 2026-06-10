@extends('layouts.admin')
@section('title', 'Verifikasi Berkas')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Verifikasi Berkas</h1>
        <p class="text-slate-500 text-sm mt-1">Kelola dan verifikasi pengajuan surat dari warga.</p>
    </div>
</div>

<div class="card p-0 overflow-hidden">
    <div class="p-4 border-b border-slate-100 bg-slate-50 flex flex-wrap gap-4 items-center justify-between">
        <div class="flex gap-2">
            <a href="{{ route('admin.verifikasi.index', ['status' => 'menunggu']) }}" 
               class="px-4 py-2 text-sm font-medium rounded-lg {{ $status == 'menunggu' ? 'bg-blue-500 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
                Menunggu Verifikasi
            </a>
            <a href="{{ route('admin.verifikasi.index', ['status' => 'diproses']) }}" 
               class="px-4 py-2 text-sm font-medium rounded-lg {{ $status == 'diproses' ? 'bg-blue-500 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
                Diteruskan ke Kades
            </a>
            <a href="{{ route('admin.verifikasi.index', ['status' => 'ditolak']) }}" 
               class="px-4 py-2 text-sm font-medium rounded-lg {{ $status == 'ditolak' ? 'bg-blue-500 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
                Ditolak
            </a>
        </div>
        
        <form method="GET" action="{{ route('admin.verifikasi.index') }}" class="relative w-64">
            <input type="hidden" name="status" value="{{ $status }}">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari pemohon / jenis surat..." class="form-input pl-9 py-2 text-sm">
            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            @if($search)
                <a href="{{ route('admin.verifikasi.index', ['status' => $status]) }}" class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Pemohon</th>
                    <th>Jenis Surat</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengajuan as $p)
                <tr>
                    <td>
                        <p class="font-semibold text-slate-800">{{ $p->penduduk->nama }}</p>
                        <p class="text-xs text-slate-500">NIK: {{ $p->penduduk->nik }}</p>
                    </td>
                    <td class="font-medium text-slate-800">{{ $p->jenisSurat->nama }}</td>
                    <td class="text-slate-600">{{ $p->created_at->format('d M Y, H:i') }}</td>
                    <td><span class="badge-{{ $p->status }}">{{ $p->status_badge['label'] }}</span></td>
                    <td>
                        <div class="flex items-center justify-center">
                            @if($p->status == 'menunggu')
                                <a href="{{ route('admin.verifikasi.show', $p) }}" class="btn-outline px-3 py-1.5 text-xs">Review & Verifikasi</a>
                            @else
                                <a href="{{ route('admin.verifikasi.show', $p) }}" class="p-1.5 text-slate-400 hover:text-blue-600 bg-slate-100 hover:bg-blue-50 rounded-lg transition-colors" title="Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-12 text-slate-500">
                        Tidak ada data pengajuan surat.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-slate-100">
        {{ $pengajuan->links() }}
    </div>
</div>
@endsection
