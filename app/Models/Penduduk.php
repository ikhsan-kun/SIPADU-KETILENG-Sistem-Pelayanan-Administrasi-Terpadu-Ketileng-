<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    use HasFactory;

    protected $table = 'penduduk';

    protected $fillable = [
        'nik', 'no_kk', 'nama', 'tempat_lahir', 'tanggal_lahir',
        'jenis_kelamin', 'alamat', 'rt', 'rw', 'desa',
        'kecamatan', 'kabupaten', 'agama', 'pekerjaan',
        'status_perkawinan', 'kewarganegaraan',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function pengajuanSurat()
    {
        return $this->hasMany(PengajuanSurat::class);
    }

    public function getUmurAttribute(): int
    {
        return $this->tanggal_lahir->age;
    }

    public function getAlamatLengkapAttribute(): string
    {
        $parts = [];
        if ($this->alamat) $parts[] = $this->alamat;
        if ($this->rt && $this->rw) $parts[] = "RT {$this->rt}/RW {$this->rw}";
        $parts[] = "Desa {$this->desa}";
        $parts[] = "Kec. {$this->kecamatan}";
        $parts[] = "Kab. {$this->kabupaten}";
        return implode(', ', $parts);
    }
}
