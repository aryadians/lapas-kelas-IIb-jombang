<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'file_path',
        'is_active',
        'order_index',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($banner) {
            \Illuminate\Support\Facades\Cache::forget('active_banners');
        });

        static::deleted(function ($banner) {
            \Illuminate\Support\Facades\Cache::forget('active_banners');
        });
    }
}
