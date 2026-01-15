<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Wbp extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = ['id'];

    /**
     * Konfigurasi logging aktivitas untuk model WBP.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable() // Log semua atribut yang ada di $fillable atau guarded jika fillable tidak ada
            ->logOnlyDirty() // Hanya log atribut yang berubah
            ->setDescriptionForEvent(fn(string $eventName) => "Data WBP telah di{$eventName}")
            ->useLogName('wbp'); // Nama log kustom
    }

    // Relasi ke Kunjungan (Satu WBP punya Banyak Kunjungan)
    public function kunjungans()
    {
        return $this->hasMany(Kunjungan::class, 'wbp_id');
    }
}
