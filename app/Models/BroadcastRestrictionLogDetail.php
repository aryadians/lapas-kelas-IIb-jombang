<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BroadcastRestrictionLogDetail extends Model
{
    protected $fillable = [
        'broadcast_restriction_log_id',
        'wbp_id',
        'wbp_nama',
        'restriction_type',
        'restriction_start',
        'restriction_end',
        'kunjungan_id',
        'kode_booking',
        'tanggal_kunjungan',
        'pengunjung_nama',
        'pengunjung_wa',
        'pengunjung_email',
        'wa_queued',
        'email_queued',
        'action',
        'error_message',
    ];

    protected $casts = [
        'wa_queued'         => 'boolean',
        'email_queued'      => 'boolean',
        'restriction_start' => 'date',
        'restriction_end'   => 'date',
        'tanggal_kunjungan' => 'date',
    ];

    public function log(): BelongsTo
    {
        return $this->belongsTo(BroadcastRestrictionLog::class, 'broadcast_restriction_log_id');
    }

    public function wbp(): BelongsTo
    {
        return $this->belongsTo(Wbp::class)->withTrashed();
    }

    public function kunjungan(): BelongsTo
    {
        return $this->belongsTo(Kunjungan::class);
    }

    public function getActionBadgeAttribute(): string
    {
        return match ($this->action) {
            'cancelled'      => '<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700"><i class="fas fa-ban"></i> Dibatalkan</span>',
            'no_restriction' => '<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-500"><i class="fas fa-minus"></i> Tanpa Pembatasan</span>',
            'error'          => '<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-700"><i class="fas fa-exclamation"></i> Error</span>',
            default          => '<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-500">' . e($this->action) . '</span>',
        };
    }
}
