<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'allow' => \App\Http\Middleware\AllowMiddleware::class,
        ]);
    })
    ->withSchedule(function (\Illuminate\Console\Scheduling\Schedule $schedule) {
        $schedule->call(\App\Jobs\CheckWebsiteStatus::class)->everyMinute();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->dontReport([
            \Mary\Exceptions\ToastException::class
        ]);
    })->create();
