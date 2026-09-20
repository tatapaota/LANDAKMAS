<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AccountController extends Controller
{
    public function index()
    {
        /** @var Admin $admin */
        $admin = Auth::guard('admin')->user();
        $isSuperAdmin = $admin->isSuperAdmin();

        return view('admin.manage_account', [
            'admin' => $admin,
            'isSuperAdmin' => $isSuperAdmin,
            // Daftar akun admin lain hanya dikirim ke view kalau yang
            // login adalah akun utama. Admin biasa tidak boleh tahu
            // akun-akun lain yang ada di sistem.
            'admins' => $isSuperAdmin ? Admin::orderBy('created_at')->get() : collect(),
        ]);
    }

    /**
     * Update nama/email/password admin yang sedang login. Sebelumnya
     * tombol "Simpan Perubahan" cuma nampilin alert() dan tidak pernah
     * benar-benar menyimpan apa pun ke database.
     */
    public function update(Request $request): RedirectResponse
    {
        /** @var Admin $admin */
        $admin = Auth::guard('admin')->user();

        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('admins', 'email')->ignore($admin->id)],
            'current_password' => 'nullable|required_with:password|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if (! empty($data['password'])) {
            if (! Hash::check($data['current_password'], $admin->password)) {
                throw ValidationException::withMessages([
                    'current_password' => 'Password saat ini yang kamu masukkan salah.',
                ]);
            }

            $admin->password = $data['password'];
        }

        $admin->nama = $data['nama'];
        $admin->email = $data['email'];
        $admin->save();

        return redirect()->route('admin.account')
            ->with('status', 'Perubahan akun berhasil disimpan.');
    }

    /**
     * Tambah akun admin baru (sebelumnya cuma modal simulasi di JS,
     * tidak pernah tersimpan ke database sehingga admin baru itu tidak
     * bisa benar-benar login).
     */
    public function storeAdmin(Request $request): RedirectResponse
    {
        /** @var Admin $admin */
        $admin = Auth::guard('admin')->user();

        abort_unless($admin->isSuperAdmin(), 403);

        $data = $request->validate([
            'new_admin_nama' => 'required|string|max:255',
            'new_admin_email' => 'required|email|max:255|unique:admins,email',
            'new_admin_password' => 'required|string|min:8',
        ], [], [
            'new_admin_nama' => 'nama admin',
            'new_admin_email' => 'email',
            'new_admin_password' => 'password awal',
        ]);

        Admin::create([
            'nama' => $data['new_admin_nama'],
            'email' => $data['new_admin_email'],
            'password' => $data['new_admin_password'],
        ]);

        return redirect()->route('admin.account')
            ->with('status', 'Admin baru berhasil ditambahkan.')
            ->with('newAdminNama', $data['new_admin_nama'])
            ->with('newAdminEmail', $data['new_admin_email']);
    }

    /**
     * Hapus akun admin. Hanya akun utama (super admin) yang boleh
     * melakukan ini, tidak boleh menghapus akunnya sendiri, dan akun
     * utama itu sendiri tidak bisa dihapus lewat sini.
     */
    public function destroyAdmin(Admin $targetAdmin): RedirectResponse
    {
        /** @var Admin $admin */
        $admin = Auth::guard('admin')->user();

        abort_unless($admin->isSuperAdmin(), 403);

        if ($targetAdmin->id === $admin->id) {
            return redirect()->route('admin.account')
                ->with('error', 'Tidak bisa menghapus akun yang sedang kamu gunakan.');
        }

        if ($targetAdmin->isSuperAdmin()) {
            return redirect()->route('admin.account')
                ->with('error', 'Akun utama tidak bisa dihapus.');
        }

        $targetAdmin->delete();

        return redirect()->route('admin.account')
            ->with('status', 'Akun "'.$targetAdmin->nama.'" berhasil dihapus.');
    }
}