<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel pencatat kunjungan halaman publik (Beranda, Cari Arsip,
     * Instansi, Detail Instansi). Satu baris = satu kali halaman
     * dibuka. Dipakai untuk menyusun kartu "Statistik Pengunjung" di
     * halaman Beranda publik (lihat PublicSiteController::home()).
     *
     * "label" menyimpan nama halaman yang ramah-baca (mis. "Beranda",
     * "Cari Arsip", atau nama instansi yang dibuka) supaya bisa
     * dipakai langsung untuk "Post Terpopuler" tanpa perlu lookup lagi.
     */
    public function up(): void
    {
        Schema::create('page_visits', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->string('label')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_visits');
    }
};
