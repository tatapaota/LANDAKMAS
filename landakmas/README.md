> **Catatan:** Dokumen di bawah ini ditulis pada tahap awal konversi (masih data
> dummy, belum ada database). Sejak itu project sudah berkembang jauh: sudah
> ada database MySQL sungguhan, autentikasi admin, import Excel, notifikasi
> email, dan lain-lain. Isi di bawah ini dibiarkan sebagai catatan sejarah
> pengembangan, bukan dokumentasi kondisi terkini. Lihat `README.md` di root
> repo untuk info instalasi yang berlaku sekarang.

# ARDARIKA — Versi Laravel (Tahap 1: Struktur & Routing)

Ini hasil konversi tampilan ARDARIKA (public site + admin panel) dari HTML/CSS/JS
murni ke struktur **Laravel (Blade + routing)**. Data masih dummy (persis seperti
versi HTML sebelumnya, ditulis langsung di JavaScript tiap halaman) — belum
tersambung ke database sungguhan.

## Kenapa harus di-install manual?

Environment yang dipakai untuk menyusun project ini tidak punya akses ke
Packagist/internet umum, jadi `composer install` tidak bisa dijalankan di sini.
Folder ini berisi **semua file custom ARDARIKA** (routes, controllers, views,
assets) tapi belum berisi `vendor/` (dependency Laravel).

## Cara menjalankan di komputermu

Butuh PHP 8.2+ dan Composer sudah terpasang.

**Opsi A — paling aman (disarankan):**

1. Buat project Laravel baru kosong di folder terpisah:
   ```
   composer create-project laravel/laravel:^11.0 ardarika-fresh
   ```
2. Salin (timpa) folder-folder berikut dari paket ini ke dalam `ardarika-fresh`:
   - `app/Http/Controllers/`
   - `resources/views/`
   - `routes/web.php`
   - `public/assets/`
   - `public/js/`
3. Masuk ke folder `ardarika-fresh`, jalankan:
   ```
   composer install
   php artisan key:generate
   php artisan serve
   ```
4. Buka `http://localhost:8000` untuk sisi publik, dan
   `http://localhost:8000/admin/login` untuk sisi admin
   (email: `adminarpusda@gmail.com`, password: `admin123` — masih hardcode di JS,
   sama seperti versi HTML sebelumnya).

**Opsi B — pakai langsung folder ini:**

1. Di dalam folder project ini, jalankan:
   ```
   composer install
   ```
   Composer akan membaca `composer.json` yang sudah disiapkan dan mengunduh
   Laravel Framework beserta dependency-nya ke `vendor/`.
2. Salin `.env.example` menjadi `.env`, lalu:
   ```
   php artisan key:generate
   php artisan serve
   ```

## Peta halaman

| Halaman lama (HTML)              | Route Laravel                  |
|-----------------------------------|---------------------------------|
| index.html                        | `/` (`home`)                    |
| Archive.html                      | `/arsip` (`archive`)            |
| Institution.html                  | `/instansi` (`institution`)     |
| Institution_detail.html           | `/instansi-detail?instansi=...` (`institution.detail`) |
| booking_arsip.html                | `/booking` (`booking`)          |
| ADMIN/Login.html                  | `/admin/login` (`admin.login`)  |
| ADMIN/Dashboard.html               | `/admin/dashboard` (`admin.dashboard`) |
| ADMIN/Archive.html                 | `/admin/arsip` (`admin.archive`) |
| ADMIN/Addarchive.html              | `/admin/arsip/tambah` (`admin.archive.create`) |
| ADMIN/PermintaanBooking.html       | `/admin/permintaan-booking` (`admin.booking`) |
| ADMIN/Manageaccount.html           | `/admin/kelola-akun` (`admin.account`) |

## Apa yang SUDAH dikerjakan di tahap ini

- Semua halaman dikonversi jadi Blade view, pakai layout bersama
  (`layouts.public`, `layouts.admin`, `layouts.guest` untuk halaman login).
- Navbar publik & sidebar admin jadi partial (`partials.navbar`,
  `partials.admin_sidebar`), dengan highlight menu aktif otomatis.
- Semua link antar halaman pakai `route()`, semua gambar pakai `asset()`.
- Data & interaktivitas (search, filter, pagination, form booking, form login,
  form tambah arsip, dsb) **masih jalan persis seperti sebelumnya** karena
  semua ditulis di JavaScript inline per halaman — tidak diubah logikanya,
  cuma dipindah wadahnya ke Blade.
- Route + Controller kosong (`bookingStore`, `login`, `archive.store`) sudah
  disiapkan sebagai **kerangka** untuk fase berikutnya (simpan ke database,
  kirim email riwayat booking, autentikasi admin beneran, sinkron booking ke
  admin) — tinggal diisi saat kamu siap lanjut ke tahap itu.

## Yang BELUM dikerjakan (sengaja, sesuai scope tahap ini)

- Belum ada database/migration/model.
- Form booking, login, dan tambah arsip masih disimulasikan di JavaScript
  (belum benar-benar mengirim data ke server Laravel).
- Belum ada pengiriman email riwayat booking yang sesungguhnya.
- Belum ada sinkronisasi data booking publik → admin (karena belum ada DB).

Kabari aku kalau mau lanjut ke tahap itu — alurnya: bikin migration
`bookings` & `archives`, model Eloquent, ganti form JS supaya submit beneran
ke `booking.store`, lalu kirim `Mail::to($email)->send(new BookingConfirmation(...))`.
