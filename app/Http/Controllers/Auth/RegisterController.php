<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Tampilkan form registrasi warga.
     */
    public function showRegistrationForm()
    {
        if (Auth::check()) {
            return redirect()->route('warga.dashboard');
        }

        return view('auth.register');
    }

    /**
     * Proses registrasi warga.
     *
     * Alur:
     * 1. Validasi input NIK, No KK, Tanggal Lahir, dan Password
     * 2. Cek apakah NIK ada di tabel penduduk (data yang dikelola admin)
     * 3. Cocokkan No KK dan Tanggal Lahir sebagai verifikasi identitas
     * 4. Cek apakah NIK sudah terdaftar sebagai akun user (mencegah duplikat)
     * 5. Buat akun user baru dengan data dari tabel penduduk
     */
    public function register(Request $request)
    {
        $request->validate([
            'nik'            => ['required', 'string', 'size:16', 'regex:/^[0-9]+$/'],
            'no_kk'          => ['required', 'string', 'size:16', 'regex:/^[0-9]+$/'],
            'tanggal_lahir'  => ['required', 'date'],
            'password'       => ['required', 'string', 'min:6', 'confirmed'],
            'phone'          => ['nullable', 'string', 'max:15'],
        ], [
            'nik.required'           => 'NIK wajib diisi.',
            'nik.size'               => 'NIK harus 16 digit.',
            'nik.regex'              => 'NIK hanya boleh berisi angka.',
            'no_kk.required'         => 'No. KK wajib diisi.',
            'no_kk.size'             => 'No. KK harus 16 digit.',
            'no_kk.regex'            => 'No. KK hanya boleh berisi angka.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date'     => 'Format tanggal lahir tidak valid.',
            'password.required'      => 'Kata sandi wajib diisi.',
            'password.min'           => 'Kata sandi minimal 6 karakter.',
            'password.confirmed'     => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        // 1. Cari data penduduk berdasarkan NIK
        $penduduk = Penduduk::where('nik', $request->nik)->first();

        if (!$penduduk) {
            return back()->withErrors([
                'nik' => 'NIK tidak ditemukan dalam data kependudukan desa. Silakan hubungi Admin Desa untuk memastikan data Anda sudah terdaftar.',
            ])->withInput($request->except('password', 'password_confirmation'));
        }

        // 2. Verifikasi No KK
        if ($penduduk->no_kk !== $request->no_kk) {
            return back()->withErrors([
                'no_kk' => 'No. KK tidak sesuai dengan data kependudukan. Pastikan Anda memasukkan No. KK yang benar.',
            ])->withInput($request->except('password', 'password_confirmation'));
        }

        // 3. Verifikasi Tanggal Lahir
        if ($penduduk->tanggal_lahir->format('Y-m-d') !== $request->tanggal_lahir) {
            return back()->withErrors([
                'tanggal_lahir' => 'Tanggal lahir tidak sesuai dengan data kependudukan.',
            ])->withInput($request->except('password', 'password_confirmation'));
        }

        // 4. Cek apakah NIK sudah punya akun
        $existingUser = User::where('nik', $request->nik)->first();

        if ($existingUser) {
            return back()->withErrors([
                'nik' => 'NIK ini sudah terdaftar sebagai akun. Silakan langsung login atau hubungi Admin Desa jika Anda lupa kata sandi.',
            ])->withInput($request->except('password', 'password_confirmation'));
        }

        // 5. Buat akun user baru dari data penduduk
        $user = User::create([
            'name'     => $penduduk->nama,
            'nik'      => $penduduk->nik,
            'password' => Hash::make($request->password),
            'role'     => 'warga',
            'phone'    => $request->phone,
            'address'  => $penduduk->alamat_lengkap,
        ]);

        // 6. Auto-login setelah registrasi
        Auth::login($user);

        return redirect()->route('warga.dashboard')
            ->with('success', 'Selamat! Akun Anda berhasil dibuat. Selamat datang, ' . $penduduk->nama . '!')
            ->with('just_registered', true);
    }
}
