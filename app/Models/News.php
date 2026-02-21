<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    /**
     * Menentukan nama tabel (Opsional jika nama tabelnya 'news')
     * Tapi bagus untuk memastikan.
     */
    protected $table = 'news';

    /**
     * PENTING: $fillable
     * Kolom-kolom ini diizinkan untuk diisi secara massal
     * melalui News::create() atau $news->update().
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'videos',
        'status',
    ];

    /**
     * Format tanggal (Opsional)
     * Agar created_at otomatis jadi objek Carbon
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'image'      => 'array',
        'videos'     => 'array',
    ];
}