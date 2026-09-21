<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    protected $fillable = [
        'instansi',
        'kode_klasifikasi',
        'nomor_arsip',
        'tahun',
        'uraian',
        'uraian_lengkap',
        'media',
        'status',
    ];

    protected $casts = [
        'media' => 'array',
    ];
}
