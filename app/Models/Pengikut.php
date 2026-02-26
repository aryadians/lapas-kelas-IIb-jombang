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

    /**
     * Accessor untuk URL Foto KTP.
     * Mendukung data Base64 maupun Path file.
     */
    public function getFotoKtpUrlAttribute(): ?string
    {
        if (empty($this->foto_ktp)) {
            return null;
        }

        // Jika diawali data:image, berarti Base64
        if (str_starts_with($this->foto_ktp, 'data:image')) {
            return $this->foto_ktp;
        }

        // Jika berupa path di storage
        return asset('storage/' . $this->foto_ktp);
    }

    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class);
    }
}
