<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_surat', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique(); // DOMISILI, SKCK, SKTM, SKU
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->json('persyaratan')->nullable(); // ['ktp', 'kk', 'surat_nikah', ...]
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_surat');
    }
};
