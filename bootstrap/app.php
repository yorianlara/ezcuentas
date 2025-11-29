<?php

use App\Http\Middleware\EsquemaEmpresa;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Registrar middleware global
        $middleware->web(append: [
            EsquemaEmpresa::class,
        ]);

        $middleware->api(append: [
            EsquemaEmpresa::class,
        ]);

        // Alias para los middlewares
        $middleware->alias([
            'esquema' => EsquemaEmpresa::class,
            'admin' => AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();