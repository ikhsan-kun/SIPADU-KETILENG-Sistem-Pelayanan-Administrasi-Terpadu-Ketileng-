@extends('layouts.admin')
@section('title', 'Tambah Data Penduduk')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center gap-2 text-sm text-slate-400 mb-6">
        <a href="{{ route('admin.penduduk.index') }}" class="hover:text-slate-600">Data Penduduk</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-700 font-medium">Tambah Data</span>
    </div>

    <div class="card">
        <div class="mb-6 border-b border-slate-100 pb-4">
            <h1 class="text-xl font-bold text-slate-900">Tambah Data Penduduk</h1>
            <p class="text-slate-500 text-sm mt-1">Lengkapi form berikut untuk menambahkan data penduduk baru.</p>
        </div>

        <form action="{{ route('admin.penduduk.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- NIK & KK --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="form-label">Nomor Induk Kependudukan (NIK) <span class="text-red-500">*</span></label>
                    <input type="text" name="nik" value="{{ old('nik') }}" class="form-input" maxlength="16" required placeholder="16 digit angka NIK">
                    @error('nik') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Nomor Kartu Keluarga (KK) <span class="text-red-500">*</span></label>
                    <input type="text" name="no_kk" value="{{ old('no_kk') }}" class="form-input" maxlength="16" required placeholder="16 digit angka KK">
                    @error('no_kk') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Nama Lengkap --}}
            <div>
                <label class="form-label">Nama Lengkap Sesuai KTP <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama') }}" class="form-input" required placeholder="Masukkan nama lengkap">
                @error('nama') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            {{-- TTL & JK --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="form-label">Tempat Lahir <span class="text-red-500">*</span></label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="form-input" required placeholder="Tempat Lahir">
                    @error('tempat_lahir') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="form-input" required>
                    @error('tanggal_lahir') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <select name="jenis_kelamin" class="form-input" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Alamat --}}
            <div>
                <label class="form-label">Alamat Lengkap <span class="text-red-500">*</span></label>
                <textarea name="alamat" rows="2" class="form-input resize-none" required placeholder="Nama jalan, gang, atau blok">{{ old('alamat') }}</textarea>
                @error('alamat') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div>
                    <label class="form-label">RT</label>
                    <input type="text" name="rt" value="{{ old('rt') }}" class="form-input" placeholder="001" maxlength="3">
                </div>
                <div>
                    <label class="form-label">RW</label>
                    <input type="text" name="rw" value="{{ old('rw') }}" class="form-input" placeholder="001" maxlength="3">
                </div>
                <div>
                    <label class="form-label">Desa <span class="text-red-500">*</span></label>
                    <input type="text" name="desa" value="{{ old('desa', 'Ketileng') }}" class="form-input" required>
                    @error('desa') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Kecamatan <span class="text-red-500">*</span></label>
                    <input type="text" name="kecamatan" value="{{ old('kecamatan', 'Kramat') }}" class="form-input" required>
                    @error('kecamatan') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Data Tambahan --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="form-label">Agama</label>
                    <input type="text" name="agama" value="{{ old('agama', 'Islam') }}" class="form-input">
                </div>
                <div>
                    <label class="form-label">Pekerjaan</label>
                    <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}" class="form-input" placeholder="Wiraswasta, Pegawai, dll">
                </div>
                <div>
                    <label class="form-label">Status Perkawinan <span class="text-red-500">*</span></label>
                    <select name="status_perkawinan" class="form-input" required>
                        <option value="Belum Kawin" {{ old('status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                        <option value="Kawin" {{ old('status_perkawinan') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                        <option value="Cerai Hidup" {{ old('status_perkawinan') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                        <option value="Cerai Mati" {{ old('status_perkawinan') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Kewarganegaraan <span class="text-red-500">*</span></label>
                    <input type="text" name="kewarganegaraan" value="{{ old('kewarganegaraan', 'WNI') }}" class="form-input" required placeholder="WNI / WNA">
                    @error('kewarganegaraan') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex gap-3">
                <a href="{{ route('admin.penduduk.index') }}" class="btn-outline">Batal</a>
                <button type="submit" class="btn-primary">
                    Simpan Data Penduduk
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
