<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withProviders([
        App\Providers\BroadcastServiceProvider::class,
    ])
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');

        $middleware->alias([
            'role' => \App\Http\Middleware\EnsureUserHasRole::class,
        ]);

        if (env('APP_ENV') !== 'local' || env('FORCE_HTTPS', false)) {
            $middleware->append(\App\Http\Middleware\ForceHttps::class);
        }
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
