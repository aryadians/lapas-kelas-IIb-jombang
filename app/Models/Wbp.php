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

    // Riwayat pembatasan kunjungan
    public function restrictions()
    {
        return $this->hasMany(WbpRestriction::class, 'wbp_id');
    }

    // Pembatasan kunjungan yang sedang aktif hari ini
    public function activeRestriction()
    {
        return $this->hasOne(WbpRestriction::class, 'wbp_id')
            ->whereDate('start_date', '<=', now()->toDateString())
            ->whereDate('end_date', '>=', now()->toDateString())
            ->latest('id');
    }

    // Pembatasan kunjungan yang aktif hari ini ATAU di masa depan (untuk tampilan Admin)
    public function latestRestriction()
    {
        return $this->hasOne(WbpRestriction::class, 'wbp_id')
            ->whereDate('end_date', '>=', now()->toDateString())
            ->latest('start_date');
    }
}
