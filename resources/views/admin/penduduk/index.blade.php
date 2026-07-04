@extends('layouts.admin')
@section('title', 'Data Penduduk')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Data Penduduk</h1>
        <p class="text-slate-500 text-sm mt-1">Kelola data master penduduk Desa Ketileng.</p>
    </div>
    <div class="flex items-center gap-2">
        {{-- Tombol Import Excel --}}
        <button onclick="document.getElementById('importModal').classList.remove('hidden')"
                class="btn-outline text-sm py-2 px-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
            </svg>
            Import Excel
        </button>
        {{-- Tombol Tambah Data --}}
        <a href="{{ route('admin.penduduk.create') }}" class="btn-primary text-sm py-2 px-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Data
        </a>
    </div>
</div>

{{-- Alert Success --}}
@if(session('success'))
<div class="alert-success mb-4 flex items-center gap-2">
    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
    </svg>
    {{ session('success') }}
</div>
@endif

{{-- Alert Error --}}
@if(session('error'))
<div class="alert-error mb-4 flex items-center gap-2">
    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
    </svg>
    {{ session('error') }}
</div>
@endif

@if($errors->has('file'))
<div class="alert-error mb-4 flex items-center gap-2">
    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
    </svg>
    {{ $errors->first('file') }}
</div>
@endif

<livewire:penduduk-table />

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
{{-- MODAL IMPORT EXCEL                                                       --}}
{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<div id="importModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"
         onclick="document.getElementById('importModal').classList.add('hidden')"></div>

    {{-- Modal Content --}}
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden animate-modal">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-5">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-bold text-lg">Import Data Penduduk</h3>
                        <p class="text-blue-100 text-xs">Upload file Excel (.xlsx / .xls)</p>
                    </div>
                </div>
                <button onclick="document.getElementById('importModal').classList.add('hidden')"
                        class="text-white/70 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Body --}}
        <form action="{{ route('admin.penduduk.import') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf

            {{-- Info Box --}}
            <div class="bg-blue-50 border border-blue-200 rounded-xl px-4 py-3 flex gap-3">
                <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="text-blue-700 text-xs leading-relaxed">
                    <p class="font-semibold mb-1">Petunjuk Import:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        <li>Download template terlebih dahulu agar format kolom sesuai</li>
                        <li>Baris pertama (header) <b>tidak boleh</b> diubah</li>
                        <li>NIK yang sudah ada akan otomatis dilewati</li>
                        <li>Maksimal ukuran file: <b>5MB</b></li>
                    </ul>
                </div>
            </div>

            {{-- Download Template --}}
            <a href="{{ route('admin.penduduk.template') }}"
               class="flex items-center gap-3 p-3 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl transition-colors group">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-blue-200 transition-colors">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-700 group-hover:text-blue-700 transition-colors">Download Template Excel</p>
                    <p class="text-xs text-slate-400">template_import_penduduk.xlsx</p>
                </div>
                <svg class="w-4 h-4 text-slate-400 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
            </a>

            {{-- Upload Area --}}
            <div>
                <label class="form-label">Pilih File Excel</label>
                <div class="relative">
                    <input type="file" name="file" id="importFile" accept=".xlsx,.xls"
                           class="hidden" onchange="updateFileName(this)" required>
                    <label for="importFile"
                           class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-slate-300 rounded-xl cursor-pointer hover:border-blue-400 hover:bg-blue-50/50 transition-all duration-200"
                           id="dropZone">
                        <div class="flex flex-col items-center" id="uploadPlaceholder">
                            <svg class="w-8 h-8 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <p class="text-sm text-slate-500 font-medium">Klik untuk pilih file</p>
                            <p class="text-xs text-slate-400 mt-1">Format: .xlsx atau .xls (maks. 5MB)</p>
                        </div>
                        <div class="flex items-center gap-3 hidden" id="fileSelected">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-700" id="selectedFileName">-</p>
                                <p class="text-xs text-slate-400" id="selectedFileSize">-</p>
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="button"
                        onclick="document.getElementById('importModal').classList.add('hidden')"
                        class="flex-1 py-2.5 px-4 border border-slate-300 text-slate-600 rounded-xl font-semibold text-sm hover:bg-slate-50 transition-colors">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 py-2.5 px-4 bg-blue-500 hover:bg-blue-600 text-white rounded-xl font-semibold text-sm transition-colors flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    Import Data
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    @keyframes modalIn {
        from { opacity: 0; transform: scale(0.95) translateY(10px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }
    .animate-modal {
        animation: modalIn 0.2s ease-out;
    }
</style>

<script>
function updateFileName(input) {
    const placeholder = document.getElementById('uploadPlaceholder');
    const selected = document.getElementById('fileSelected');
    const nameEl = document.getElementById('selectedFileName');
    const sizeEl = document.getElementById('selectedFileSize');

    if (input.files && input.files[0]) {
        const file = input.files[0];
        nameEl.textContent = file.name;
        sizeEl.textContent = (file.size / 1024).toFixed(1) + ' KB';
        placeholder.classList.add('hidden');
        selected.classList.remove('hidden');
    } else {
        placeholder.classList.remove('hidden');
        selected.classList.add('hidden');
    }
}

// Auto-open modal if there was a file error
@if($errors->has('file'))
    document.getElementById('importModal').classList.remove('hidden');
@endif
</script>
@endsection
