@extends('layouts.warga')
@section('title', 'Ajukan Surat')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-slate-900">Ajukan Surat Pengantar</h1>
    <p class="text-slate-500 mt-1">Pilih jenis surat yang ingin Anda ajukan.</p>
</div>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    @php
    $icons = [
        'SKD' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>',
        'SKCK'     => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>',
        'SKTM'     => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>',
        'SKU'      => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>',
        'IKH'      => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 00-2-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
    ];
    @endphp
    @foreach($jenisSurat as $js)
    <a href="{{ route('warga.ajukan', $js) }}"
       class="card hover:border-blue-300 hover:shadow-md transition-all duration-200 group cursor-pointer">
        <div class="w-10 h-10 bg-slate-100 group-hover:bg-blue-50 rounded-xl flex items-center justify-center mb-3 transition-colors">
            <svg class="w-5 h-5 text-slate-500 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                {!! $icons[$js->kode] ?? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>' !!}
            </svg>
        </div>
        <p class="font-semibold text-slate-800 text-sm">{{ $js->nama }}</p>
        <p class="text-xs text-slate-500 mt-1">{{ $js->deskripsi }}</p>
    </a>
    @endforeach
</div>
@endsection
