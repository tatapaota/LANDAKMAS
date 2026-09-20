<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Akun admin default, menggantikan kredensial hardcode yang dulu ada
     * di admin/login.blade.php (adminarpusda@gmail.com / admin123).
     * Ganti/hapus lewat halaman Kelola Akun setelah login pertama kali.
     */
    public function run(): void
    {
        Admin::firstOrCreate(
            ['email' => 'adminarpusda@gmail.com'],
            [
                'nama' => 'Admin',
                'password' => 'admin123',
            ]
        );
    }
}
