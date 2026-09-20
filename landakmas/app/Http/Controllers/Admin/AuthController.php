<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Arsip;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    /**
     * Beranda admin (sebelum/sesudah login). Statistik dan cuplikan Daftar
     * Arsip di sini diambil langsung dari database — sama seperti beranda
     * publik (lihat PublicSiteController@home) — supaya kedua halaman
     * konsisten dan tidak lagi menampilkan angka/contoh dummy.
     */
    public function landing()
    {
        $totalArsip = Arsip::count();

        $totalInstansi = Arsip::whereNotNull('instansi')
            ->where('instansi', '!=', '')
            ->distinct('instansi')
            ->count('instansi');

        $tahunAngka = Arsip::whereNotNull('tahun')
            ->pluck('tahun')
            ->map(fn ($t) => (int) $t)
            ->filter(fn ($t) => $t > 0);

        // Cuplikan arsip terbaru untuk ditampilkan di beranda admin, sama
        // seperti daftar arsip publik tapi tanpa kolom Instansi.
        $landingArsipJs = Arsip::latest()->take(3)->get()
            ->map(function ($item) {
                return [
                    'no'          => $item->id,
                    'kode'        => $item->kode_klasifikasi ?: '-',
                    'noDefinitif' => $item->nomor_arsip ?: '-',
                    'uraian'      => $item->uraian_lengkap ?: ($item->uraian ?: '-'),
                    'tahun'       => $item->tahun ?: '-',
                ];
            })
            ->values();

        return view('admin.landing', [
            'statTotalArsip'    => $totalArsip,
            'statTotalInstansi' => $totalInstansi,
            'statTahunAwal'     => $tahunAngka->min() ?: 1985,
            'statTahunAkhir'    => $tahunAngka->max() ?: now()->year,
            'landingArsipJs'    => $landingArsipJs,
            'isLoggedIn'        => Auth::guard('admin')->check(),
        ]);
    }

    public function showLogin()
    {
        // Kalau sudah login, tidak perlu lihat form login lagi.
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    /**
     * Login admin sungguhan lewat guard 'admin' (tabel admins), bukan lagi
     * kredensial hardcode di JavaScript.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials, true)) {
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('admin.login')
            ->withErrors(['email' => 'Email atau kata sandi salah.'])
            ->withInput($request->only('email'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function showForgotPassword()
    {
        return view('admin.forgot_password');
    }

    /**
     * Kirim email reset kata sandi ke alamat email admin yang bersangkutan
     * (kalau email itu terdaftar). Pesan sukses sengaja sama persis baik
     * email terdaftar atau tidak, supaya tidak membocorkan daftar akun admin.
     */
    public function sendResetLink(Request $request): RedirectResponse
    {
        $request->validate(['email' => 'required|email']);

        Password::broker('admins')->sendResetLink(
            $request->only('email')
        );

        return redirect()->route('admin.forgot')
            ->with('status', 'Jika email terdaftar, link reset kata sandi telah dikirim.');
    }

    public function showResetPassword(Request $request, string $token)
    {
        return view('admin.reset_password', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::broker('admins')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($admin, $password) {
                $admin->password = $password;
                $admin->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('admin.login')
                ->with('status', 'Kata sandi berhasil diubah. Silakan masuk dengan kata sandi baru.');
        }

        return redirect()->route('admin.forgot')
            ->withErrors(['email' => 'Tautan reset tidak valid atau sudah kedaluwarsa. Silakan minta tautan baru.']);
    }
}
