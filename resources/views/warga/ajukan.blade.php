@extends('layouts.warga')
@section('title', 'Ajukan ' . $jenisSurat->nama)

@section('content')
<div class="max-w-2xl mx-auto">
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-slate-400 mb-6">
        <a href="{{ route('warga.pilih_surat') }}" class="hover:text-slate-600">Ajukan Surat</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-700 font-medium">{{ $jenisSurat->nama }}</span>
    </div>

    <div class="card">
        <div class="mb-6">
            <h1 class="text-xl font-bold text-slate-900">{{ $jenisSurat->nama }}</h1>
            <p class="text-slate-500 text-sm mt-1">{{ $jenisSurat->deskripsi }}</p>
        </div>

        @if(!$penduduk)
        <div class="alert-info mb-6">
            <p class="font-semibold">Data kependudukan tidak ditemukan</p>
            <p class="text-sm mt-1">NIK Anda ({{ auth()->user()->nik }}) belum terdaftar di database penduduk. Silakan hubungi admin desa.</p>
        </div>
        @else

        {{-- Data Pemohon Preview --}}
        <div class="bg-slate-50 rounded-xl p-4 mb-6">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Data Pemohon</p>
            <div class="grid grid-cols-2 gap-3 text-sm">
                <div>
                    <p class="text-slate-400">Nama Lengkap</p>
                    <p class="font-semibold text-slate-800">{{ $penduduk->nama }}</p>
                </div>
                <div>
                    <p class="text-slate-400">NIK</p>
                    <p class="font-semibold text-slate-800">{{ $penduduk->nik }}</p>
                </div>
                <div>
                    <p class="text-slate-400">Alamat</p>
                    <p class="font-semibold text-slate-800">{{ $penduduk->alamat_lengkap }}</p>
                </div>
                <div>
                    <p class="text-slate-400">Pekerjaan</p>
                    <p class="font-semibold text-slate-800">{{ $penduduk->pekerjaan ?? '-' }}</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('warga.ajukan.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <input type="hidden" name="jenis_surat_id" value="{{ $jenisSurat->id }}">

            {{-- Keperluan --}}
            <div>
                <label class="form-label">Keperluan / Tujuan Pengajuan <span class="text-red-500">*</span></label>
                <textarea name="keperluan" rows="3"
                          class="form-input resize-none @error('keperluan') border-red-400 @enderror"
                          placeholder="Contoh: Untuk keperluan melamar pekerjaan di PT. ..."
                          required>{{ old('keperluan') }}</textarea>
                @error('keperluan')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            {{-- Upload KTP --}}
            <div>
                <label class="form-label">Upload Foto/Scan KTP <span class="text-red-500">*</span></label>
                <div class="border-2 border-dashed border-slate-200 rounded-xl p-6 text-center hover:border-emerald-400 transition-colors">
                    <input type="file" name="file_ktp" id="file_ktp" accept=".jpg,.jpeg,.png,.pdf" class="hidden"
                           onchange="showFileName(this, 'ktp-label')">
                    <label for="file_ktp" class="cursor-pointer">
                        <svg class="w-8 h-8 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                        <p id="ktp-label" class="text-sm text-slate-500">Klik untuk pilih file KTP</p>
                        <p class="text-xs text-slate-400 mt-1">JPG, PNG, PDF – Maks. 2 MB</p>
                    </label>
                </div>
                @error('file_ktp')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            {{-- Upload KK --}}
            <div>
                <label class="form-label">Upload Foto/Scan Kartu Keluarga (KK) <span class="text-red-500">*</span></label>
                <div class="border-2 border-dashed border-slate-200 rounded-xl p-6 text-center hover:border-emerald-400 transition-colors">
                    <input type="file" name="file_kk" id="file_kk" accept=".jpg,.jpeg,.png,.pdf" class="hidden"
                           onchange="showFileName(this, 'kk-label')">
                    <label for="file_kk" class="cursor-pointer">
                        <svg class="w-8 h-8 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                        <p id="kk-label" class="text-sm text-slate-500">Klik untuk pilih file KK</p>
                        <p class="text-xs text-slate-400 mt-1">JPG, PNG, PDF – Maks. 2 MB</p>
                    </label>
                </div>
                @error('file_kk')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('warga.pilih_surat') }}" class="btn-outline">Batal</a>
                <button type="submit" class="btn-primary flex-1 justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    Kirim Pengajuan
                </button>
            </div>
        </form>
        @endif
    </div>
</div>

<script>
function showFileName(input, labelId) {
    const label = document.getElementById(labelId);
    if (input.files && input.files[0]) {
        label.textContent = '✓ ' + input.files[0].name;
        label.classList.add('text-emerald-600', 'font-medium');
    }
}
</script>
@endsection
