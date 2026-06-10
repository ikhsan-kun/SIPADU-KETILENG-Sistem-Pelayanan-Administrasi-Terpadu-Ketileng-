<?php

namespace Database\Seeders;

use App\Models\JenisSurat;
use App\Models\Penduduk;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── USERS ──────────────────────────────────────────────────
        User::create([
            'name'     => 'Admin Desa',
            'nik'      => '3328010101800001',
            'email'    => 'admin@desaKetileng.id',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
            'phone'    => '081234567890',
            'address'  => 'Kantor Desa Ketileng',
        ]);

        User::create([
            'name'     => 'MASRUDIYANTO AM.d',
            'nik'      => ' ',
            'email'    => 'kades@desaKetileng.id',
            'password' => Hash::make('kades123'),
            'role'     => 'kades',
            'phone'    => '081234567891',
            'address'  => 'Desa Ketileng, Kec. Kramat, Kab. Tegal',
        ]);

        // $warga1 = User::create([
        //     'name'     => 'Budi Santoso',
        //     'nik'      => '3328010101900001',
        //     'password' => Hash::make('warga123'),
        //     'role'     => 'warga',
        //     'phone'    => '081234567892',
        // ]);

        // $warga2 = User::create([
        //     'name'     => 'Siti Aminah',
        //     'nik'      => '3328014504850002',
        //     'password' => Hash::make('warga123'),
        //     'role'     => 'warga',
        //     'phone'    => '081234567893',
        // ]);

        // $warga3 = User::create([
        //     'name'     => 'Ahmad Fauzi',
        //     'nik'      => '3328011205780003',
        //     'password' => Hash::make('warga123'),
        //     'role'     => 'warga',
        //     'phone'    => '081234567894',
        // ]);

        // ── PENDUDUK ───────────────────────────────────────────────
        Penduduk::create([
            'nik'              => '3328010101900001',
            'no_kk'            => '3328011234567890',
            'nama'             => 'Budi Santoso',
            'tempat_lahir'     => 'Tegal',
            'tanggal_lahir'    => '1990-01-01',
            'jenis_kelamin'    => 'Laki-laki',
            'alamat'           => 'Jl. Raya Ketileng No. 10',
            'rt'               => '001',
            'rw'               => '002',
            'desa'             => 'Ketileng',
            'kecamatan'        => 'Kramat',
            'agama'            => 'Islam',
            'pekerjaan'        => 'Wiraswasta',
            'status_perkawinan'=> 'Kawin',
            'kewarganegaraan'  => 'WNI',
        ]);

        Penduduk::create([
            'nik'              => '3328014504850002',
            'no_kk'            => '3328019876543210',
            'nama'             => 'Siti Aminah',
            'tempat_lahir'     => 'Tegal',
            'tanggal_lahir'    => '1985-04-05',
            'jenis_kelamin'    => 'Perempuan',
            'alamat'           => 'Jl. Merdeka No. 5',
            'rt'               => '003',
            'rw'               => '001',
            'desa'             => 'Ketileng',
            'kecamatan'        => 'Kramat',
            'agama'            => 'Islam',
            'pekerjaan'        => 'Ibu Rumah Tangga',
            'status_perkawinan'=> 'Kawin',
            'kewarganegaraan'  => 'WNI',
        ]);

        Penduduk::create([
            'nik'              => '3328011205780003',
            'no_kk'            => '3328015544332211',
            'nama'             => 'Ahmad Fauzi',
            'tempat_lahir'     => 'Brebes',
            'tanggal_lahir'    => '1978-12-05',
            'jenis_kelamin'    => 'Laki-laki',
            'alamat'           => 'Jl. Pahlawan No. 22',
            'rt'               => '002',
            'rw'               => '003',
            'desa'             => 'Ketileng',
            'kecamatan'        => 'Kramat',
            'agama'            => 'Islam',
            'pekerjaan'        => 'Petani',
            'status_perkawinan'=> 'Kawin',
            'kewarganegaraan'  => 'WNI',
        ]);

        // Extra penduduk (tanpa akun warga, dikelola admin)
        Penduduk::create([
            'nik'              => '3328016605920004',
            'no_kk'            => '3328016605920010',
            'nama'             => 'Rina Melati',
            'tempat_lahir'     => 'Tegal',
            'tanggal_lahir'    => '1992-06-06',
            'jenis_kelamin'    => 'Perempuan',
            'alamat'           => 'Jl. Flamboyan No. 3',
            'rt'               => '004',
            'rw'               => '002',
            'desa'             => 'Ketileng',
            'kecamatan'        => 'Kramat',
            'agama'            => 'Islam',
            'pekerjaan'        => 'Pedagang',
            'status_perkawinan'=> 'Kawin',
            'kewarganegaraan'  => 'WNI',
        ]);

        // ── JENIS SURAT ────────────────────────────────────────────
        JenisSurat::firstOrCreate(
            ['kode' => 'SKD'],
            [
                'nama'        => 'Surat Keterangan Domisili',
                'deskripsi'   => 'Keterangan tempat tinggal saat ini.',
                'persyaratan' => ['ktp', 'kk'],
                'aktif'       => true,
            ]
        );

        JenisSurat::firstOrCreate(
            ['kode' => 'SKCK'],
            [
                'nama'        => 'Surat Pengantar SKCK',
                'deskripsi'   => 'Surat pengantar untuk pembuatan SKCK di kepolisian.',
                'persyaratan' => ['ktp', 'kk'],
                'aktif'       => true,
            ]
        );

        JenisSurat::firstOrCreate(
            ['kode' => 'SKTM'],
            [
                'nama'        => 'Surat Keterangan Tidak Mampu',
                'deskripsi'   => 'Surat keterangan tidak mampu secara ekonomi.',
                'persyaratan' => ['ktp', 'kk'],
                'aktif'       => true,
            ]
        );

        JenisSurat::firstOrCreate(
            ['kode' => 'SKU'],
            [
                'nama'        => 'Surat Keterangan Usaha',
                'deskripsi'   => 'Surat keterangan izin usaha mikro (SKU).',
                'persyaratan' => ['ktp', 'kk'],
                'aktif'       => true,
            ]
        );

        JenisSurat::firstOrCreate(
            ['kode' => 'IKH'],
            [
                'nama'        => 'Surat Izin Khajatan',
                'deskripsi'   => 'Surat keterangan izin untuk menyelenggarakan acara/khajatan warga.',
                'persyaratan' => ['ktp', 'kk'],
                'aktif'       => true,
            ]
        );

        JenisSurat::firstOrCreate(
            ['kode' => 'KEMATIAN'],
            [
                'nama'        => 'Surat Keterangan Kematian',
                'deskripsi'   => 'Surat keterangan untuk pelaporan kematian warga.',
                'persyaratan' => ['ktp', 'kk'],
                'aktif'       => true,
            ]
        );

        JenisSurat::firstOrCreate(
            ['kode' => 'KELAHIRAN'],
            [
                'nama'        => 'Surat Keterangan Kelahiran',
                'deskripsi'   => 'Surat keterangan untuk pelaporan kelahiran anak.',
                'persyaratan' => ['ktp', 'kk'],
                'aktif'       => true,
            ]
        );

        JenisSurat::firstOrCreate(
            ['kode' => 'PINDAH'],
            [
                'nama'        => 'Surat Keterangan Pindah',
                'deskripsi'   => 'Surat keterangan pengantar pindah domisili penduduk.',
                'persyaratan' => ['ktp', 'kk'],
                'aktif'       => true,
            ]
        );

        JenisSurat::firstOrCreate(
            ['kode' => 'BEDA_NAMA'],
            [
                'nama'        => 'Surat Keterangan Beda Nama',
                'deskripsi'   => 'Surat pernyataan menerangkan nama berbeda dari orang yang sama.',
                'persyaratan' => ['ktp', 'kk'],
                'aktif'       => true,
            ]
        );

        JenisSurat::firstOrCreate(
            ['kode' => 'BELUM_NIKAH'],
            [
                'nama'        => 'Surat Keterangan Belum Menikah',
                'deskripsi'   => 'Surat keterangan menyatakan belum pernah menikah.',
                'persyaratan' => ['ktp', 'kk'],
                'aktif'       => true,
            ]
        );
    }
}
