<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom untuk fitur "Waktu Pengambilan Arsip" yang
     * ditentukan admin, dan penanda kapan email persetujuan sudah
     * dikirim ke peminjam.
     *
     * Email riwayat booking TIDAK lagi otomatis terkirim saat user
     * mengirim formulir (lihat PublicSiteController::bookingStore()).
     * User baru menerima email setelah admin menentukan jam pengambilan
     * di halaman Permintaan Booking lalu menekan tombol
     * "Kirim ke Email Peminjam" (lihat BookingController::sendEmail()),
     * yang mengisi kolom email_terkirim_at ini.
     */
    public function up(): void
    {
        Schema::table('booking_requests', function (Blueprint $table) {
            $table->string('waktu_pengambilan')->nullable()->after('tanggal_pengambilan');
            $table->timestamp('email_terkirim_at')->nullable()->after('dikembalikan_at');
        });
    }

    public function down(): void
    {
        Schema::table('booking_requests', function (Blueprint $table) {
            $table->dropColumn(['waktu_pengambilan', 'email_terkirim_at']);
        });
    }
};
