@extends('layouts.admin')
@section('title', 'Edit Data Penduduk')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center gap-2 text-sm text-slate-400 mb-6">
        <a href="{{ route('admin.penduduk.index') }}" class="hover:text-slate-600">Data Penduduk</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-700 font-medium">Edit Data</span>
    </div>

    <div class="card">
        <div class="mb-6 border-b border-slate-100 pb-4">
            <h1 class="text-xl font-bold text-slate-900">Edit Data Penduduk</h1>
            <p class="text-slate-500 text-sm mt-1">Perbarui informasi kependudukan untuk {{ $penduduk->nama }}.</p>
        </div>

        <form action="{{ route('admin.penduduk.update', $penduduk) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- NIK & KK --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="form-label">Nomor Induk Kependudukan (NIK) <span class="text-red-500">*</span></label>
                    <input type="text" name="nik" value="{{ old('nik', $penduduk->nik) }}" class="form-input" maxlength="16" required>
                    @error('nik') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Nomor Kartu Keluarga (KK) <span class="text-red-500">*</span></label>
                    <input type="text" name="no_kk" value="{{ old('no_kk', $penduduk->no_kk) }}" class="form-input" maxlength="16" required>
                    @error('no_kk') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Nama Lengkap --}}
            <div>
                <label class="form-label">Nama Lengkap Sesuai KTP <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $penduduk->nama) }}" class="form-input" required>
                @error('nama') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            {{-- TTL & JK --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="form-label">Tempat Lahir <span class="text-red-500">*</span></label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $penduduk->tempat_lahir) }}" class="form-input" required>
                    @error('tempat_lahir') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $penduduk->tanggal_lahir->format('Y-m-d')) }}" class="form-input" required>
                    @error('tanggal_lahir') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <select name="jenis_kelamin" class="form-input" required>
                        <option value="Laki-laki" {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Alamat --}}
            <div>
                <label class="form-label">Alamat Lengkap <span class="text-red-500">*</span></label>
                <textarea name="alamat" rows="2" class="form-input resize-none" required>{{ old('alamat', $penduduk->alamat) }}</textarea>
                @error('alamat') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div>
                    <label class="form-label">RT</label>
                    <input type="text" name="rt" value="{{ old('rt', $penduduk->rt) }}" class="form-input" maxlength="3">
                </div>
                <div>
                    <label class="form-label">RW</label>
                    <input type="text" name="rw" value="{{ old('rw', $penduduk->rw) }}" class="form-input" maxlength="3">
                </div>
                <div>
                    <label class="form-label">Desa <span class="text-red-500">*</span></label>
                    <input type="text" name="desa" value="{{ old('desa', $penduduk->desa) }}" class="form-input" required>
                    @error('desa') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Kecamatan <span class="text-red-500">*</span></label>
                    <input type="text" name="kecamatan" value="{{ old('kecamatan', $penduduk->kecamatan) }}" class="form-input" required>
                    @error('kecamatan') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Data Tambahan --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="form-label">Agama</label>
                    <input type="text" name="agama" value="{{ old('agama', $penduduk->agama) }}" class="form-input">
                </div>
                <div>
                    <label class="form-label">Pekerjaan</label>
                    <input type="text" name="pekerjaan" value="{{ old('pekerjaan', $penduduk->pekerjaan) }}" class="form-input">
                </div>
                <div>
                    <label class="form-label">Status Perkawinan <span class="text-red-500">*</span></label>
                    <select name="status_perkawinan" class="form-input" required>
                        <option value="Belum Kawin" {{ old('status_perkawinan', $penduduk->status_perkawinan) == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                        <option value="Kawin" {{ old('status_perkawinan', $penduduk->status_perkawinan) == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                        <option value="Cerai Hidup" {{ old('status_perkawinan', $penduduk->status_perkawinan) == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                        <option value="Cerai Mati" {{ old('status_perkawinan', $penduduk->status_perkawinan) == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Kewarganegaraan <span class="text-red-500">*</span></label>
                    <input type="text" name="kewarganegaraan" value="{{ old('kewarganegaraan', $penduduk->kewarganegaraan) }}" class="form-input" required>
                    @error('kewarganegaraan') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex gap-3">
                <a href="{{ route('admin.penduduk.index') }}" class="btn-outline">Batal</a>
                <button type="submit" class="btn-primary">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
