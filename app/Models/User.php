<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'nik', 'email', 'password', 'role', 'phone', 'address', 'fcm_token',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function isWarga(): bool
    {
        return $this->role === 'warga';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isKades(): bool
    {
        return $this->role === 'kades';
    }

    public function pengajuanSurat()
    {
        return $this->hasMany(PengajuanSurat::class);
    }

    public function verifiedSurat()
    {
        return $this->hasMany(PengajuanSurat::class, 'verified_by');
    }

    public function approvedSurat()
    {
        return $this->hasMany(PengajuanSurat::class, 'approved_by');
    }
}
