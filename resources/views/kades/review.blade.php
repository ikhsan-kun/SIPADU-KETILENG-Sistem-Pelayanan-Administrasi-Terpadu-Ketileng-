@extends('layouts.kades')
@section('title', 'Tinjau Dokumen')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex items-center gap-2 text-sm text-slate-400 mb-6">
        <a href="{{ route('kades.dashboard') }}" class="hover:text-slate-600">Dashboard</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-700 font-medium">Tinjau Dokumen</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Kiri: Preview Dokumen --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="card p-0 overflow-hidden bg-slate-100 flex items-center justify-center min-h-[600px] border border-slate-200 relative">
                {{-- Mockup Preview Surat --}}
                <div class="bg-white w-[90%] max-w-[600px] my-10 p-12 shadow-sm relative">
                    <div class="text-center border-b-2 border-black pb-4 mb-8">
                        <h1 class="text-sm font-bold uppercase">PEMERINTAH KABUPATEN TEGAL</h1>
                        <h2 class="text-sm font-bold uppercase">KECAMATAN KRAMAT</h2>
                        <h3 class="text-base font-bold uppercase">KANTOR KEPALA DESA KETILENG</h3>
                        <p class="text-xs font-semibold mt-1">Jl. Sandrageni No. 1 Ketileng Kramat Tegal Kode Pos 52181</p>
                    </div>
                    
                    <div class="text-center mb-8">
                        <h4 class="text-lg font-bold uppercase underline">{{ $pengajuan->jenisSurat->nama }}</h4>
                        <p class="text-sm">Nomor: .../{{ $pengajuan->jenisSurat->kode }}/.../...</p>
                    </div>

                    <div class="text-sm leading-relaxed mb-6 space-y-2">
                        @if($pengajuan->jenisSurat->kode === 'IKH')
                            @php
                                $details = json_decode($pengajuan->keperluan, true);
                                if (!is_array($details)) {
                                    $details = ['acara' => $pengajuan->keperluan, 'hari' => '-', 'tanggal' => '-', 'tempat' => '-', 'hiburan' => '-'];
                                }
                            @endphp
                            <p>Yang bertanda tangan di bawah ini Kepala Desa Ketileng, Kecamatan Kramat, Kabupaten Tegal memberikan <strong>IZIN KHAJATAN</strong> kepada:</p>
                            <table class="w-full ml-4 mb-4">
                                <tr><td class="w-40 py-1">Nama Lengkap</td><td>: <strong>{{ $pengajuan->penduduk->nama }}</strong></td></tr>
                                <tr><td class="py-1">Umur</td><td>: {{ $pengajuan->penduduk->umur }} Tahun</td></tr>
                                <tr><td class="py-1">Pekerjaan</td><td>: {{ $pengajuan->penduduk->pekerjaan }}</td></tr>
                                <tr><td class="py-1 align-top">Alamat</td><td>: {{ $pengajuan->penduduk->alamat_lengkap }}</td></tr>
                            </table>
                            <p class="mt-2">Untuk menyelenggarakan acara/khajatan yang akan dilaksanakan pada:</p>
                            <table class="w-full ml-4 mb-4">
                                <tr><td class="w-40 py-1">Acara / Khajatan</td><td>: <strong>{{ $details['acara'] }}</strong></td></tr>
                                <tr><td class="py-1">Hari</td><td>: {{ $details['hari'] }}</td></tr>
                                <tr><td class="py-1">Tanggal</td><td>: {{ $details['tanggal'] }}</td></tr>
                                <tr><td class="py-1">Tempat</td><td>: {{ $details['tempat'] }}</td></tr>
                                <tr><td class="py-1">Hiburan</td><td>: {{ $details['hiburan'] }}</td></tr>
                            </table>
                            <p class="mt-2">Demikian Surat Izin Khajatan ini diberikan untuk dapat dipergunakan sebagaimana mestinya.</p>
                        @else
                            <p>Yang bertanda tangan di bawah ini Kepala Desa Ketileng, Kecamatan Kramat, Kabupaten Tegal menerangkan dengan sebenarnya bahwa:</p>
                            <table class="w-full ml-4">
                                <tr><td class="w-40 py-1">Nama Lengkap</td><td>: <strong>{{ $pengajuan->penduduk->nama }}</strong></td></tr>
                                <tr><td class="py-1">NIK / No. KK</td><td>: {{ $pengajuan->penduduk->nik }} / {{ $pengajuan->penduduk->no_kk }}</td></tr>
                                <tr><td class="py-1">Tempat, Tgl Lahir</td><td>: {{ $pengajuan->penduduk->tempat_lahir }}, {{ $pengajuan->penduduk->tanggal_lahir->format('d M Y') }}</td></tr>
                                <tr><td class="py-1">Pekerjaan</td><td>: {{ $pengajuan->penduduk->pekerjaan }}</td></tr>
                                <tr><td class="py-1 align-top">Alamat</td><td>: {{ $pengajuan->penduduk->alamat_lengkap }}</td></tr>
                            </table>
                            <p class="mt-4">Orang tersebut di atas benar-benar warga Desa Ketileng yang berdomisili di alamat tersebut. Surat ini dibuat untuk keperluan:</p>
                            <p class="font-semibold text-center italic my-4">"{{ $pengajuan->keperluan }}"</p>
                            <p>Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.</p>
                        @endif
                    </div>

                    <div class="flex justify-end mt-16">
                        <div class="text-center">
                            <p class="text-sm">Ketileng, {{ now()->locale('id')->isoFormat('D MMMM YYYY') }}</p>
                            <p class="text-sm font-bold mb-16">Kepala Desa Ketileng</p>
                            <div class="w-24 h-24 border-2 border-dashed border-slate-300 mx-auto flex items-center justify-center text-slate-400 text-xs">
                                Area QR Code
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            

        </div>

        {{-- Kanan: Aksi --}}
        <div class="space-y-6">
            <div class="card bg-slate-900 text-white">
                <h2 class="text-lg font-bold mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    Aksi Persetujuan
                </h2>
                <p class="text-sm text-slate-400 mb-6 leading-relaxed">
                    Dengan menyetujui dokumen ini, sistem akan otomatis membubuhkan Tanda Tangan Elektronik berupa QR Code yang sah.
                </p>

                <form id="approveForm" action="{{ route('kades.approve', $pengajuan) }}" method="POST" class="mb-3">
                    @csrf
                    <button type="button" onclick="openApproveModal()" class="w-full flex items-center justify-center gap-2 py-3 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-xl transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Setujui & Terbitkan QR
                    </button>
                </form>

                <form action="{{ route('kades.tolak', $pengajuan) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <textarea name="catatan_kades" rows="2" class="w-full px-3 py-2 bg-slate-800 border border-slate-700 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:border-red-500" placeholder="Alasan penolakan (opsional jika setuju)"></textarea>
                    </div>
                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-2 border border-slate-700 hover:bg-red-500/10 hover:text-red-400 hover:border-red-500/50 text-slate-300 font-medium rounded-xl transition-all duration-200 text-sm">
                        Tolak Permohonan
                    </button>
                </form>
            </div>

            <div class="card">
                <h3 class="text-sm font-bold text-slate-800 mb-3 uppercase tracking-wider">Informasi Tambahan</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <p class="text-slate-400">Pemeriksa (Admin)</p>
                        <p class="font-medium text-slate-900">{{ $pengajuan->verifiedBy->name ?? '-' }}</p>
                        <p class="text-xs text-slate-500">{{ $pengajuan->verified_at ? $pengajuan->verified_at->format('d M Y, H:i') : '-' }}</p>
                    </div>
                    @if($pengajuan->catatan_admin)
                    <div class="bg-blue-50 p-3 rounded-lg border border-blue-100">
                        <p class="text-xs font-bold text-blue-800 mb-1">Catatan Admin:</p>
                        <p class="text-blue-900">{{ $pengajuan->catatan_admin }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Setuju Kades -->
<div id="confirmModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden animate-fade-in">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-100 transform scale-95 opacity-0 transition-all duration-300 relative overflow-hidden" id="modalContainer">
        <!-- Background Accent -->
        <div class="absolute top-0 right-0 w-24 h-24 bg-blue-100/50 rounded-full blur-2xl -mr-6 -mt-6"></div>
        
        <!-- Header / Icon -->
        <div class="flex items-center gap-4 mb-4 relative z-10">
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 shadow-inner flex-shrink-0">
                <svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <div class="text-left">
                <h3 class="text-lg font-bold text-slate-900 leading-snug">Konfirmasi Tanda Tangan</h3>
                <p class="text-xs text-slate-400 font-medium">SIPADU - TTE Desa Ketileng</p>
            </div>
        </div>

        <!-- Body Content -->
        <div class="text-sm text-slate-600 text-left leading-relaxed mb-6 relative z-10">
            Apakah Bapak Kepala Desa yakin ingin menyetujui dan membubuhkan **Tanda Tangan Elektronik (TTE)** secara sah berupa QR Code pada dokumen ini?
            
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-3 mt-3 flex flex-col gap-1 text-xs">
                <div class="flex justify-between"><span class="text-slate-400">Nama Dokumen:</span><span class="font-semibold text-slate-800">{{ $pengajuan->jenisSurat->nama }}</span></div>
                <div class="flex justify-between"><span class="text-slate-400">Pemohon:</span><span class="font-semibold text-slate-800">{{ $pengajuan->penduduk->nama }}</span></div>
                <div class="flex justify-between"><span class="text-slate-400">NIK:</span><span class="font-mono text-slate-700">{{ $pengajuan->penduduk->nik }}</span></div>
            </div>
        </div>

        <!-- Buttons / Actions -->
        <div class="flex items-center gap-3 relative z-10">
            <button type="button" onclick="closeApproveModal()" class="flex-1 py-2.5 border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold text-xs rounded-xl transition-all duration-200">
                Batal
            </button>
            <button type="button" onclick="submitApproveForm()" class="flex-1 py-2.5 font-bold text-xs rounded-xl transition-all duration-200 shadow-lg shadow-blue-100 flex items-center justify-center gap-1.5" style="background-color: #3b82f6; color: #ffffff !important;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Ya, Setujui
            </button>
        </div>
    </div>
</div>

<style>
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
.animate-fade-in {
    animation: fadeIn 0.2s ease-out forwards;
}
</style>

<script>
function openApproveModal() {
    const modal = document.getElementById('confirmModal');
    const container = document.getElementById('modalContainer');
    modal.classList.remove('hidden');
    // Trigger animations
    setTimeout(() => {
        container.classList.remove('scale-95', 'opacity-0');
        container.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeApproveModal() {
    const modal = document.getElementById('confirmModal');
    const container = document.getElementById('modalContainer');
    container.classList.add('scale-95', 'opacity-0');
    container.classList.remove('scale-100', 'opacity-100');
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 200);
}

function submitApproveForm() {
    document.getElementById('approveForm').submit();
}
</script>
@endsection
