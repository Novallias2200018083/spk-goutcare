<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\CheckRole;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Daftarkan alias 'role' di sini
        $middleware->alias([
            'role' => CheckRole::class,
        ]);
        
        // Pengecualian CSRF agar tidak 419 saat sesi lama
        $middleware->validateCsrfTokens(except: [
            'pasien/rekomendasi/hitung'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
