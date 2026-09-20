<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingRequest extends Model
{
    protected $fillable = [
        'arsip_id',
        'nama',
        'telepon',
        'email',
        'alamat',
        'tujuan',
        'tanggal_pengambilan',
        'waktu_pengambilan',
        'arsip_no',
        'arsip_kode',
        'arsip_uraian',
        'arsip_instansi',
        'arsip_tahun',
        'status',
        'dikembalikan_at',
        'email_terkirim_at',
    ];

    protected $casts = [
        'tanggal_pengambilan' => 'date',
        'dikembalikan_at'     => 'datetime',
        'email_terkirim_at'   => 'datetime',
    ];

    public function arsip()
    {
        return $this->belongsTo(Arsip::class);
    }
}
