<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penduduk', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique();
            $table->string('no_kk', 16);
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->text('alamat');
            $table->string('rt', 5)->nullable();
            $table->string('rw', 5)->nullable();
            $table->string('desa')->default('Ketileng');
            $table->string('kecamatan')->default('Kramat');
            $table->string('kabupaten')->default('Tegal');
            $table->string('agama')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->enum('status_perkawinan', ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'])->default('Belum Kawin');
            $table->string('kewarganegaraan')->default('WNI');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penduduk');
    }
};
