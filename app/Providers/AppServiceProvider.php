<?php

namespace App\Providers;

use App\Models\FinancialReport;
use App\Models\Kunjungan;
use App\Models\ReportCategory;
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
            $view->with('navCategories', ReportCategory::ordered()->get(['name','icon','emoji']));
        });
    }
}

