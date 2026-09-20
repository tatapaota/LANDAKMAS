<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel permintaan booking arsip yang dikirim masyarakat lewat
     * formulir "Data Peminjam" di halaman publik.
     *
     * Sebelumnya data ini hanya disimpan di localStorage browser (jadi
     * tidak sinkron antar admin/perangkat). Sekarang setiap arsip yang
     * dibooking dalam satu pengiriman formulir disimpan sebagai satu
     * baris di sini, dengan data arsip di-snapshot (kode, uraian,
     * instansi, tahun) supaya riwayat booking tetap utuh walau data
     * arsip aslinya nanti diubah/dihapus.
     */
    public function up(): void
    {
        Schema::create('booking_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('arsip_id')->nullable()->constrained('arsips')->nullOnDelete();

            $table->string('nama');
            $table->string('telepon');
            $table->string('email');
            $table->text('alamat');
            $table->text('tujuan');
            $table->date('tanggal_pengambilan')->nullable();

            // Snapshot data arsip pada saat booking dikirim.
            $table->string('arsip_no')->nullable();
            $table->string('arsip_kode')->nullable();
            $table->text('arsip_uraian')->nullable();
            $table->string('arsip_instansi')->nullable();
            $table->string('arsip_tahun')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_requests');
    }
};
