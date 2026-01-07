<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_pengunjung',
        'nik_pengunjung',
        'no_wa_pengunjung',
        'email_pengunjung',
        'alamat_pengunjung',
        'nama_wbp',
        'hubungan',
        'tanggal_kunjungan',
        'sesi',
        'nomor_antrian_harian',
        'status',
        'qr_token',
        // --- TAMBAHAN BARU ---
        'wbp_id',
        'total_pengikut',
        'data_pengikut'
    ];
    // --- TAMBAHAN BARU ---
    protected $casts = [
        'data_pengikut' => 'array', // Agar otomatis jadi Array/JSON
    ];

    public function wbp()
    {
        return $this->belongsTo(Wbp::class);
    }
}
