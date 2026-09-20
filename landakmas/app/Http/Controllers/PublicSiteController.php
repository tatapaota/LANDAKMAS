<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\BookingRequest;
use App\Models\PageVisit;
use App\Support\VisitorStats;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class PublicSiteController extends Controller
{
    /**
     * Ekstensi gambar, dipakai untuk menentukan cover mana yang boleh
     * ditampilkan sebagai thumbnail (bukan icon dokumen generik).
     */
    private array $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    /**
     * Ubah satu model Arsip jadi bentuk array yang dipakai JS di halaman
     * publik (kode, instansi, tahun, no, status, uraian, media). Dipakai
     * bersama oleh home(), archive(), dan institutionDetail() supaya
     * bentuk datanya selalu konsisten.
     */
    private function mapArsipForJs(Arsip $item): array
    {
        $media = collect($item->media ?? [])->map(function ($path) {
            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

            return [
                'name'    => basename($path),
                'isImage' => in_array($ext, $this->imageExtensions),
                'dataUrl' => asset('storage/' . $path),
            ];
        })->values();

        return [
            'id'       => $item->id,
            'kode'     => $item->kode_klasifikasi ?: '-',
            'instansi' => $item->instansi,
            'tahun'    => $item->tahun,
            'no'       => $item->nomor_arsip ?: '-',
            // Status "tersedia" / "dipinjam" (kolom arsips.status). Arsip
            // otomatis jadi "dipinjam" begitu dibooking (lihat
            // bookingStore()), dan balik "tersedia" begitu admin klik
            // "Kembalikan Dokumen" di halaman Permintaan Booking (lihat
            // BookingController::returnDocument()).
            'status'   => $item->status === 'dipinjam' ? 'tidak-tersedia' : 'tersedia',
            'uraian'   => $item->uraian_lengkap ?: ($item->uraian ?: '-'),
            'media'    => $media,
        ];
    }

    /**
     * Catat satu kunjungan halaman publik ke tabel page_visits, dipakai
     * untuk kartu "Statistik Pengunjung" di Beranda. $label adalah nama
     * halaman yang ramah-baca (tampil di "Post Terpopuler").
     *
     * session_id disimpan supaya VisitorStats::pageVisitSummary() bisa
     * menghitung PENGUNJUNG UNIK (satu sesi browser = satu pengunjung),
     * bukan menghitung setiap halaman yang dibuka sebagai pengunjung
     * baru — itu sebabnya sebelumnya angkanya kelihatan tidak akurat.
     */
    private function logVisit(Request $request, string $label): void
    {
        try {
            PageVisit::create([
                'path'       => $request->path(),
                'label'      => $label,
                'session_id' => $request->hasSession() ? $request->session()->getId() : null,
                'created_at' => now(),
            ]);
        } catch (\Throwable $e) {
            // Kalau pencatatan gagal (mis. tabel belum ter-migrate),
            // jangan sampai halaman publik ikut error 500.
            report($e);
        }
    }

    /**
     * Ambil ringkasan statistik pengunjung (hari ini/minggu ini/bulan
     * ini/tahun ini/total) + halaman yang paling banyak dikunjungi,
     * dipakai kartu "Statistik Pengunjung" di Beranda publik. Sumber
     * datanya sama persis dengan yang dipakai Dashboard admin (lihat
     * VisitorStats::pageVisitSummary()), supaya angka di kedua halaman
     * selalu konsisten.
     */
    private function visitorStatsForHome(): array
    {
        return VisitorStats::pageVisitSummary();
    }

    /**
     * Endpoint JSON untuk kartu "Statistik Pengunjung" di Beranda publik.
     * Di-polling otomatis lewat JS (lihat resources/views/User/home.blade.php)
     * supaya angkanya ikut naik "realtime" tanpa perlu reload halaman
     * setiap ada pengunjung baru.
     */
    public function visitorStatsJson()
    {
        return response()->json($this->visitorStatsForHome());
    }

    public function home(Request $request)
    {
        $this->logVisit($request, 'Beranda');

        $totalArsip = Arsip::count();

        $instansiCounts = Arsip::whereNotNull('instansi')
            ->where('instansi', '!=', '')
            ->selectRaw('instansi, count(*) as jumlah')
            ->groupBy('instansi')
            ->orderByDesc('jumlah')
            ->get();

        $tahunAngka = Arsip::whereNotNull('tahun')
            ->pluck('tahun')
            ->map(fn($t) => (int) $t)
            ->filter(fn($t) => $t > 0);

        $featuredInstitutions = $instansiCounts->take(4)->map(function ($row) {
            return [
                'slug'   => Str::slug($row->instansi),
                'nama'   => $row->instansi,
                'jumlah' => $row->jumlah,
            ];
        })->values();

        $homeArchivesJs = Arsip::latest()->take(4)->get()
            ->map(fn($item) => $this->mapArsipForJs($item))
            ->values();

        return view('User.home', array_merge([
            'statTotalArsip'       => $totalArsip,
            'statTotalInstansi'    => $instansiCounts->count(),
            'statTahunAwal'        => $tahunAngka->min() ?: 1985,
            'statTahunAkhir'       => $tahunAngka->max() ?: now()->year,
            'featuredInstitutions' => $featuredInstitutions,
            'homeArchivesJs'       => $homeArchivesJs,
        ], $this->visitorStatsForHome()));
    }

    public function archive(Request $request)
    {
        $this->logVisit($request, 'Cari Arsip');

        $arsipsJs = Arsip::orderBy('kode_klasifikasi')->get()
            ->map(fn($item) => $this->mapArsipForJs($item))
            ->values();

        return view('User.archive', compact('arsipsJs'));
    }

    public function institution(Request $request)
    {
        $this->logVisit($request, 'Daftar Instansi');

        $institutionsJs = Arsip::whereNotNull('instansi')
            ->where('instansi', '!=', '')
            ->selectRaw('instansi, count(*) as jumlah')
            ->groupBy('instansi')
            ->orderBy('instansi')
            ->get()
            ->map(fn($row) => [
                'slug'        => Str::slug($row->instansi),
                'nama'        => $row->instansi,
                'deskripsi'   => $row->jumlah . ' arsip tersimpan',
                'jumlahArsip' => $row->jumlah,
            ])
            ->values();

        return view('User.institution', compact('institutionsJs'));
    }

    public function institutionDetail(Request $request)
    {
        $slug = $request->query('instansi', '');

        // Instansi disimpan sebagai teks bebas di tabel arsips, jadi
        // slug di URL dicocokkan balik ke nama aslinya dengan
        // membandingkan slug tiap instansi yang benar-benar ada datanya.
        $namaInstansi = Arsip::whereNotNull('instansi')
            ->where('instansi', '!=', '')
            ->distinct()
            ->pluck('instansi')
            ->first(fn($nama) => Str::slug($nama) === $slug);

        if (!$namaInstansi) {
            $this->logVisit($request, 'Instansi Tidak Ditemukan');

            return view('User.institution_detail', [
                'namaInstansi' => 'Instansi Tidak Ditemukan',
                'deskripsi'    => '-',
                'arsipsJs'     => collect(),
            ]);
        }

        $this->logVisit($request, $namaInstansi);

        $arsipsJs = Arsip::where('instansi', $namaInstansi)
            ->orderBy('kode_klasifikasi')
            ->get()
            ->map(fn($item) => $this->mapArsipForJs($item))
            ->values();

        return view('User.institution_detail', [
            'namaInstansi' => $namaInstansi,
            'deskripsi'    => $arsipsJs->count() . ' arsip tersimpan',
            'arsipsJs'     => $arsipsJs,
        ]);
    }

    public function booking(Request $request)
    {
        $this->logVisit($request, 'Permintaan Arsip');

        return view('User.booking');
    }

    /**
     * Simpan permintaan booking ke database. Satu arsip di keranjang =
     * satu baris di tabel booking_requests (konsisten dengan tabel
     * "Permintaan Booking" di admin, yang sebelumnya baca dari
     * localStorage per baris arsip juga).
     *
     * Body request dikirim sebagai JSON oleh form di halaman booking
     * (lihat resources/views/User/booking.blade.php), berisi data
     * peminjam + daftar arsip yang ada di keranjang (dari keranjang.js).
     */
    public function bookingStore(Request $request)
    {
        $validated = $request->validate([
            // Nama cuma boleh huruf & spasi (termasuk huruf beraksen),
            // supaya tidak kecolongan input asal seperti "6899hjjs".
            'nama'                 => ['required', 'string', 'max:255', 'regex:/^[\pL\s]+$/u'],
            // Nomor telepon wajib angka semua, minimal 12 & maksimal 15
            // digit (mis. 08xxxxxxxxxx).
            'telepon'              => ['required', 'digits_between:12,15'],
            // "email:rfc,dns" memastikan formatnya valid DAN domainnya
            // benar-benar punya MX record (server penerima email aktif),
            // supaya email asal/ngasal seperti "a@a.a" tidak lolos.
            'email'                => ['required', 'email:rfc,dns', 'max:255'],
            'alamat'               => 'required|string',
            'tujuan'               => 'required|string',
            'tanggal_pengambilan'  => 'required|date|after_or_equal:today',
            'arsip'                => 'required|array|min:1',
            'arsip.*.id'           => 'nullable',
            'arsip.*.no'           => 'nullable|string',
            'arsip.*.kode'         => 'nullable|string',
            'arsip.*.uraian'       => 'nullable|string',
            'arsip.*.instansi'     => 'nullable|string',
            'arsip.*.tahun'        => 'nullable',
        ], [
            'nama.regex'          => 'Nama lengkap hanya boleh diisi huruf dan spasi.',
            'telepon.digits_between' => 'Nomor telepon wajib berupa angka, minimal 12 dan maksimal 15 digit.',
            'email.email'         => 'Masukkan alamat email yang valid dan benar-benar terdaftar (bukan email asal/palsu).',
        ]);

        foreach ($validated['arsip'] as $item) {
            $arsipId = is_numeric($item['id'] ?? null) ? $item['id'] : null;

            BookingRequest::create([
                'arsip_id'             => $arsipId,
                'nama'                 => $validated['nama'],
                'telepon'              => $validated['telepon'],
                'email'                => $validated['email'],
                'alamat'               => $validated['alamat'],
                'tujuan'               => $validated['tujuan'],
                'tanggal_pengambilan'  => $validated['tanggal_pengambilan'],
                'arsip_no'             => $item['no'] ?? null,
                'arsip_kode'           => $item['kode'] ?? null,
                'arsip_uraian'         => $item['uraian'] ?? null,
                'arsip_instansi'       => $item['instansi'] ?? null,
                'arsip_tahun'          => $item['tahun'] ?? null,
                'status'               => 'diproses',
            ]);

            // Arsip yang baru dibooking langsung ditandai "dipinjam" supaya
            // tidak tampil "Tersedia" lagi di halaman publik, sampai admin
            // menandainya "Kembalikan Dokumen" di Permintaan Booking.
            if ($arsipId) {
                Arsip::where('id', $arsipId)->update(['status' => 'dipinjam']);
            }
        }

        // Email riwayat booking TIDAK dikirim otomatis di sini. User baru
        // menerima email setelah admin menentukan "Waktu Pengambilan
        // Arsip" dan menekan tombol "Kirim ke Email Peminjam" di halaman
        // admin Permintaan Booking (lihat Admin\BookingController).
        return response()->json(['status' => 'ok']);
    }
}
