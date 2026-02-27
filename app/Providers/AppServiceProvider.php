<?php

namespace App\Providers;

use App\Models\FinancialReport;
use App\Models\Kunjungan;
use App\Models\ReportCategory;
use App\Observers\KunjunganObserver;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\VisitSetting;

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
        if (env('FORCE_HTTPS', false)) {
            $host = request()->getHost();
            if (!in_array($host, ['localhost', '127.0.0.1', '::1'])) {
                \Illuminate\Support\Facades\URL::forceScheme('https');
            }
        }

        RateLimiter::for('guest_submission', function (Request $request) {
            return Limit::perMinute(3)->by($request->ip());
        });

        Kunjungan::observe(KunjunganObserver::class);

        // ── View Composer: inject kategori laporan ke navbar ──
        View::composer('layouts.main', function ($view) {
            $view->with('navCategories', ReportCategory::ordered()->get(['name','icon','emoji']));
        });

        // ── Dynamic Mail Configuration from Database ──
        try {
            if (Schema::hasTable('visit_settings')) {
                $mailSettings = VisitSetting::whereIn('key', [
                    'mail_host', 'mail_port', 'mail_username', 'mail_password', 'mail_encryption', 'mail_from_address', 'admin_email'
                ])->pluck('value', 'key');
                
                if ($mailSettings->isNotEmpty()) {
                    $configUpdates = [];
                    if (!empty($mailSettings['mail_host'])) $configUpdates['mail.mailers.smtp.host'] = $mailSettings['mail_host'];
                    if (!empty($mailSettings['mail_port'])) $configUpdates['mail.mailers.smtp.port'] = $mailSettings['mail_port'];
                    if (!empty($mailSettings['mail_username'])) $configUpdates['mail.mailers.smtp.username'] = $mailSettings['mail_username'];
                    if (!empty($mailSettings['mail_password'])) $configUpdates['mail.mailers.smtp.password'] = $mailSettings['mail_password'];
                    if (!empty($mailSettings['mail_encryption'])) $configUpdates['mail.mailers.smtp.encryption'] = $mailSettings['mail_encryption'];
                    if (!empty($mailSettings['mail_from_address'])) $configUpdates['mail.from.address'] = $mailSettings['mail_from_address'];
                    if (!empty($mailSettings['admin_email'])) $configUpdates['mail.admin_email'] = $mailSettings['admin_email'];

                    if (!empty($configUpdates)) {
                        config($configUpdates);
                    }
                }
            }
        } catch (\Exception $e) {
            // Ignore during migrations or initial setup
        }
    }
}

