<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database (Opsional, jika default 'kunjungans' tidak perlu ditulis)
     */
    protected $table = 'kunjungans';

    /**
     * Daftar kolom yang boleh diisi secara massal (Mass Assignment).
     * Harus sesuai dengan nama kolom di database.
     */
    // PASTIKAN ISINYA SAMA PERSIS SEPERTI INI
    protected $fillable = [
        'kode_kunjungan',
        'nomor_antrian_harian',
        'wbp_id',
        'nama_pengunjung',
        'nik_ktp',

        // INI YANG BIKIN ERROR TADI (Harus sesuai nama kolom database)
        'no_wa_pengunjung',   // <--- Jangan tulis 'nomor_hp'
        'email_pengunjung',
        'alamat_pengunjung',  // <--- Jangan tulis 'alamat_lengkap'
        'barang_bawaan',

        'jenis_kelamin',
        'hubungan',
        'tanggal_kunjungan',
        'sesi',
        'foto_ktp',
        'status',
        'qr_token',
        'pengikut_laki',
        'pengikut_perempuan',
        'pengikut_anak'
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
    ];

    /**
     * RELASI KE MODEL WBP
     * Satu Kunjungan tertuju pada Satu WBP.
     */
    public function wbp()
    {
        // belongsTo('ModelTujuan', 'foreign_key_di_tabel_ini')
        return $this->belongsTo(Wbp::class, 'wbp_id');
    }
    public function pengikuts()
    {
        return $this->hasMany(Pengikut::class);
    }
}
