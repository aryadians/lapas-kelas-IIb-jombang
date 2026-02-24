<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'display_name',
        'type'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($setting) {
            \Illuminate\Support\Facades\Cache::forget('visit_settings');
        });

        static::deleted(function ($setting) {
            \Illuminate\Support\Facades\Cache::forget('visit_settings');
        });
    }
}
