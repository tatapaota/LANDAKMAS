# LANDAKMAS

Sistem Informasi Arsip untuk Dinas Arsip dan Perpustakaan Daerah Kabupaten Banyumas.
Dibangun dengan Laravel 11 (PHP 8.2+), MySQL, dan `maatwebsite/excel` untuk import data arsip.

## Struktur folder 

Struktur repo ini **bukan** struktur Laravel standar, karena project ini di-deploy
di shared hosting (InfinityFree) yang tidak mendukung symlink. Susunannya:

```
.
├── index.php          # Front controller (isi public/index.php Laravel, path composer & bootstrap disesuaikan)
├── .htaccess          # Rewrite rule (isi public/.htaccess Laravel)
├── assets/            # Aset publik (isi public/assets Laravel)
├── js/                # JS publik (isi public/js Laravel)
├── storage/           # Folder upload publik (setara public/storage, di sini bukan symlink tapi folder asli)
│   └── arsip-media/   # File hasil upload arsip
├── database-backup/   # Dump database (.sql) untuk referensi/restore, bukan bagian dari aplikasi
└── landakmas/         # Aplikasi Laravel yang sesungguhnya (app, config, routes, database migrations, dst)
```

Kalau nanti pindah ke hosting yang mendukung symlink (VPS, shared hosting modern,
dsb), struktur ini bisa dikembalikan ke default Laravel: `index.php`, `.htaccess`,
`assets/`, `js/` dipindah ke `landakmas/public/`, lalu jalankan `php artisan storage:link`
untuk folder upload.

## Cara instalasi

1. `cd landakmas && composer install`
2. Salin `.env.example` menjadi `.env`, isi kredensial database & email yang sebenarnya
   (kredensial asli **tidak disertakan di repo ini** — diserahkan terpisah).
3. `php artisan key:generate`
4. Import struktur & data database dari `database-backup/landakmas_backup_2026-09-20.sql`
   ke MySQL, ATAU jalankan `php artisan migrate` untuk struktur tabel dari awal
   (lihat `landakmas/database/migrations`).
5. Jalankan lokal dengan `php artisan serve`, atau deploy ke hosting mengikuti
   struktur folder di atas.

## Catatan keamanan

- File `.env` asli (berisi password database & email) **sengaja tidak dimasukkan**
  ke repo ini. Minta file itu langsung ke pengelola sebelumnya, jangan commit ke
  Git meskipun repo ini private.
- `database-backup/*.sql` berisi data arsip yang sudah pernah tersimpan di sistem —
  perlakukan sebagai data internal dinas, jangan diunggah ke repo public.
- `landakmas/README.md` masih berisi catatan dari tahap awal pengembangan (sebelum
  database & autentikasi sungguhan ditambahkan) — sudah ditandai di bagian atasnya.
