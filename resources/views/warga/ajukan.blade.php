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

            @if($jenisSurat->kode === 'IKH')
                <input type="hidden" name="keperluan" id="hidden_keperluan">
                <div class="space-y-4 bg-blue-50/50 border border-blue-100 rounded-xl p-5">
                    <p class="text-sm font-semibold text-blue-800">Detail Acara Khajatan</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Jenis Acara / Khajatan <span class="text-red-500">*</span></label>
                            <input type="text" id="hj_acara" class="form-input" placeholder="Contoh: Tasyakuran Khitan / Pernikahan" required>
                        </div>
                        <div>
                            <label class="form-label">Hiburan <span class="text-red-500">*</span></label>
                            <input type="text" id="hj_hiburan" class="form-input" placeholder="Contoh: Organ Tunggal atau -" required>
                        </div>
                        <div>
                            <label class="form-label">Hari Acara <span class="text-red-500">*</span></label>
                            <input type="text" id="hj_hari" class="form-input" placeholder="Contoh: Sabtu - Minggu" required>
                        </div>
                        <div>
                            <label class="form-label">Tanggal Acara <span class="text-red-500">*</span></label>
                            <input type="text" id="hj_tanggal" class="form-input" placeholder="Contoh: 20 - 21 September 2025" required>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Tempat Acara <span class="text-red-500">*</span></label>
                        <input type="text" id="hj_tempat" class="form-input" placeholder="Contoh: Rumah Kediaman RT 03 RW 01 Desa Ketileng" required>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const hiddenInput = document.getElementById('hidden_keperluan');
                        const hjAcara = document.getElementById('hj_acara');
                        const hjHiburan = document.getElementById('hj_hiburan');
                        const hjHari = document.getElementById('hj_hari');
                        const hjTanggal = document.getElementById('hj_tanggal');
                        const hjTempat = document.getElementById('hj_tempat');

                        function updateHidden() {
                            const data = {
                                acara: hjAcara.value.trim(),
                                hiburan: hjHiburan.value.trim(),
                                hari: hjHari.value.trim(),
                                tanggal: hjTanggal.value.trim(),
                                tempat: hjTempat.value.trim()
                            };
                            hiddenInput.value = JSON.stringify(data);
                        }

                        hjAcara.addEventListener('input', updateHidden);
                        hjHiburan.addEventListener('input', updateHidden);
                        hjHari.addEventListener('input', updateHidden);
                        hjTanggal.addEventListener('input', updateHidden);
                        hjTempat.addEventListener('input', updateHidden);
                        
                        // Initial trigger
                        updateHidden();
                    });
                </script>
            @else
                {{-- Keperluan --}}
                <div>
                    <label class="form-label">Keperluan / Tujuan Pengajuan <span class="text-red-500">*</span></label>
                    <textarea name="keperluan" rows="3"
                              class="form-input resize-none @error('keperluan') border-red-400 @enderror"
                              placeholder="Contoh: Untuk keperluan melamar pekerjaan di PT. ..."
                              required>{{ old('keperluan') }}</textarea>
                    @error('keperluan')<p class="form-error">{{ $message }}</p>@enderror
                </div>
            @endif

            {{-- Upload KTP --}}
            <div>
                <label class="form-label">Upload Foto/Scan KTP <span class="text-red-500">*</span></label>
                <div class="border-2 border-dashed border-slate-200 rounded-xl p-6 text-center hover:border-blue-400 transition-colors relative">
                    <input type="file" name="file_ktp" id="file_ktp" accept=".jpg,.jpeg,.png,.pdf" class="hidden"
                           onchange="previewFile(this, 'ktp-label', 'ktp-preview', 'ktp-preview-container')">
                    <label for="file_ktp" class="cursor-pointer block">
                        <div id="ktp-preview-container" class="hidden mb-3 mx-auto max-w-[200px] border rounded-lg overflow-hidden shadow-sm bg-slate-50">
                            <img id="ktp-preview" class="w-full h-auto object-cover max-h-[120px] mx-auto" src="" alt="Preview KTP">
                        </div>
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
                <div class="border-2 border-dashed border-slate-200 rounded-xl p-6 text-center hover:border-blue-400 transition-colors relative">
                    <input type="file" name="file_kk" id="file_kk" accept=".jpg,.jpeg,.png,.pdf" class="hidden"
                           onchange="previewFile(this, 'kk-label', 'kk-preview', 'kk-preview-container')">
                    <label for="file_kk" class="cursor-pointer block">
                        <div id="kk-preview-container" class="hidden mb-3 mx-auto max-w-[200px] border rounded-lg overflow-hidden shadow-sm bg-slate-50">
                            <img id="kk-preview" class="w-full h-auto object-cover max-h-[120px] mx-auto" src="" alt="Preview KK">
                        </div>
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
function previewFile(input, labelId, imgId, containerId) {
    const label = document.getElementById(labelId);
    const img = document.getElementById(imgId);
    const container = document.getElementById(containerId);
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        label.textContent = '✓ ' + file.name;
        label.classList.add('text-blue-600', 'font-medium');
        
        // Cek jika file adalah gambar (JPG, JPEG, PNG)
        if (file.type.match('image.*')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                container.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            // Jika PDF, sembunyikan gambar preview tapi simpan nama file terpilih
            container.classList.add('hidden');
            img.src = '';
        }
    } else {
        container.classList.add('hidden');
        img.src = '';
    }
}
</script>
@endsection
