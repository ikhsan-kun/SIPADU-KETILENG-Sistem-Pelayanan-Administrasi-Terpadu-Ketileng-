<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanSurat extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_surat';

    protected $fillable = [
        'no_surat', 'user_id', 'penduduk_id', 'jenis_surat_id',
        'keperluan', 'status', 'catatan_admin', 'catatan_kades',
        'verified_by', 'verified_at', 'approved_by', 'approved_at',
        'qr_code_path', 'surat_path', 'kode_verifikasi',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    // Status constants
    const STATUS_MENUNGGU  = 'menunggu';
    const STATUS_DIPROSES  = 'diproses';
    const STATUS_DISETUJUI = 'disetujui';
    const STATUS_DITOLAK   = 'ditolak';
    const STATUS_SELESAI   = 'selesai';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class);
    }

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat_id');
    }

    public function dokumen()
    {
        return $this->hasMany(DokumenPersyaratan::class, 'pengajuan_id');
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getStatusBadgeAttribute(): array
    {
        return match($this->status) {
            'menunggu'  => ['label' => 'Menunggu',  'class' => 'bg-yellow-100 text-yellow-800'],
            'diproses'  => ['label' => 'Diproses',  'class' => 'bg-blue-100 text-blue-800'],
            'disetujui' => ['label' => 'Disetujui', 'class' => 'bg-purple-100 text-purple-800'],
            'ditolak'   => ['label' => 'Ditolak',   'class' => 'bg-red-100 text-red-800'],
            'selesai'   => ['label' => 'Selesai',   'class' => 'bg-green-100 text-green-800'],
            default     => ['label' => ucfirst($this->status), 'class' => 'bg-gray-100 text-gray-800'],
        };
    }

    /**
     * Generate nomor surat format: 016/SKTM/III/2023
     */
    public static function generateNomorSurat(string $kodeJenis): string
    {
        $bulanRomawi = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV',
            5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII',
            9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII',
        ];

        $bulan = (int) date('m');
        $tahun = date('Y');
        $romawi = $bulanRomawi[$bulan];

        // Hitung nomor urut bulan ini untuk jenis surat ini yang sudah disetujui (memiliki nomor surat)
        $count = self::whereYear('created_at', $tahun)
            ->whereMonth('created_at', $bulan)
            ->whereNotNull('no_surat')
            ->whereHas('jenisSurat', fn($q) => $q->where('kode', $kodeJenis))
            ->count() + 1;

        $nomor = str_pad($count, 3, '0', STR_PAD_LEFT);

        return "{$nomor}/{$kodeJenis}/{$romawi}/{$tahun}";
    }
}
