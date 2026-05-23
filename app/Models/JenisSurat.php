<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    use HasFactory;

    protected $table = 'jenis_surat';

    protected $fillable = [
        'kode', 'nama', 'deskripsi', 'persyaratan', 'aktif',
    ];

    protected $casts = [
        'persyaratan' => 'array',
        'aktif' => 'boolean',
    ];

    public function pengajuanSurat()
    {
        return $this->hasMany(PengajuanSurat::class);
    }

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }
}
