@extends('layouts.admin')
@section('title', 'Dashboard Admin')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-slate-900">Selamat Datang, Admin</h1>
    <p class="text-slate-500 mt-1">Berikut adalah ringkasan aktivitas desa hari ini.</p>
</div>

{{-- Stat Cards --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card flex items-center gap-4">
        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Total Penduduk</p>
            <p class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($stats['total_penduduk']) }}</p>
        </div>
    </div>
    
    <div class="card flex items-center gap-4">
        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Berkas Masuk</p>
            <p class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($stats['berkas_masuk']) }}</p>
        </div>
    </div>

    <div class="card flex items-center gap-4">
        <div class="w-12 h-12 bg-red-100 text-red-600 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Perlu Tinjauan</p>
            <p class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($stats['perlu_tinjauan']) }}</p>
        </div>
    </div>

    <div class="card flex items-center gap-4">
        <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Sedang Diproses</p>
            <p class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($stats['diproses']) }}</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    {{-- Verifikasi Berkas (Pending) --}}
    <div class="card p-0 overflow-hidden flex flex-col">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-lg font-bold text-slate-800">Verifikasi Berkas</h2>
            <a href="{{ route('admin.verifikasi.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">Lihat Semua</a>
        </div>
        <div class="flex-1 overflow-auto">
            @if($verifikasi_pending->isEmpty())
                <div class="p-8 text-center text-slate-400">
                    Belum ada berkas yang perlu diverifikasi.
                </div>
            @else
                <table class="w-full text-left text-sm min-w-[500px]">
                    <tbody>
                        @foreach($verifikasi_pending as $p)
                        <tr class="border-b border-slate-50 hover:bg-slate-50">
                            <td class="p-4">
                                <p class="font-semibold text-slate-800">{{ $p->jenisSurat->nama }}</p>
                                <p class="text-slate-500 text-xs mt-1">Pemohon: {{ $p->penduduk->nama }}</p>
                                <p class="text-slate-400 text-xs mt-0.5"><svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $p->created_at->diffForHumans() }}</p>
                            </td>
                            <td class="p-4 text-right">
                                <span class="badge-menunggu mb-2 block w-fit ml-auto">{{ $p->status_badge['label'] }}</span>
                                <a href="{{ route('admin.verifikasi.show', $p) }}" class="btn-outline px-3 py-1 text-xs">Review</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    {{-- Penduduk Terbaru --}}
    <div class="card p-0 overflow-hidden flex flex-col">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-lg font-bold text-slate-800">Data Penduduk Terbaru</h2>
            <a href="{{ route('admin.penduduk.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">Lihat Semua Data</a>
        </div>
        <div class="flex-1 overflow-auto">
            @if($penduduk_terbaru->isEmpty())
                <div class="p-8 text-center text-slate-400">
                    Belum ada data penduduk.
                </div>
            @else
                <table class="w-full text-left text-sm min-w-[500px]">
                    <thead class="bg-slate-50 text-slate-500">
                        <tr>
                            <th class="p-4 font-semibold">Nama</th>
                            <th class="p-4 font-semibold">NIK</th>
                            <th class="p-4 font-semibold">Desa / Kecamatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penduduk_terbaru as $p)
                        <tr class="border-b border-slate-50 hover:bg-slate-50">
                            <td class="p-4 font-medium text-slate-800">{{ $p->nama }}</td>
                            <td class="p-4 text-slate-500">{{ $p->nik }}</td>
                            <td class="p-4 text-slate-500">{{ $p->desa }}, Kec. {{ $p->kecamatan }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>

{{-- Arsip Surat Terakhir --}}
<div class="card p-0 overflow-hidden">
    <div class="p-5 border-b border-slate-100 flex items-center justify-between">
        <h2 class="text-lg font-bold text-slate-800">Arsip Surat Hari Ini</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No. Surat</th>
                    <th>Jenis Surat</th>
                    <th>Pemohon</th>
                    <th>Tanggal Selesai</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($arsip_surat as $p)
                <tr>
                    <td class="font-medium text-slate-800">{{ $p->no_surat }}</td>
                    <td class="text-slate-600">{{ $p->jenisSurat->nama }}</td>
                    <td class="text-slate-600">{{ $p->penduduk->nama }}</td>
                    <td class="text-slate-600">{{ $p->approved_at->format('d M Y') }}</td>
                    <td><span class="badge-selesai flex items-center gap-1 w-fit"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Selesai</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-12 text-slate-500">
                        <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Tidak ada arsip surat hari ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
