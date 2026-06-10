@extends('layouts.kades')
@section('title', 'Dashboard Persetujuan')

@section('content')
<div class="mb-8 flex items-end justify-between">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Dashboard Persetujuan</h1>
        <p class="text-slate-500 mt-1">Selamat datang, Kepala Desa. Terdapat dokumen yang memerlukan tanda tangan Anda.</p>
    </div>
    <div class="px-4 py-2 bg-slate-100 rounded-lg text-sm text-slate-600 font-medium flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        {{ now()->locale('id')->isoFormat('D MMMM YYYY') }}
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="card flex items-center justify-between">
        <div>
            <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-2">Menunggu Persetujuan</p>
            <p class="text-4xl font-bold text-slate-900">{{ $stats['menunggu'] }}</p>
        </div>
        <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
    </div>
    <div class="card flex items-center justify-between border-blue-100 bg-blue-50/30">
        <div>
            <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-2">Disetujui Hari Ini</p>
            <p class="text-4xl font-bold text-blue-600">{{ $stats['disetujui'] }}</p>
        </div>
        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
    </div>
    <div class="card flex items-center justify-between">
        <div>
            <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-2">Total Dokumen (Bulan Ini)</p>
            <p class="text-4xl font-bold text-slate-900">{{ $stats['total_bulan'] }}</p>
        </div>
        <div class="w-12 h-12 bg-slate-100 text-slate-600 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/></svg>
        </div>
    </div>
</div>

<div class="card p-0 overflow-hidden">
    <div class="p-5 border-b border-slate-100 flex items-center justify-between">
        <h2 class="text-lg font-bold text-slate-800">Dokumen Menunggu Tanda Tangan</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Pemohon</th>
                    <th>Jenis Dokumen</th>
                    <th>Keperluan</th>
                    <th>Tanggal Masuk</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($antrean as $p)
                <tr>
                    <td>
                        <p class="font-semibold text-slate-800">{{ $p->penduduk->nama }}</p>
                        <p class="text-xs text-slate-500">NIK: {{ $p->penduduk->nik }}</p>
                    </td>
                    <td class="font-medium text-slate-800">{{ $p->jenisSurat->nama }}</td>
                    <td class="text-slate-600 max-w-xs truncate">{{ $p->keperluan }}</td>
                    <td class="text-slate-600">{{ $p->verified_at ? $p->verified_at->format('d M Y, H:i') : '-' }}</td>
                    <td class="text-center">
                        <a href="{{ route('kades.review', $p) }}" class="btn-outline px-4 py-2 text-sm bg-white">
                            Tinjau Dokumen
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-16 text-slate-500">
                        <svg class="w-16 h-16 mx-auto mb-4 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="font-medium">Tidak ada antrean dokumen</p>
                        <p class="text-sm mt-1">Semua dokumen telah disetujui.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-slate-100">
        {{ $antrean->links() }}
    </div>
</div>
@endsection
