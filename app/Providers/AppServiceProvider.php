<?php

namespace App\Providers;

use App\Models\Kunjungan;
use App\Observers\KunjunganObserver;
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
    }
}
