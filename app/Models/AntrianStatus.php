<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntrianStatus extends Model
{
    use HasFactory;

    protected $table = 'antrian_status';

    protected $fillable = [
        'tanggal',
        'sesi',
        'nomor_terpanggil',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];
}
