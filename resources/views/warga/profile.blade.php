@extends('layouts.warga')
@section('title', 'Profil Pengguna')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Profil Pengguna</h1>
        <p class="text-slate-500 text-sm mt-1">Informasi akun dan data kependudukan Anda.</p>
    </div>

    <div class="card space-y-6">
        <div>
            <h2 class="text-lg font-semibold text-slate-800 border-b border-slate-100 pb-2 mb-4">Informasi Akun</h2>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-slate-400">Nama Lengkap</p>
                    <p class="font-medium text-slate-900">{{ $user->name }}</p>
                </div>
                <div>
                    <p class="text-slate-400">NIK (Username)</p>
                    <p class="font-medium text-slate-900">{{ $user->nik }}</p>
                </div>
                <div>
                    <p class="text-slate-400">Nomor Telepon</p>
                    <p class="font-medium text-slate-900">{{ $user->phone ?? '-' }}</p>
                </div>
            </div>
        </div>

        @php
            $penduduk = \App\Models\Penduduk::where('nik', $user->nik)->first();
        @endphp

        @if($penduduk)
        <div>
            <h2 class="text-lg font-semibold text-slate-800 border-b border-slate-100 pb-2 mb-4">Data Kependudukan (Sesuai KK)</h2>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-slate-400">Nomor KK</p>
                    <p class="font-medium text-slate-900">{{ $penduduk->no_kk }}</p>
                </div>
                <div>
                    <p class="text-slate-400">Tempat, Tanggal Lahir</p>
                    <p class="font-medium text-slate-900">{{ $penduduk->tempat_lahir }}, {{ $penduduk->tanggal_lahir->format('d M Y') }}</p>
                </div>
                <div>
                    <p class="text-slate-400">Jenis Kelamin</p>
                    <p class="font-medium text-slate-900">{{ $penduduk->jenis_kelamin }}</p>
                </div>
                <div>
                    <p class="text-slate-400">Pekerjaan</p>
                    <p class="font-medium text-slate-900">{{ $penduduk->pekerjaan ?? '-' }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-slate-400">Alamat Lengkap</p>
                    <p class="font-medium text-slate-900">{{ $penduduk->alamat_lengkap }}</p>
                </div>
            </div>
        </div>
        @else
        <div class="alert-info">
            Data kependudukan Anda belum terhubung. Silakan hubungi admin desa untuk sinkronisasi NIK.
        </div>
        @endif
    </div>
</div>
@endsection
