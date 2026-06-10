<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Dokumen – Desa Ketileng</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-[Inter] min-h-screen flex items-center justify-center p-4">

    <div class="max-w-lg w-full">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-blue-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-blue-500/20">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <h1 class="text-2xl font-bold text-slate-900">Verifikasi Dokumen Sah</h1>
            <p class="text-slate-500 mt-2">Dokumen ini telah diterbitkan secara resmi oleh Pemerintah Desa Ketileng.</p>
        </div>

        <div class="card shadow-xl shadow-slate-200/50 border-0 mb-6 relative overflow-hidden">
            <div class="absolute top-0 inset-x-0 h-1 bg-blue-500"></div>
            
            <div class="text-center pb-6 border-b border-slate-100 mb-6">
                <h2 class="text-lg font-bold text-slate-800 uppercase">{{ $pengajuan->jenisSurat->nama }}</h2>
                <p class="text-slate-500 font-mono mt-1">{{ $pengajuan->no_surat }}</p>
            </div>

            <div class="space-y-4 text-sm">
                <div>
                    <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-1">Diberikan Kepada</p>
                    <p class="font-bold text-slate-900 text-base">{{ $pengajuan->penduduk->nama }}</p>
                    <p class="text-slate-500">NIK: {{ str_repeat('*', 12) . substr($pengajuan->penduduk->nik, -4) }}</p>
                </div>
                
                <div>
                    <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-1">Keperluan</p>
                    <p class="text-slate-800 font-medium">{{ $pengajuan->keperluan }}</p>
                </div>
                
                <div class="pt-4 border-t border-slate-100">
                    <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-1">Disahkan Oleh</p>
                    <p class="font-bold text-slate-900">{{ $pengajuan->approvedBy->name ?? 'Kepala Desa' }}</p>
                    <p class="text-slate-500">Kepala Desa Ketileng</p>
                    <p class="text-slate-400 mt-1">Pada: {{ $pengajuan->approved_at->format('d F Y, H:i') }} WIB</p>
                </div>
            </div>
        </div>

        <p class="text-center text-xs text-slate-400 max-w-sm mx-auto">
            Ini adalah halaman verifikasi resmi dari sistem pelayanan administrasi Desa Ketileng, Kec. Kramat, Kab. Tegal.
        </p>
    </div>

</body>
</html>
