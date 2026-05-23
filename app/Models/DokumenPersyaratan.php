<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenPersyaratan extends Model
{
    use HasFactory;

    protected $table = 'dokumen_persyaratan';

    protected $fillable = [
        'pengajuan_id', 'jenis_dokumen', 'nama_file', 'file_path', 'file_size', 'mime_type',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanSurat::class, 'pengajuan_id');
    }

    public function getFileSizeFormattedAttribute(): string
    {
        if (!$this->file_size) return '-';
        $bytes = $this->file_size;
        if ($bytes >= 1048576) return round($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024) return round($bytes / 1024, 2) . ' KB';
        return $bytes . ' B';
    }
}
