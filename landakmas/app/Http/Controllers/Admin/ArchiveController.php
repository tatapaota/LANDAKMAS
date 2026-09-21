<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\ArsipImport;
use App\Models\Arsip;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class ArchiveController extends Controller
{
    public function index(): View
    {
        // Arsip yang sedang "dipinjam" (masih dalam proses booking, belum
        // ditandai "Kembalikan Dokumen" di Permintaan Booking) disembunyikan
        // dari Daftar Arsip supaya admin tidak sengaja mengedit/menghapus
        // arsip yang lagi keluar. Nomor urut ("No." di tabel) otomatis
        // menyesuaikan (cuma index tampilan), sedangkan No. Definitif dan
        // Kode Klasifikasi arsip lain tetap sama seperti biasa.
        $arsips = Arsip::where('status', '!=', 'dipinjam')
            ->orWhereNull('status')
            ->latest()
            ->get();

        return view('admin.archive', compact('arsips'));
    }

    public function create(): View
    {
        return view('admin.add_archive');
    }

    /**
     * Update satu arsip lewat modal Edit di halaman Daftar Arsip.
     * Dipanggil lewat fetch() (AJAX) sehingga merespons JSON.
     */
    public function update(Request $request, Arsip $arsip)
    {
        $validated = $request->validate([
            'instansi'         => 'required|string|max:255',
            'tahun'            => 'nullable|string|max:20',
            'kode_klasifikasi' => 'nullable|string|max:100',
            'nomor_arsip'      => 'nullable|string|max:100',
            'uraian_lengkap'   => 'nullable|string',
            'media.*'          => 'nullable|file|max:10240',
            'existing_media'   => 'nullable|array',
            'existing_media.*' => 'nullable|string',
        ]);

        $mediaPaths = $validated['existing_media'] ?? [];

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $mediaPaths[] = $file->store('arsip-media', 'public');
            }
        }

        $uraianLengkap = $validated['uraian_lengkap'] ?? '';

        $arsip->update([
            'instansi'         => $validated['instansi'],
            'tahun'            => $validated['tahun'] ?? null,
            'kode_klasifikasi' => $validated['kode_klasifikasi'] ?? null,
            'nomor_arsip'      => $validated['nomor_arsip'] ?? null,
            'uraian_lengkap'   => $uraianLengkap,
            'uraian'           => Str::limit($uraianLengkap, 120),
            'media'            => $mediaPaths ?: null,
        ]);

        return response()->json(['status' => 'ok', 'arsip' => $arsip->fresh()]);
    }

    /**
     * Hapus satu arsip. Dipanggil lewat fetch() (AJAX) dari tombol Hapus.
     */
    public function destroy(Arsip $arsip)
    {
        $arsip->delete();

        return response()->json(['status' => 'ok']);
    }

    /**
     * Hapus banyak arsip sekaligus, dipanggil lewat checkbox "pilih semua"
     * / centang satuan di Daftar Arsip. Tombol Hapus per baris (ikon tong
     * sampah) tetap memakai destroy() di atas seperti sebelumnya — ini
     * cuma jalur tambahan untuk hapus borongan, bukan penggantinya.
     */
    public function bulkDestroy(Request $request)
    {
        $validated = $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'integer',
        ]);

        $jumlah = Arsip::whereIn('id', $validated['ids'])->delete();

        return response()->json(['status' => 'ok', 'deleted' => $jumlah]);
    }

    /**
     * Baca file Excel yang diupload admin, lalu tampilkan hasilnya sebagai
     * preview sebelum benar-benar disimpan ke database.
     */
    public function importPreview(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $import = new ArsipImport();
        Excel::import($import, $request->file('file'));

        if (empty($import->rows)) {
            return redirect()
                ->route('admin.archive.create')
                ->with('error', 'File tidak bisa dibaca. Pastikan ada baris header dengan kolom "No" dan "Kode Klasifikasi".');
        }

        session([
            'arsip_import_preview' => [
                'instansi' => $import->instansi,
                'rows'     => $import->rows,
            ],
        ]);

        return redirect()->route('admin.archive.import.preview');
    }

    public function showImportPreview(): View|RedirectResponse
    {
        $data = session('arsip_import_preview');

        if (!$data) {
            return redirect()->route('admin.archive.create');
        }

        return view('admin.import_preview', $data);
    }

    /**
     * Konfirmasi akhir: simpan semua baris hasil import ke database.
     * Nomor arsip yang sudah ada untuk instansi yang sama otomatis dilewati.
     */
    public function importStore(Request $request): RedirectResponse
    {
        $data = session('arsip_import_preview');

        if (!$data) {
            return redirect()->route('admin.archive.create');
        }

        $validated = $request->validate([
            'instansi' => 'required|string|max:255',
        ]);

        $instansiDefault = $validated['instansi'];
        $saved = 0;
        $skipped = 0;

        foreach ($data['rows'] as $row) {
            // Kalau file Excel-nya punya kolom Instansi sendiri per baris
            // (lihat ArsipImport), pakai itu dulu. Kalau baris itu tidak
            // punya nilai instansi (kolom kosong atau memang tidak ada
            // kolomnya sama sekali), baru jatuh ke instansi hasil deteksi
            // judul file / isian manual di halaman preview.
            $instansi = ($row['instansi'] ?? '') !== '' ? $row['instansi'] : $instansiDefault;

            $exists = Arsip::where('instansi', $instansi)
                ->where('nomor_arsip', $row['nomor_arsip'])
                ->exists();

            if ($exists) {
                $skipped++;
                continue;
            }

            Arsip::create([
                'instansi'         => $instansi,
                'kode_klasifikasi' => $row['kode_klasifikasi'],
                'nomor_arsip'      => $row['nomor_arsip'],
                'tahun'            => $row['tahun'],
                'uraian'           => $row['uraian'],
                'uraian_lengkap'   => $row['uraian'],
            ]);
            $saved++;
        }

        session()->forget('arsip_import_preview');

        $message = "Import selesai: {$saved} arsip tersimpan.";
        if ($skipped > 0) {
            $message .= " {$skipped} baris dilewati karena nomor arsip sudah ada untuk instansi ini.";
        }

        return redirect()->route('admin.archive')->with('status', $message);
    }
}