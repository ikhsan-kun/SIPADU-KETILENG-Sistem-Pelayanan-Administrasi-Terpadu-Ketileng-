<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_surat', function (Blueprint $table) {
            $table->id();
            $table->string('no_surat')->nullable()->unique(); // Auto-generated saat approved
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('penduduk_id')->constrained('penduduk')->onDelete('cascade');
            $table->foreignId('jenis_surat_id')->constrained('jenis_surat')->onDelete('cascade');
            $table->text('keperluan');
            $table->enum('status', [
                'menunggu',     // Baru diajukan warga
                'diproses',     // Sedang diverifikasi admin
                'disetujui',    // Sudah diforward ke kades
                'ditolak',      // Ditolak (admin/kades)
                'selesai',      // Sudah di-approve kades + QR
            ])->default('menunggu');
            $table->text('catatan_admin')->nullable();
            $table->text('catatan_kades')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->string('qr_code_path')->nullable();
            $table->string('surat_path')->nullable(); // Path PDF yang sudah jadi
            $table->string('kode_verifikasi')->nullable()->unique(); // Untuk QR verifikasi publik
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_surat');
    }
};
