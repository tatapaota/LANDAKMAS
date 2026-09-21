<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Kalau belum login (guard 'admin'), lempar ke halaman login admin
        // alih-alih ke /login bawaan Laravel yang tidak dipakai di sini.
        $middleware->redirectGuestsTo(fn () => route('admin.login'));

        // Hosting produksi berada di belakang proxy yang menangani SSL
        // (lihat catatan di AppServiceProvider::boot()). Mempercayai header
        // X-Forwarded-* dari proxy supaya Laravel sendiri tahu request
        // aslinya HTTPS, IP asli pengunjung terbaca benar, dsb.
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();