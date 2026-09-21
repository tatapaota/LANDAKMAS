<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel admin sungguhan untuk menggantikan kredensial hardcode di
     * JavaScript (lihat komentar lama di admin/login.blade.php). Dipakai
     * oleh guard 'admin' (lihat config/auth.php) untuk login, kelola akun
     * (ganti nama/email/password), dan tambah admin baru.
     */
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
