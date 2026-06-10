@extends('layouts.kades')
@section('title', 'Profil Kepala Desa')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-slate-900">Profil Kepala Desa</h1>
    <p class="text-slate-500 mt-1">Kelola data informasi akun Anda dan pengaturan Tanda Tangan Elektronik.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    {{-- ── COLUMN 1: TTE & STATS ── --}}
    <div class="space-y-6 lg:col-span-1">
        {{-- Card Info TTE --}}
        <div class="card bg-slate-900 text-white relative overflow-hidden">
            {{-- Decorative Glow --}}
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-blue-500/10 rounded-full blur-2xl"></div>
            
            <div class="relative z-10 flex flex-col items-center text-center py-4">
                <div class="w-20 h-20 bg-slate-800 rounded-full flex items-center justify-center text-3xl font-extrabold border-2 border-blue-500/40 mb-4 shadow-inner">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h3 class="text-lg font-bold">{{ $user->name }}</h3>
                <p class="text-blue-400 text-xs font-semibold tracking-wider uppercase mt-1">Kepala Desa Ketileng</p>
                
                {{-- Status Badge TTE --}}
                <div class="mt-5 px-3 py-1.5 bg-blue-500/15 border border-blue-500/30 text-blue-400 text-xs font-bold rounded-full flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-blue-400 animate-ping"></span>
                    <span class="w-2 h-2 rounded-full bg-blue-400 absolute"></span>
                    Tanda Tangan Elektronik Aktif
                </div>
            </div>

            <div class="border-t border-slate-800 mt-6 pt-5 space-y-3.5 text-xs text-slate-400">
                <div class="flex justify-between">
                    <span>Metode Tanda Tangan</span>
                    <span class="font-semibold text-white">QR Code (E-Sign)</span>
                </div>
                <div class="flex justify-between">
                    <span>Sertifikasi Sistem</span>
                    <span class="font-semibold text-blue-400">Terverifikasi (Internal)</span>
                </div>
                <div class="flex justify-between">
                    <span>Wewenang</span>
                    <span class="font-semibold text-white">Persetujuan & Penerbitan</span>
                </div>
            </div>
        </div>

        {{-- Card Ringkasan Aktivitas --}}
        <div class="card">
            <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">Aktivitas Tanda Tangan</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-medium">Telah Ditandatangani</p>
                            <p class="text-lg font-bold text-slate-800 mt-0.5">{{ $stats['total_approved'] }} Berkas</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-orange-100 text-orange-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-medium">Antrean Menunggu</p>
                            <p class="text-lg font-bold text-slate-800 mt-0.5">{{ $stats['pending_queue'] }} Berkas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── COLUMN 2 & 3: FORM UPDATE PROFIL ── --}}
    <div class="lg:col-span-2">
        <div class="card">
            <h3 class="text-lg font-bold text-slate-800 border-b border-slate-100 pb-3 mb-6">Pengaturan Informasi Akun</h3>

            <form method="POST" action="{{ route('kades.profile.update') }}" class="space-y-6">
                @csrf
                
                {{-- Data Profil --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" value="{{ $user->name }}" class="form-input bg-slate-50 border-slate-200 text-slate-400 cursor-not-allowed" readonly disabled>
                        <p class="text-xs text-slate-400 mt-1.5">Nama dinonaktifkan dari pengeditan (kontak admin untuk penyesuaian gelar).</p>
                    </div>
                    <div>
                        <label class="form-label" for="email">Alamat Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-input @error('email') border-red-500 @enderror" required>
                        @error('email') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label" for="phone">Nomor Telepon</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" class="form-input @error('phone') border-red-500 @enderror">
                        @error('phone') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label" for="address">Alamat Kantor / Dinas</label>
                        <input type="text" name="address" id="address" value="{{ old('address', $user->address) }}" class="form-input @error('address') border-red-500 @enderror">
                        @error('address') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Ubah Password --}}
                <div class="border-t border-slate-100 pt-6 mt-6">
                    <h4 class="text-sm font-bold text-slate-700 uppercase tracking-wider mb-4">Ganti Kata Sandi (Opsional)</h4>
                    <p class="text-xs text-slate-500 mb-4">Kosongkan kolom di bawah jika Anda tidak berniat mengubah password akun.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="form-label" for="password">Kata Sandi Baru</label>
                            <input type="password" name="password" id="password" class="form-input @error('password') border-red-500 @enderror" placeholder="Minimal 6 karakter">
                            @error('password') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label" for="password_confirmation">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" placeholder="Ulangi kata sandi baru">
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="border-t border-slate-100 pt-6 flex items-center justify-end">
                    <button type="submit" class="btn-primary px-6">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
