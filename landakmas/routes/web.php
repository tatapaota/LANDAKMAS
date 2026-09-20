<?php

use App\Http\Controllers\PublicSiteController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ArchiveController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\AccountController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public site (tanpa login)
|--------------------------------------------------------------------------
|
| Dibungkus middleware NoCacheDynamicPages supaya status arsip (Tersedia /
| Tidak Tersedia) yang ditampilkan selalu ambil data terbaru dari server,
| tidak nyangkut di cache browser maupun proxy hosting di tengah jalan.
*/

Route::middleware(\App\Http\Middleware\NoCacheDynamicPages::class)->group(function () {
    Route::get('/', [PublicSiteController::class, 'home'])->name('home');
    Route::get('/arsip', [PublicSiteController::class, 'archive'])->name('archive');
    Route::get('/instansi', [PublicSiteController::class, 'institution'])->name('institution');
    Route::get('/instansi-detail', [PublicSiteController::class, 'institutionDetail'])->name('institution.detail');

    Route::get('/booking', [PublicSiteController::class, 'booking'])->name('booking');
});

// Simpan booking ke DB (BookingRequest). Email persetujuan TIDAK dikirim
// di sini lagi — baru terkirim setelah admin menentukan waktu pengambilan
// (lihat Admin\BookingController@sendEmail).
Route::post('/booking', [PublicSiteController::class, 'bookingStore'])->name('booking.store');

// Dipanggil lewat JS (polling) di kartu "Statistik Pengunjung" Beranda,
// supaya angkanya update sendiri tanpa reload. Sengaja di luar middleware
// NoCacheDynamicPages karena ini bukan halaman (view), cuma JSON kecil.
Route::get('/api/visitor-stats', [PublicSiteController::class, 'visitorStatsJson'])->name('visitor-stats.json');

/*
|--------------------------------------------------------------------------
| Admin panel
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AuthController::class, 'landing'])->name('landing');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/lupa-sandi', [AuthController::class, 'showForgotPassword'])->name('forgot');
    Route::post('/lupa-sandi', [AuthController::class, 'sendResetLink'])->name('forgot.send');

    Route::get('/reset-sandi/{token}', [AuthController::class, 'showResetPassword'])->name('reset-password.show');
    Route::post('/reset-sandi', [AuthController::class, 'resetPassword'])->name('reset-password.update');

    // Semua halaman di bawah ini butuh login admin (guard 'admin').
    // Kalau belum login, otomatis dilempar ke admin.login lewat
    // redirectGuestsTo() di bootstrap/app.php.
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/arsip', [ArchiveController::class, 'index'])->name('archive');
        Route::get('/arsip/tambah', [ArchiveController::class, 'create'])->name('archive.create');

        // Upload massal dari file Excel: upload -> preview -> konfirmasi simpan
        Route::post('/arsip/import', [ArchiveController::class, 'importPreview'])->name('archive.import.preview.store');
        Route::get('/arsip/import/preview', [ArchiveController::class, 'showImportPreview'])->name('archive.import.preview');
        Route::post('/arsip/import/simpan', [ArchiveController::class, 'importStore'])->name('archive.import.store');
        Route::put('/arsip/{arsip}', [ArchiveController::class, 'update'])->name('archive.update');
        Route::delete('/arsip/{arsip}', [ArchiveController::class, 'destroy'])->name('archive.destroy');

        // Hapus banyak arsip sekaligus (dipilih lewat checkbox di Daftar
        // Arsip). Tombol Hapus satuan (ikon tong sampah per baris) tetap
        // ada dan tetap lewat archive.destroy seperti biasa.
        Route::delete('/arsip', [ArchiveController::class, 'bulkDestroy'])->name('archive.bulkDestroy');

        // Sinkron otomatis dengan permintaan booking dari sisi publik
        // (BookingController@index membaca langsung dari database).
        Route::get('/permintaan-booking', [BookingController::class, 'index'])->name('booking');
        Route::put('/permintaan-booking/{booking}/kembalikan', [BookingController::class, 'returnDocument'])->name('booking.return');

        // Admin menentukan jam pengambilan arsip, lalu baru mengirim
        // email persetujuan ke peminjam lewat tombol terpisah (lihat
        // BookingController@setWaktu dan @sendEmail).
        Route::put('/permintaan-booking/{booking}/waktu', [BookingController::class, 'setWaktu'])->name('booking.setWaktu');
        Route::post('/permintaan-booking/{booking}/kirim-email', [BookingController::class, 'sendEmail'])->name('booking.sendEmail');

        Route::get('/kelola-akun', [AccountController::class, 'index'])->name('account');
        Route::put('/kelola-akun', [AccountController::class, 'update'])->name('account.update');
        Route::post('/kelola-akun/tambah-admin', [AccountController::class, 'storeAdmin'])->name('account.storeAdmin');

        // Hanya akun utama (super admin) yang bisa melihat daftar akun
        // lain sekaligus menghapusnya (lihat Admin::isSuperAdmin()).
        Route::delete('/kelola-akun/{targetAdmin}', [AccountController::class, 'destroyAdmin'])->name('account.destroyAdmin');
    });
});

