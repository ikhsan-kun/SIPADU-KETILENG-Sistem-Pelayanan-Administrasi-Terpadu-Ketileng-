@extends('layouts.admin')
@section('title', 'Laporan Bulanan')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Laporan Surat</h1>
        <p class="text-slate-500 text-sm mt-1">Rekapitulasi pengajuan surat per bulan.</p>
    </div>
</div>

<div class="card mb-6 bg-slate-50 border-none">
    <form method="GET" action="{{ route('admin.laporan') }}" class="flex flex-wrap items-end gap-4">
        <div>
            <label class="form-label text-slate-700">Bulan</label>
            <select name="bulan" class="form-input bg-white w-48">
                @foreach($bulanList as $key => $nama)
                    <option value="{{ $key }}" {{ $bulan == $key ? 'selected' : '' }}>{{ $nama }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="form-label text-slate-700">Tahun</label>
            <select name="tahun" class="form-input bg-white w-32">
                @foreach($tahunList as $t)
                    <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn-primary py-3">Filter Laporan</button>
        <a href="{{ route('admin.laporan.excel', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn-outline py-3 ml-auto bg-white border-slate-300 hover:text-blue-700 hover:border-blue-400 hover:bg-blue-50 transition-colors inline-flex items-center gap-2">
            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Export Excel
        </a>
    </form>
</div>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="card-sm text-center">
        <p class="text-xs text-slate-500 font-medium uppercase tracking-wider mb-1">Total Pengajuan</p>
        <p class="text-3xl font-bold text-slate-900">{{ $rekap['total'] }}</p>
    </div>
    <div class="card-sm text-center">
        <p class="text-xs text-slate-500 font-medium uppercase tracking-wider mb-1">Selesai</p>
        <p class="text-3xl font-bold text-blue-600">{{ $rekap['selesai'] }}</p>
    </div>
    <div class="card-sm text-center">
        <p class="text-xs text-slate-500 font-medium uppercase tracking-wider mb-1">Dalam Proses</p>
        <p class="text-3xl font-bold text-blue-600">{{ $rekap['proses'] }}</p>
    </div>
    <div class="card-sm text-center">
        <p class="text-xs text-slate-500 font-medium uppercase tracking-wider mb-1">Ditolak</p>
        <p class="text-3xl font-bold text-red-600">{{ $rekap['ditolak'] }}</p>
    </div>
</div>

<div class="card p-0 overflow-hidden printable">
    <div class="p-5 border-b border-slate-100 print:hidden">
        <h2 class="text-lg font-bold text-slate-800">Detail Transaksi Bulan {{ $bulanList[$bulan] }} {{ $tahun }}</h2>
    </div>
    <div class="hidden print:block p-5 text-center mb-4">
        <h2 class="text-xl font-bold uppercase">Laporan Pelayanan Surat Desa Ketileng</h2>
        <p>Periode: {{ $bulanList[$bulan] }} {{ $tahun }}</p>
        <hr class="mt-4 border-black">
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr class="print:bg-gray-200">
                    <th>No.</th>
                    <th>No. Surat</th>
                    <th>Jenis Surat</th>
                    <th>Pemohon</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $i => $d)
                <tr class="print:border-b print:border-gray-300">
                    <td class="text-slate-500">{{ $i + 1 }}</td>
                    <td class="font-medium text-slate-900">{{ $d->no_surat ?? '-' }}</td>
                    <td>{{ $d->jenisSurat->nama }}</td>
                    <td>
                        <p class="font-medium text-slate-800">{{ $d->penduduk->nama }}</p>
                        <p class="text-xs text-slate-500">{{ $d->penduduk->nik }}</p>
                    </td>
                    <td>{{ $d->created_at->format('d/m/Y') }}</td>
                    <td><span class="badge-{{ $d->status }}">{{ $d->status_badge['label'] }}</span></td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-8 text-slate-500">Tidak ada data di bulan ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    @media print {
        body * { visibility: hidden; }
        .printable, .printable * { visibility: visible; }
        .printable { position: absolute; left: 0; top: 0; width: 100%; box-shadow: none; border: none; }
        .print\:hidden { display: none !important; }
        .print\:block { display: block !important; }
        .print\:bg-gray-200 { background-color: #e5e7eb !important; -webkit-print-color-adjust: exact; }
        .print\:border-b { border-bottom: 1px solid #d1d5db !important; }
    }
</style>
@endsection
