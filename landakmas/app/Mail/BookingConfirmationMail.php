<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param array<string, mixed> $peminjam Data peminjam (nama, telepon, email, alamat, tujuan, tanggal_pengambilan, waktu_pengambilan)
     * @param array<int, array<string, mixed>> $arsipList Daftar arsip yang dibooking (no, kode, uraian, instansi, tahun)
     */
    public function __construct(
        public array $peminjam,
        public array $arsipList,
    ) {}

    public function build(): self
    {
        return $this
            ->subject('Jadwal Pengambilan Arsip Sudah Ditentukan - LANDAKMAS')
            ->markdown('emails.booking_confirmation')
            ->with([
                'peminjam'  => $this->peminjam,
                'arsipList' => $this->arsipList,
            ]);
    }
}
