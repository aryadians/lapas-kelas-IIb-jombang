<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BroadcastRestrictionLog extends Model
{
    protected $fillable = [
        'triggered_by',
        'triggered_by_user_id',
        'total_wbp_processed',
        'total_wbp_no_restriction',
        'total_kunjungan_cancelled',
        'total_notifications_queued',
        'status',
        'notes',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function details(): HasMany
    {
        return $this->hasMany(BroadcastRestrictionLogDetail::class);
    }

    public function triggeredByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'triggered_by_user_id');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'success'       => '<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700"><i class="fas fa-check-circle"></i> Sukses</span>',
            'no_impact'     => '<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600"><i class="fas fa-minus-circle"></i> Tidak Ada Dampak</span>',
            'partial_error' => '<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700"><i class="fas fa-exclamation-triangle"></i> Sebagian Error</span>',
            'failed'        => '<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700"><i class="fas fa-times-circle"></i> Gagal</span>',
            default         => '<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600">—</span>',
        };
    }

    public function getTriggeredByBadgeAttribute(): string
    {
        if ($this->triggered_by === 'scheduler') {
            return '<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700"><i class="fas fa-clock"></i> Otomatis (Scheduler)</span>';
        }
        $user = $this->triggeredByUser?->name ?? 'Admin';
        return '<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-700"><i class="fas fa-user"></i> Manual oleh ' . e($user) . '</span>';
    }
}
