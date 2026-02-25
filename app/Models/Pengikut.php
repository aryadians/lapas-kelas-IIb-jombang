<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengikut extends Model
{
    use HasFactory;

    protected $fillable = [
        'kunjungan_id',
        'nama',
        'nik',
        'hubungan',
        'barang_bawaan',
        'foto_ktp',
        'foto_ktp_path',
        'foto_ktp_processed_at',
        'barcode'
    ];

    protected $dates = [
        'foto_ktp_processed_at'
    ];

    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class);
    }
}
