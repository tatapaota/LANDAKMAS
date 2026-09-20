<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan status peminjaman supaya admin bisa "mengembalikan"
     * dokumen yang sudah selesai dibooking:
     *
     * - booking_requests.status: 'diproses' (baru masuk / sedang dipinjam)
     *   atau 'dikembalikan' (dokumennya sudah balik & tersedia lagi).
     * - arsips.status: 'tersedia' atau 'dipinjam', dipakai halaman publik
     *   untuk menampilkan badge "Tersedia" / "Tidak Tersedia".
     */
    public function up(): void
    {
        Schema::table('booking_requests', function (Blueprint $table) {
            $table->string('status')->default('diproses')->after('tanggal_pengambilan');
            $table->timestamp('dikembalikan_at')->nullable()->after('status');
        });

        Schema::table('arsips', function (Blueprint $table) {
            $table->string('status')->default('tersedia')->after('media');
        });
    }

    public function down(): void
    {
        Schema::table('booking_requests', function (Blueprint $table) {
            $table->dropColumn(['status', 'dikembalikan_at']);
        });

        Schema::table('arsips', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
