<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\BookingConfirmationMail;
use App\Models\Arsip;
use App\Models\BookingRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    public function index()
    {
        // Booking.store (sisi publik) sekarang menyimpan langsung ke
        // tabel booking_requests, jadi daftar ini otomatis tersinkron
        // untuk semua admin/perangkat tanpa perlu localStorage lagi.
        $bookings = BookingRequest::latest()->get();

        // Disiapkan di controller (bukan langsung di dalam @json() pada
        // blade) supaya file blade tidak perlu menulis closure PHP
        // multi-baris di dalam satu directive - itu yang kemarin bikin
        // Blade salah menghitung tanda kurung dan errornya jadi
        // "ParseError: Unclosed '[' ...".
        $bookingsForJs = $bookings->map(function ($b) {
            return [
                'id' => $b->id,
                'nama' => $b->nama,
                'telepon' => $b->telepon,
                'email' => $b->email,
                'alamat' => $b->alamat,
                'tujuan' => $b->tujuan,
                'arsip' => [
                    'no' => $b->arsip_no,
                    'kode' => $b->arsip_kode,
                    'uraian' => $b->arsip_uraian,
                    'instansi' => $b->arsip_instansi,
                    'tahun' => $b->arsip_tahun,
                ],
                'tanggal' => optional($b->created_at)->toIso8601String(),
                'tanggalPengambilan' => optional($b->tanggal_pengambilan)->format('Y-m-d'),
                'waktuPengambilan' => $b->waktu_pengambilan,
                'status' => $b->status,
                'dikembalikanAt' => optional($b->dikembalikan_at)->toIso8601String(),
                'emailTerkirimAt' => optional($b->email_terkirim_at)->toIso8601String(),
            ];
        })->values();

        // Statistik pengunjung di dashboard admin diambil dari data
        // masyarakat yang sudah menyelesaikan (mengirim) permintaan
        // booking — lihat DashboardController@index untuk versi yang
        // dipakai di kartu dashboard.

        return view('admin.permintaan_booking', compact('bookings', 'bookingsForJs'));
    }

    /**
     * Admin menentukan tanggal & jam final peminjam harus datang
     * mengambil arsip. Tanggal yang dipilih user saat mengisi formulir
     * booking cuma permintaan awal — admin yang berhak menggeser
     * tanggalnya (mis. kalau tanggal itu penuh/kantor tutup) sekaligus
     * menentukan jamnya, sebelum jadwal final ini dikirim ke email
     * peminjam. Disimpan dulu terpisah dari pengiriman email supaya
     * admin bisa mengubahnya beberapa kali sebelum benar-benar menekan
     * tombol "Kirim ke Email Peminjam".
     */
    public function setWaktu(Request $request, BookingRequest $booking): JsonResponse
    {
        try {
            $validated = $request->validate([
                'tanggal_pengambilan' => ['required', 'date'],
                'waktu_pengambilan'   => ['required', 'date_format:H:i'],
            ]);
        } catch (ValidationException $e) {
            return response()->json(['status' => 'error', 'message' => 'Tanggal atau waktu pengambilan tidak valid.'], 422);
        }

        $booking->update([
            'tanggal_pengambilan' => $validated['tanggal_pengambilan'],
            'waktu_pengambilan'   => $validated['waktu_pengambilan'],
        ]);

        return response()->json(['status' => 'ok', 'booking' => $booking->fresh()]);
    }

    /**
     * Kirim email persetujuan booking ke peminjam. Ini SATU-SATUNYA
     * jalur pengiriman email riwayat booking (lihat catatan di
     * PublicSiteController::bookingStore(), yang sekarang tidak lagi
     * mengirim email otomatis). Wajib sudah ada "waktu_pengambilan"
     * yang ditentukan admin sebelum email boleh dikirim.
     */
    public function sendEmail(BookingRequest $booking): JsonResponse
    {
        if (!$booking->waktu_pengambilan) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Tentukan waktu pengambilan arsip terlebih dahulu sebelum mengirim email.',
            ], 422);
        }

        $peminjam = [
            'nama'                 => $booking->nama,
            'telepon'              => $booking->telepon,
            'email'                => $booking->email,
            'alamat'               => $booking->alamat,
            'tujuan'               => $booking->tujuan,
            'tanggal_pengambilan'  => optional($booking->tanggal_pengambilan)->format('Y-m-d'),
            'waktu_pengambilan'    => $booking->waktu_pengambilan,
        ];

        $arsipList = [[
            'no'       => $booking->arsip_no,
            'kode'     => $booking->arsip_kode,
            'uraian'   => $booking->arsip_uraian,
            'instansi' => $booking->arsip_instansi,
            'tahun'    => $booking->arsip_tahun,
        ]];

        try {
            Mail::to($booking->email)->send(
                new BookingConfirmationMail($peminjam, $arsipList)
            );
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal mengirim email. Periksa kembali pengaturan email server.',
            ], 500);
        }

        $booking->update(['email_terkirim_at' => now()]);

        return response()->json(['status' => 'ok', 'booking' => $booking->fresh()]);
    }

    /**
     * Tandai satu permintaan booking sebagai "dikembalikan": dokumennya
     * sudah selesai dipinjam dan balik lagi ke rak, jadi arsip terkait
     * ditandai "tersedia" lagi di halaman publik. Dipanggil lewat fetch()
     * (AJAX) dari tombol "Kembalikan Dokumen", konsisten dengan pola
     * update/destroy di ArchiveController.
     */
    public function returnDocument(BookingRequest $booking): JsonResponse
    {
        if ($booking->status !== 'dikembalikan') {
            $booking->update([
                'status'          => 'dikembalikan',
                'dikembalikan_at' => now(),
            ]);

            if ($booking->arsip_id) {
                Arsip::where('id', $booking->arsip_id)->update(['status' => 'tersedia']);
            }
        }

        return response()->json(['status' => 'ok', 'booking' => $booking->fresh()]);
    }
}
