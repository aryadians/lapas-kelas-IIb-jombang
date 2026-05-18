<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstitutionalInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'title',
        'content',
        'type'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($info) {
            \Illuminate\Support\Facades\Cache::forget('institutional_info');
        });

        static::deleted(function ($info) {
            \Illuminate\Support\Facades\Cache::forget('institutional_info');
        });
    }
}
