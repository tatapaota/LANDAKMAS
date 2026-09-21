<?php

namespace App\Support;

use App\Models\PageVisit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class VisitorStats
{
    /**
     * Hitung jumlah baris untuk "Hari Ini", "Minggu Ini", "Bulan Ini",
     * "Tahun Ini", dan "Total", berdasarkan kolom tanggal $column pada
     * query $baseQuery. Menghitung SETIAP BARIS (bukan pengunjung unik)
     * — cocok untuk data yang satu barisnya memang sudah mewakili satu
     * "orang" (mis. satu baris booking_requests = satu permintaan dari
     * satu orang). Untuk hitung PENGUNJUNG SITUS (page_visits, di mana
     * satu orang bisa punya banyak baris karena buka banyak halaman),
     * pakai uniqueVisitorCounts() di bawah, bukan method ini.
     *
     * @return array{hariIni:int,mingguIni:int,bulanIni:int,tahunIni:int,total:int}
     */
    public static function periodCounts(Builder $baseQuery, string $column = 'created_at'): array
    {
        $now = Carbon::now();

        return [
            'hariIni' => (clone $baseQuery)
                ->whereDate($column, $now->toDateString())
                ->count(),

            'mingguIni' => (clone $baseQuery)
                ->whereBetween($column, [
                    $now->copy()->startOfWeek(),
                    $now->copy()->endOfWeek(),
                ])
                ->count(),

            'bulanIni' => (clone $baseQuery)
                ->whereYear($column, $now->year)
                ->whereMonth($column, $now->month)
                ->count(),

            'tahunIni' => (clone $baseQuery)
                ->whereYear($column, $now->year)
                ->count(),

            'total' => (clone $baseQuery)->count(),
        ];
    }

    /**
     * Sama seperti periodCounts(), tapi menghitung nilai UNIK dari
     * $distinctColumn (mis. session_id), bukan jumlah baris. Ini yang
     * dipakai untuk kartu "Statistik Pengunjung" supaya satu orang yang
     * membuka banyak halaman dalam satu sesi browser tetap dihitung
     * sebagai 1 "pengunjung", bukan 1 per halaman yang dibuka.
     *
     * @return array{hariIni:int,mingguIni:int,bulanIni:int,tahunIni:int,total:int}
     */
    public static function uniqueVisitorCounts(
        Builder $baseQuery,
        string $distinctColumn = 'session_id',
        string $dateColumn = 'created_at'
    ): array {
        $now = Carbon::now();

        $hitungUnik = fn ($query) => (clone $query)
            ->whereNotNull($distinctColumn)
            ->distinct()
            ->count($distinctColumn);

        return [
            'hariIni' => $hitungUnik(
                (clone $baseQuery)->whereDate($dateColumn, $now->toDateString())
            ),

            'mingguIni' => $hitungUnik(
                (clone $baseQuery)->whereBetween($dateColumn, [
                    $now->copy()->startOfWeek(),
                    $now->copy()->endOfWeek(),
                ])
            ),

            'bulanIni' => $hitungUnik(
                (clone $baseQuery)->whereYear($dateColumn, $now->year)->whereMonth($dateColumn, $now->month)
            ),

            'tahunIni' => $hitungUnik(
                (clone $baseQuery)->whereYear($dateColumn, $now->year)
            ),

            'total' => $hitungUnik($baseQuery),
        ];
    }

    /**
     * Satu-satunya sumber data "Statistik Pengunjung" — dipakai oleh
     * halaman Beranda publik (PublicSiteController) MAUPUN Dashboard
     * admin (Admin\DashboardController), supaya angka yang ditampilkan
     * di kedua tempat selalu sama persis dan sama-sama berdasarkan
     * pengunjung situs yang sesungguhnya (tabel page_visits), bukan
     * data lain yang tidak berhubungan (mis. jumlah booking selesai).
     *
     * "Post Terpopuler" tetap dihitung dari jumlah baris (bukan sesi
     * unik) karena maksudnya memang "halaman mana yang paling sering
     * dibuka", bukan "berapa pengunjung uniknya".
     */
    public static function pageVisitSummary(): array
    {
        $counts = self::uniqueVisitorCounts(PageVisit::query());

        $terpopuler = PageVisit::whereNotNull('label')
            ->where('label', '!=', '')
            ->selectRaw('label, count(*) as jumlah')
            ->groupBy('label')
            ->orderByDesc('jumlah')
            ->first();

        return array_merge($counts, [
            'postTerpopulerLabel' => $terpopuler->label ?? '-',
            'postTerpopulerCount' => $terpopuler->jumlah ?? 0,
        ]);
    }
}