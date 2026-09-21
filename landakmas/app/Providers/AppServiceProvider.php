<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Hosting produksi LANDAKMAS (landakmas.wuaze.com) berjalan di
        // belakang proxy yang menangani SSL, sehingga PHP di baliknya
        // sering tidak "sadar" request aslinya HTTPS. Akibatnya semua URL
        // hasil route()/url()/asset() dibuat dengan skema http://, padahal
        // halaman dibuka lewat https:// — browser lalu diam-diam memblokir
        // form yang action-nya http:// di halaman https: (mixed content),
        // termasuk form logout tombol "Keluar" di sidebar admin, sehingga
        // tombolnya seolah tidak bereaksi sama sekali saat dipencet.
        // Memaksa skema https di sini menghilangkan masalah itu tanpa
        // bergantung pada konfigurasi proxy di sisi hosting.
        if (str_starts_with(config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }
    }
}
