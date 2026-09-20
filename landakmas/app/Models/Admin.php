<?php

namespace App\Models;

use App\Notifications\AdminResetPasswordNotification;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable implements CanResetPasswordContract
{
    use Notifiable;
    use CanResetPassword;

    protected $fillable = [
        'nama',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            // Laravel otomatis hash nilai yang di-assign ke kolom ini
            // (mis. $admin->password = $request->password), jadi kita
            // tidak perlu panggil Hash::make() manual di controller.
            'password' => 'hashed',
        ];
    }

    /**
     * Override supaya email reset password admin dikirim lewat notifikasi
     * kita sendiri (link mengarah ke halaman reset admin, bukan halaman
     * reset password 'users' bawaan Laravel yang tidak dipakai di sini).
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }

    /**
     * Akun utama/pusat = admin dengan id terkecil (admin pertama yang
     * dibuat, mis. arsiparpusda@gmail.com). Sengaja tidak dicocokkan
     * lewat email karena email admin utama bisa saja diganti lewat
     * halaman Kelola Akun. Hanya akun ini yang boleh melihat daftar
     * seluruh admin dan menghapus akun admin lain.
     */
    public function isSuperAdmin(): bool
    {
        return $this->id === static::min('id');
    }
}