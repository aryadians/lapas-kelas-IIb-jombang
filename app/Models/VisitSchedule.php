<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitSchedule extends Model
{
    protected $fillable = [
        'day_of_week',
        'day_name',
        'is_open',
        'quota_online_morning',
        'quota_online_afternoon',
        'quota_offline_morning',
        'quota_offline_afternoon',
        'allowed_kode_tahanan'
    ];

    protected $casts = [
        'is_open' => 'boolean',
        'allowed_kode_tahanan' => 'array',
    ];
}
