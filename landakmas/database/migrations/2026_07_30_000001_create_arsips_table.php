<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel utama daftar arsip.
     *
     * Field inti mengikuti skema yang sudah dipakai sistem sejak fase
     * frontend: Kode Klasifikasi, Uraian Arsip, Tahun, Instansi, Nomor Arsip
     * (nomor arsip di-scope per instansi, bukan global).
     */
    public function up(): void
    {
        Schema::create('arsips', function (Blueprint $table) {
            $table->id();
            $table->string('instansi');
            $table->string('kode_klasifikasi')->nullable();
            $table->string('nomor_arsip')->nullable();
            $table->string('tahun')->nullable();
            $table->text('uraian')->nullable();
            $table->text('uraian_lengkap')->nullable();
            $table->json('media')->nullable(); // path file cover/lampiran (multi-file)
            $table->timestamps();

            // satu nomor arsip hanya boleh dipakai sekali dalam instansi yang sama
            $table->unique(['instansi', 'nomor_arsip']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arsips');
    }
};
