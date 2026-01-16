<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilPengunjung extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'nama',
        'nomor_hp',
        'email',
        'alamat',
        'jenis_kelamin',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pengikuts()
    {
        return $this->belongsToMany(Pengikut::class, 'profil_pengunjung_pengikut');
    }
}
