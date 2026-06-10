@extends('layouts.admin')
@section('title', 'Arsip Surat')

@section('content')
<div class="mb-8">
    <div class="flex items-end justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Arsip Surat</h1>
            <p class="text-slate-500 mt-1">Daftar seluruh pengajuan surat warga yang telah selesai diproses dan disetujui.</p>
        </div>
        <div class="px-4 py-2 bg-slate-100 rounded-lg text-sm text-slate-600 font-medium flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            {{ now()->locale('id')->isoFormat('D MMMM YYYY') }}
        </div>
    </div>
</div>

{{-- Search & Filters --}}
<div class="card mb-6">
    <form method="GET" action="{{ route('admin.arsip') }}" class="flex flex-wrap items-end gap-4">
        <div class="flex-1 min-w-[220px]">
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Cari</label>
            <div class="relative">
                <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama, NIK, atau No. Surat..." class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>
        <div class="min-w-[160px]">
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Jenis Surat</label>
            <select name="jenis" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                <option value="">Semua Jenis</option>
                @foreach($jenisSuratList as $js)
                    <option value="{{ $js->id }}" {{ request('jenis') == $js->id ? 'selected' : '' }}>{{ $js->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="min-w-[120px]">
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Bulan</label>
            <select name="bulan" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                <option value="">Semua</option>
                @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $nm)
                    <option value="{{ $i + 1 }}" {{ request('bulan') == ($i + 1) ? 'selected' : '' }}>{{ $nm }}</option>
                @endforeach
            </select>
        </div>
        <div class="min-w-[100px]">
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Tahun</label>
            <select name="tahun" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                <option value="">Semua</option>
                @for($y = now()->year; $y >= now()->year - 3; $y--)
                    <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="px-5 py-2.5 bg-slate-900 text-white rounded-lg text-sm font-semibold hover:bg-slate-800 transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                Filter
            </button>
            @if(request()->hasAny(['search','jenis','bulan','tahun']))
                <a href="{{ route('admin.arsip') }}" class="px-4 py-2.5 border border-slate-200 text-slate-600 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors">
                    Reset
                </a>
            @endif
        </div>
    </form>
</div>

{{-- Data Table --}}
<div class="card p-0 overflow-hidden">
    <div class="p-5 border-b border-slate-100 flex items-center justify-between">
        <h2 class="text-lg font-bold text-slate-800">Daftar Arsip Surat Selesai</h2>
        <span class="text-sm text-slate-500">{{ $pengajuan->total() }} surat ditemukan</span>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No. Surat</th>
                    <th>Pemohon</th>
                    <th>Jenis Surat</th>
                    <th>Tanggal Disetujui</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengajuan as $surat)
                <tr class="group hover:bg-slate-50 transition-colors">
                    <td>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-blue-50 text-blue-700 rounded-md text-xs font-bold font-mono">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>
                            {{ $surat->no_surat }}
                        </span>
                    </td>
                    <td>
                        <p class="font-semibold text-slate-800">{{ $surat->penduduk->nama }}</p>
                        <p class="text-xs text-slate-500">NIK: {{ $surat->penduduk->nik }}</p>
                    </td>
                    <td>
                        <span class="inline-flex items-center px-2.5 py-1 bg-blue-50 text-blue-700 rounded-md text-xs font-semibold">
                            {{ $surat->jenisSurat->nama }}
                        </span>
                    </td>
                    <td>
                        <p class="text-slate-800 font-medium">{{ $surat->approved_at ? $surat->approved_at->format('d M Y') : '-' }}</p>
                        <p class="text-xs text-slate-500">{{ $surat->approved_at ? $surat->approved_at->format('H:i') . ' WIB' : '' }}</p>
                    </td>
                    <td class="text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.verifikasi.show', $surat) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-lg hover:border-blue-400 hover:text-blue-600 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Detail
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-16 text-slate-500">
                        <svg class="w-16 h-16 mx-auto mb-4 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <p class="font-medium">Belum ada arsip surat</p>
                        <p class="text-sm mt-1">Data surat yang telah disetujui akan muncul di sini.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($pengajuan->hasPages())
    <div class="p-4 border-t border-slate-100">
        {{ $pengajuan->links() }}
    </div>
    @endif
</div>
@endsection
