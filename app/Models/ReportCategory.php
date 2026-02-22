<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportCategory extends Model
{
    protected $fillable = ['name', 'icon', 'emoji', 'sort_order'];

    public function financialReports()
    {
        return $this->hasMany(FinancialReport::class, 'category', 'name');
    }

    /**
     * Kategori yang "dalam penggunaan" (ada laporan yang pakai).
     */
    public function isInUse(): bool
    {
        return FinancialReport::where('category', $this->name)->exists();
    }

    public static function ordered()
    {
        return static::orderBy('sort_order')->orderBy('name');
    }
}
