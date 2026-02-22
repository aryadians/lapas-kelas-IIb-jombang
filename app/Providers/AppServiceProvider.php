<?php

namespace App\Providers;

use App\Models\FinancialReport;
use App\Models\Kunjungan;
use App\Observers\KunjunganObserver;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Kunjungan::observe(KunjunganObserver::class);

        // ── View Composer: inject kategori laporan ke navbar ──
        View::composer('layouts.main', function ($view) {
            $defaults = collect(['LHKPN', 'LAKIP', 'Keuangan', 'Renstra', 'Profil Lapas', 'RKT']);
            $dbCats   = FinancialReport::select('category')
                ->where('is_published', true)
                ->distinct()
                ->orderBy('category')
                ->pluck('category');

            $view->with('navCategories', $defaults->merge($dbCats)->unique()->values());
        });
    }
}

