<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wbp extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi ke Kunjungan (Satu WBP punya Banyak Kunjungan)
    public function kunjungans()
    {
        return $this->hasMany(Kunjungan::class, 'wbp_id');
    }
}
