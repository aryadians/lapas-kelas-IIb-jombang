<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jabatan',
        'seksi',
        'level',
        'foto',
        'quotes',
        'order_index',
    ];
}
