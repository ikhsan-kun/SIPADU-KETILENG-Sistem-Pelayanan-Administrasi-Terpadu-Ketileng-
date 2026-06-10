<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Penduduk;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function showForm()
    {
        return view('auth.forgot-password');
    }

    public function verifyNikKk(Request $request)
    {
        $request->validate([
            'nik' => ['required', 'string', 'size:16'],
            'no_kk' => ['required', 'string', 'size:16'],
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.size' => 'NIK harus tepat 16 karakter.',
            'no_kk.required' => 'Nomor KK wajib diisi.',
            'no_kk.size' => 'Nomor KK harus tepat 16 karakter.',
        ]);

        // Cek data di tabel penduduk
        $penduduk = Penduduk::where('nik', $request->nik)
            ->where('no_kk', $request->no_kk)
            ->first();

        if (!$penduduk) {
            return back()->withErrors([
                'nik' => 'Kombinasi NIK dan Nomor KK tidak cocok dengan data kependudukan.',
            ])->withInput();
        }

        // Cek apakah user sudah terdaftar di sistem auth
        $user = User::where('nik', $request->nik)->first();

        if (!$user) {
            return back()->withErrors([
                'nik' => 'Akun dengan NIK ini belum terdaftar di aplikasi. Silakan mendaftar terlebih dahulu.',
            ])->withInput();
        }

        // Simpan id user di session untuk validasi di halaman reset
        session(['reset_user_id' => $user->id]);

        return redirect()->route('password.reset.form');
    }

    public function showResetForm()
    {
        if (!session()->has('reset_user_id')) {
            return redirect()->route('password.request')
                ->withErrors(['nik' => 'Silakan verifikasi NIK dan Nomor KK Anda terlebih dahulu.']);
        }

        return view('auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        if (!session()->has('reset_user_id')) {
            return redirect()->route('password.request')
                ->withErrors(['nik' => 'Sesi verifikasi Anda telah berakhir. Silakan ulangi.']);
        }

        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $userId = session('reset_user_id');
        $user = User::findOrFail($userId);

        $user->password = Hash::make($request->password);
        $user->save();

        // Bersihkan session
        session()->forget('reset_user_id');

        return redirect()->route('login')->with('success', 'Kata sandi Anda berhasil diperbarui. Silakan masuk menggunakan kata sandi baru Anda.');
    }
}
