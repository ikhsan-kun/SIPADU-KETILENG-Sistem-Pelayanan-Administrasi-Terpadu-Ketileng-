@extends('layouts.warga')
@section('title', 'Dashboard')

@section('content')
{{-- Header --}}
<div class="mb-8">
    <h1 class="text-2xl font-bold text-slate-900">Selamat Datang, {{ explode(' ', auth()->user()->name)[0] }} 👋</h1>
    <p class="text-slate-500 mt-1">Pilih layanan administrasi yang Anda butuhkan hari ini.</p>
</div>

{{-- Stat Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="card-sm text-center">
        <p class="text-2xl font-bold text-slate-900">{{ $stats['total'] }}</p>
        <p class="text-xs text-slate-500 mt-1">Total Pengajuan</p>
    </div>
    <div class="card-sm text-center">
        <p class="text-2xl font-bold text-blue-600">{{ $stats['selesai'] }}</p>
        <p class="text-xs text-slate-500 mt-1">Selesai</p>
    </div>
    <div class="card-sm text-center">
        <p class="text-2xl font-bold text-blue-600">{{ $stats['proses'] }}</p>
        <p class="text-xs text-slate-500 mt-1">Sedang Diproses</p>
    </div>
    <div class="card-sm text-center">
        <p class="text-2xl font-bold text-red-500">{{ $stats['ditolak'] }}</p>
        <p class="text-xs text-slate-500 mt-1">Ditolak</p>
    </div>
</div>

{{-- Panduan Pengajuan Surat --}}
<div class="mb-8">
    <h2 class="text-lg font-bold text-slate-900 mb-4">Panduan Pengajuan Surat</h2>
    <div class="card p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 relative">
            {{-- Connecting Line (visible on md screens) --}}
            <div class="hidden md:block absolute top-8 left-[12%] right-[12%] h-0.5 bg-slate-100 z-0"></div>

            {{-- Step 1 --}}
            <div class="relative z-10 flex flex-col items-center text-center group">
                <div class="w-16 h-16 bg-white border-4 border-slate-50 rounded-full flex items-center justify-center mb-4 shadow-sm group-hover:border-blue-50 group-hover:shadow-md transition-all duration-300">
                    <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/></svg>
                    </div>
                </div>
                <h3 class="text-sm font-bold text-slate-900">1. Pilih Surat</h3>
                <p class="text-xs text-slate-500 mt-2 px-2">Buka menu Ajukan Surat dan pilih jenis dokumen yang Anda butuhkan.</p>
            </div>

            {{-- Step 2 --}}
            <div class="relative z-10 flex flex-col items-center text-center group">
                <div class="w-16 h-16 bg-white border-4 border-slate-50 rounded-full flex items-center justify-center mb-4 shadow-sm group-hover:border-amber-50 group-hover:shadow-md transition-all duration-300">
                    <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    </div>
                </div>
                <h3 class="text-sm font-bold text-slate-900">2. Upload Syarat</h3>
                <p class="text-xs text-slate-500 mt-2 px-2">Isi keperluan dan upload foto/scan KTP serta Kartu Keluarga.</p>
            </div>

            {{-- Step 3 --}}
            <div class="relative z-10 flex flex-col items-center text-center group">
                <div class="w-16 h-16 bg-white border-4 border-slate-50 rounded-full flex items-center justify-center mb-4 shadow-sm group-hover:border-purple-50 group-hover:shadow-md transition-all duration-300">
                    <div class="w-10 h-10 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <h3 class="text-sm font-bold text-slate-900">3. Verifikasi</h3>
                <p class="text-xs text-slate-500 mt-2 px-2">Tunggu proses pengecekan berkas oleh Admin dan persetujuan Kepala Desa.</p>
            </div>

            {{-- Step 4 --}}
            <div class="relative z-10 flex flex-col items-center text-center group">
                <div class="w-16 h-16 bg-white border-4 border-slate-50 rounded-full flex items-center justify-center mb-4 shadow-sm group-hover:border-blue-50 group-hover:shadow-md transition-all duration-300">
                    <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                </div>
                <h3 class="text-sm font-bold text-slate-900">4. Unduh & Cetak</h3>
                <p class="text-xs text-slate-500 mt-2 px-2">Surat yang disetujui dapat diunduh (PDF) langsung dari menu Status.</p>
            </div>
        </div>
        
        <div class="mt-8 pt-6 border-t border-slate-100 text-center">
            <a href="{{ route('warga.pilih_surat') }}" class="btn-primary inline-flex items-center">
                Mulai Ajukan Surat
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</div>

@endsection
