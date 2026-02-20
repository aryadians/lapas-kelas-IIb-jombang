<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'year',
        'description',
        'file_path',
        'is_published'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'year' => 'integer'
    ];
}
