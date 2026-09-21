<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Arsip;
use App\Support\VisitorStats;

class DashboardController extends Controller
{
    /**
     * "Statistik Pengunjung" di dashboard admin memakai sumber data
     * yang SAMA PERSIS dengan kartu di Beranda publik — yaitu
     * VisitorStats::pageVisitSummary(), dihitung dari pengunjung situs
     * sesungguhnya (tabel page_visits, dihitung per sesi browser unik).
     * Sebelumnya kartu ini malah menghitung jumlah booking yang sudah
     * selesai (data yang tidak berhubungan dengan "pengunjung"), jadi
     * angkanya tidak pernah cocok dengan kartu yang sama di Beranda.
     */
    private function visitorStats(): array
    {
        return VisitorStats::pageVisitSummary();
    }

    /**
     * Semua angka & grafik di sini diambil langsung dari tabel `arsips` —
     * sebelumnya halaman ini seluruhnya hardcode (7, 5, 27, dst) dan tidak
     * terhubung ke database sama sekali.
     */
    public function index()
    {
        $totalArsip = Arsip::count();

        // Belum ada kolom status publik/privat tersendiri di tabel arsips —
        // seluruh arsip yang sudah punya uraian dianggap "siap tampil" di
        // pencarian publik (arsip tanpa uraian, kalau ada, belum lengkap).
        $arsipPublik = Arsip::whereNotNull('uraian')->where('uraian', '!=', '')->count();

        $totalInstansi = Arsip::whereNotNull('instansi')
            ->where('instansi', '!=', '')
            ->distinct('instansi')
            ->count('instansi');

        $arsipBulanIni = Arsip::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        $tahunAngka = Arsip::whereNotNull('tahun')
            ->pluck('tahun')
            ->map(fn ($t) => (int) $t)
            ->filter(fn ($t) => $t > 0);

        $instansiList = Arsip::whereNotNull('instansi')
            ->where('instansi', '!=', '')
            ->distinct()
            ->orderBy('instansi')
            ->pluck('instansi')
            ->values();

        // Rincian jumlah arsip per (instansi, tahun) — dipakai JS di halaman
        // ini untuk menyusun kedua grafik sekaligus menerapkan filter
        // dropdown "Instansi"/"Tahun" tanpa perlu reload halaman.
        $breakdownJs = Arsip::whereNotNull('tahun')
            ->where('tahun', '!=', '')
            ->whereNotNull('instansi')
            ->where('instansi', '!=', '')
            ->selectRaw('instansi, tahun, count(*) as jumlah')
            ->groupBy('instansi', 'tahun')
            ->get()
            ->map(fn ($row) => [
                'instansi' => $row->instansi,
                'tahun'    => (string) $row->tahun,
                'jumlah'   => (int) $row->jumlah,
            ])
            ->values();

        return view('admin.dashboard', array_merge([
            'statTotalArsip'    => $totalArsip,
            'statArsipPublik'   => $arsipPublik,
            'statTotalInstansi' => $totalInstansi,
            'statArsipBulanIni' => $arsipBulanIni,
            'statTahunAwal'     => $tahunAngka->min() ?: now()->year,
            'statTahunAkhir'    => $tahunAngka->max() ?: now()->year,
            'instansiList'      => $instansiList,
            'breakdownJs'       => $breakdownJs,
        ], $this->visitorStats()));
    }
}

