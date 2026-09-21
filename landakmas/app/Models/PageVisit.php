<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageVisit extends Model
{
    /**
     * Tabel ini cuma dipakai untuk mencatat & menghitung kunjungan,
     * jadi tidak perlu kolom updated_at.
     */
    public $timestamps = false;

    protected $fillable = [
        'path',
        'label',
        'session_id',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}

