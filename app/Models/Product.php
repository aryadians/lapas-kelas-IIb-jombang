<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'price',
        'stock',
        'wbp_creator_id',
        'status',
    ];

    /**
     * Get the WBP who created the product.
     */
    public function creator()
    {
        return $this->belongsTo(Wbp::class, 'wbp_creator_id');
    }
}
