<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Beberapa laporan bug "status arsip beda-beda antar device" ternyata
 * kemungkinan besar bukan soal data di database (yang sudah benar & sama
 * untuk semua orang), tapi karena halaman publik (beranda, cari arsip,
 * detail instansi) sempat ke-cache - entah oleh browser pengguna, atau
 * oleh proxy hosting produksi (lihat catatan trustProxies di
 * bootstrap/app.php, hosting produksi berada di belakang proxy).
 *
 * Middleware ini memaksa semua halaman dinamis tsb selalu diambil ulang
 * dari server (tidak boleh disimpan sebagai cache oleh browser maupun
 * proxy di tengah jalan), supaya status "Tersedia" / "Tidak Tersedia"
 * yang dilihat pengguna selalu sinkron dengan database terbaru.
 */
class NoCacheDynamicPages
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set(
            'Cache-Control',
            'no-store, no-cache, must-revalidate, max-age=0',
        );
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');

        return $response;
    }
}
