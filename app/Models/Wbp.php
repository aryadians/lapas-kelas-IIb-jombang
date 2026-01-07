<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wbp extends Model
{
    use HasFactory;

    // Field yang boleh diisi (untuk import Excel)
    protected $guarded = ['id'];

    public function kunjungans()
    {
        return $this->hasMany(Kunjungan::class);
    }
}
